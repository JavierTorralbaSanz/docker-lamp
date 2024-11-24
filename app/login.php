<?php

include "config.php";


//Funcion que registra los logs en un .txt 
    $logFile = '/var/www/html/access.txt';
    $currentDateTime = date('Y-m-d H:i:s');
    $ipAddress = $_SERVER['REMOTE_ADDR'];
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    $requestUri = $_SERVER['REQUEST_URI'];


        //Constructor de mensaje que se escribira en el access.txt 
        $logMessage = "[$currentDateTime] $ipAddress  - $message - \"$requestUri\" \"$userAgent\"" . PHP_EOL;
    

        file_put_contents($logFile, $logMessage, FILE_APPEND);
    
        
}


//Genera un token CSRF y lo almacena en la sesion si no existe
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

function generarCodAleatorio($longitud=6)
{
    $caracteres='ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $texto='';
    for ($i=0; $i < $longitud;$i++)
    {
        $texto .=$caracteres[rand(0,strlen($caracteres)-1)];
    }
    return $texto;
}
function generarCodMate($longitud=3)
{
    $funciones='+-*';
    $numeros="0123456789";
    $texto='';
    for ($i=0; $i < $longitud;$i++)
    {
        if ($i==1){
            $texto .=$funciones[rand(0,strlen($funciones)-1)];
        }
        else{
            $texto .=$numeros[rand(0,strlen($numeros)-1)];
        }
    }
    $calculo=0;
    if ($texto[1] == "+") {
        $calculo = (int)$texto[0] + (int)$texto[2];
    } elseif ($texto[1] == "-") {
        $calculo = (int)$texto[0] - (int)$texto[2]; 
    } else {
        $calculo = (int)$texto[0] * (int)$texto[2];
    }
    
    return [
        'calculo'=>$calculo,
        'texto_cal'=>$texto];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    //Verifica el token CSRF antes de procesar el inicio de sesion
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        error_log("Token CSRF invalido. Se esperaba " . $_SESSION['csrf_token'] . ", se obtuvo "
        . $_POST['csrf_token']);
        die("Error: Token CSRF invalido.");
    }

    //Obtener datos del usuario
    $nombreUsuario = $_POST['nombre'];
    $contraseña = $_POST['contraseña'];
    $codigoIngresado = $_POST['codigo_ingresado'];
    $codigoGuardado = $_SESSION['cod_veri'];
    $calculoIngresado= $_POST['cal_ingresado'];
    $calGuardado = $_SESSION['calculo'];
    //Proceso para conectarese a la base de datos
    

    //Preparar la consulta para obtener el hash de la contraseña
    $sql = "SELECT contraseña FROM usuarios WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nombreUsuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0 && $codigoGuardado == $codigoIngresado && $calculoIngresado == (string)$calGuardado) {
        $row = $resultado->fetch_assoc();
        
        //Usar password_verify para comparar la contraseña ingresada con el hash
        if (password_verify($contraseña, $row['contraseña'])) {
            $_SESSION['usuario'] = $nombreUsuario;
            access_log($conn, "Inicio de sesion correcto");
            echo '<head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Inicio de Sesión</title>
                <link rel="stylesheet" href="estilos.css">
                </head>
                <body>
                <div class="message-container">
                    <h1>Inicio de sesión exitoso. Bienvenido ' . htmlspecialchars($nombreUsuario) . '</h1>
                    <a href="/" class="link-button">Ir a la Página Principal</a>
                </div>
                </body>';
            exit; 
        } else{
            access_log($conn, "Nombre de usuario o contraseña incorrectos");
            echo "Error: Nombre de usuario o contraseña incorrectos.";
        
        }
    

        unset($_SESSION['cod_veri']);
        unset($_SESSION['texto_cal']);
        unset($_SESSION['calculo']);
        $stmt->close();
        $conn->close();
    }
    else{
        access_log($conn, "Posible bot");
        echo "Error: Eres un bot!!!";
    }
}

unset($_SESSION['cod_veri']);
unset($_SESSION['texto_cal']);
unset($_SESSION['calculo']);
if (!isset($_SESSION['cod_veri'])) {
    $_SESSION['cod_veri'] = generarCodAleatorio();
}

if (!isset($_SESSION['calculo'])){
    $codMate=generarCodMate();
    $_SESSION['calculo']=$codMate['calculo'];
    $_SESSION['texto_cal']=$codMate['texto_cal'];
}

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" type="text/css" href="estilos.css"> 
    <script type="text/javascript">
        // Función para mostrar los campos de verificación y cálculo
        function mostrarCampos() {
            document.getElementById("campos_verificacion").style.display = "block";  // Muestra los campos
            document.getElementById("boton_verificacion").style.display = "none";  // Oculta el botón
        }
    </script>
    <script>
        document.addEventListener('contextmenu', function(e) {
        e.preventDefault();
        });

        document.addEventListener('copy', function(e) {
        e.preventDefault();
        });

        document.addEventListener('cut', function(e) {
        e.preventDefault();
        });

        document.addEventListener('paste', function(e) {
        e.preventDefault();
        });
  </script>
</head>
<body class="login-page">

    <h1>Iniciar Sesión</h1>

    <form name="login_form" id="login_form" action="login.php" method="POST">
        <!-- Campo CSRF oculto -->
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            
        <!-- Formulario de inicio de sesión -->
        <label for="nombre">Nombre de usuario:</label>
        <input type="text" id="nombre" name="nombre" required><br>

        <label for="contraseña">Contraseña:</label>
        <input type="password" id="contraseña" name="contraseña" required><br>

        <!-- Botón para mostrar los campos de verificación -->
        <button type="button" class="button" id="boton_verificacion" onclick="mostrarCampos()">¿Soy un bot?</button><br><br>

        <!-- Campos de verificación y cálculo, inicialmente ocultos -->
        <div id="campos_verificacion" style="display:none;">
            <label>Código de verificación: <strong><?php echo htmlspecialchars($_SESSION['cod_veri']);?></strong></label><br>

            <label for="codigo_ingresado">Ingresa Código:</label>
            <input type="text" id="codigo_ingresado" name="codigo_ingresado" required><br><br>

            <label>Cálcula esta ecuación: <strong><?php echo htmlspecialchars($_SESSION['texto_cal']);?></strong></label><br>

            <label for="cal_ingresado">Ingresa Código:</label>
            <input type="number" id="cal_ingresado" name="cal_ingresado" required><br><br>
        </div>

        <input type="submit" id="login_submit" value="Iniciar Sesión">
    </form>

</body>
</html>
