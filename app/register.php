<?php
session_start();

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
        //Verifica el token CSRF antes de procesar el inicio de sesion
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die("Error: Token CSRF invalido.");
        }

    include "config.php";
    include "validar.php";
   echo' <html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registro de usuario</title>
        <link rel="stylesheet" href="estilos.css">
    </head>
    <body>';
    //Registra en la BD los datos que ha introducido los usuarios
    $nombre = $_POST['nombre'];
    $dni = $_POST['dni'];
    $telefono = $_POST['telefono'];
    $fecha = $_POST['fecha'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $codigoIngresado = $_POST['codigo_ingresado'];
    $codigoGuardado = $_SESSION['cod_veri'];
    $calculoIngresado= $_POST['cal_ingresado'];
    $calGuardado = $_SESSION['calculo'];

    $c1 = $_POST['password1'];
    $c2 = $_POST['password2'];

    // Generar hash seguro de la contraseña, en PHP la funcion 
    // password_hash genera automaticamente un salt y realiza el hash


    if ($codigoGuardado == $codigoIngresado && $calculoIngresado == (string)$calGuardado) {
        $hashed_password = password_hash($c1, PASSWORD_DEFAULT);

        if (!validar_dni($dni)) {
            echo "<div class='message-container'>";
            echo "El DNI es inválido<br>";
            echo "<a href='/register'>Volver al formulario</button>";
            echo "</div>";
            return;
        }
        if (!validar_nombre($nombre)) {
            echo "<div class='message-container'>";
            echo "El nombre es inválido<br>";
            echo "<a href='/register'>Volver al formulario</button>";
            echo "</div>";
            return;
        }
        if (!validar_telefono($telefono)) {
            echo "<div class='message-container'>";
            echo "El teléfono es inválido<br>";
            echo "<a href='/register'>Volver al formulario</button>";
            echo "</div>";
            return;
        }
        if (!validar_fecha($fecha)) {
            echo "<div class='message-container'>";
            echo "La fecha de nacimiento es inválida<br>";
            echo "<a href='/register'>Volver al formulario</button>";
            echo "</div>";
            return;
        }
        if (!validar_email($email)) {
            echo "<div class='message-container'>";
            echo "El email es inválido<br>";
            echo "<a href='/register'>Volver al formulario</button>";
            echo "</div>";
            return;
        }
        if (!validar_username($username)) {
            echo "<div class='message-container'>";
            echo "El nombre de usuario no puede estar vacío<br>";
            echo "<a href='/register'>Volver al formulario</button>";
            echo "</div>";
            return;
        }
        if (!validar_passwords($c1, $c2)) {
            echo "<div class='message-container'>";
            echo "Las contraseñas no coinciden o son inválidas<br>";
            echo "<a href='/register'>Volver al formulario</button>";
            echo "</div>";
            return;
        }
        if (!verificar_password($c1)) {
            echo "<div class='message-container'>";
            echo "Las contraseñas son inválidas<br>";
            echo "<a href='/register'>Volver al formulario</button>";
            echo "</div>";
            return;
        }
    
        $consulta = $conn->prepare("SELECT * FROM usuarios WHERE dni=?");
        $consulta->bind_param("s", $dni);
        $consulta->execute();
        $resultado = $consulta->get_result();
        $consulta->close();

        if ($resultado->num_rows != 0) {
            echo "<div class='message-container'>";
            echo "Ya existe un usuario con DNI $dni<br>";
            echo "<a href='/' class='link-button'>Página inicial</a>";
            echo "</div>";
            return;
        }

        $consulta = $conn->prepare("SELECT * FROM usuarios WHERE username=?");
        $consulta->bind_param("s", $username);
        $consulta->execute();
        $resultado = $consulta->get_result();
        $consulta->close();

        if ($resultado->num_rows != 0) {
            echo "<div class='message-container'>";
            echo "El nombre de usuario ya está en uso<br>";
            echo "<a href='/' class='link-button'>Página inicial</a>";
            echo "</div>";
            return;
        }
        //En esta consulta se ha introducido el hased_password que ya implementa el salt y hash
        $consulta = $conn->prepare("
            INSERT INTO usuarios(dni, nombre, telefono, fecha, email, username, contraseña)
            VALUES(?, ?, ?, ?, ?, ?, ?)
        ");
        $consulta->bind_param("sssssss", $dni, $nombre, $telefono, $fecha, $email, $username, $hashed_password);
        

        //Registra al usuario
        if ($consulta->execute()) {
            echo "<div class='message-container'>";
            echo "<h1>Usuario registrado</h1>";
            echo "<a href='/' class='link-button'>Página inicial</a>";
            echo "</div>";
        }
        else {
            error_log("No se pudo registrar al usuario: " . mysqli_error($conn));
            echo "<div class='message-container'>";
            echo "Se ha producido un error. No se ha completado el registro<br>";
            echo "<a href='/' class='link-button'>Página inicial</a>";
            echo "</div>";
        }
        echo'</body>
            </html>';
            unset($_SESSION['cod_veri']);
            unset($_SESSION['texto_cal']);
            unset($_SESSION['calculo']);
            $consulta->close();
            exit; 
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
<html>
    <!--Este archivo incluye la interacción del proceso de registrarse por parte del usuario-->

    <head>
        <link rel="stylesheet" type="text/css" href="estilos.css"> <!--Parte visual en estilos.css-->
        <title>Registro de usuario</title>
        <script type="text/javascript">
        // Función para mostrar los campos de verificación y cálculo
        function mostrarCampos() {
            document.getElementById("campos_verificacion").style.display = "block";  // Muestra los campos
            document.getElementById("boton_verificacion").style.display = "none";  // Oculta el botón
        }
    </script>
    </head> 
    <body class="register-page">
        <h1>Registro de usuario</h1>

        <!--Formulario que indica los datos que debe de introducir el usuario-->
        <form name="register_form" id="register_form" action="register.php" method="POST">
                <!-- Campo CSRF oculto -->
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

            <label for="name">Nombre y apellidos:</label><br>
            <input type="text" id="nombre" name="nombre" placeholder="Solo se acepta texto"><br>
            <label for="name">DNI:</label><br>
            <input type="text" id="dni" name="dni" placeholder="Formato: 00000000-T"><br>
            <label for="name">Teléfono:</label><br>
            <input type="text" id="telefono" name="telefono" placeholder="Formato: 123456789"><br>
            <label for="name">Fecha de nacimiento:</label><br>
            <input type="text" id="fecha" name="fecha" placeholder="Formato: aaaa-mm-dd"><br>
            <label for="name">Email:</label><br>
            <input type="text" id="email" name="email" placeholder="Formato: nombre@dominio"><br>
            <label for="name">Nombre de usuario:</label><br>
            <input type="text" id="username" name="username"><br>
            <label id="c1">Contraseña:</label><br>
            <input type="password" id="password1" name="password1"><br>
            <small>La contraseña debe cumplir con los siguientes requisitos:</small>
        
        <!-- Requisitos de la contraseña -->
        <div id="requisitos_contrasena">
            <ul>
                <li>Al menos 6 caracteres</li>
                <li>Al menos una letra mayúscula</li>
                <li>Al menos una letra minúscula</li>
                <li>Al menos un número</li>
                <li>Al menos un carácter especial (!@#$%^&*(),.?":{}|<>)</li>
            </ul>
        </div>
            <label id="c2">Repetir contraseña:</label><br>
            <input type="password" id="password2" name="password2"><br>
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
            <input type="submit" value="Submit" id="register_submit">
        </form>
        <!--Los datos introducidos correctos se almacenan en la sql a traves de register.php-->

    </body>
</html>


