<?php

    //If valido cuando se entra por primera vez
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        parse_str($_SERVER['QUERY_STRING'], $params);

        if (!$params) {
            echo 'No se ha especificado un DNI<br>';
            echo '<a href="/">Página inicial</a>';
            return;
        }

        $usuario = $params['user'];

        $hostname = "db";
        $username = "admin";
        $password = "test";
        $db = "database";

        //Se realiza la conexión
        $conn = mysqli_connect($hostname,$username,$password,$db);
        if ($conn->connect_error) {
            die("Database connection failed: " . $conn->connect_error);
        }

         // Consulta parametrizada para buscar al usuario
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE username = ?");
        if (!$stmt) {
            echo "Error preparando la consulta: " . $conn->error;
            exit();
        }
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        //Si existe el usuario muestra la interfaz para que el usuario pueda cambiar los valores
        if ($row) {

                echo "<head>
                    <link rel='stylesheet' type='text/css' href='estilos.css'> <!--Parte visual en estilos.css-->
                    <script src='inactividad.js'></script>
                </head>";

                echo "<body class='register-page'>
                <script>
                function validar_datos() {
                    var nombre = document.getElementById('nombre').value;
                    var dni = document.getElementById('dni').value;
                    var telefono = document.getElementById('telefono').value;
                    var fecha = document.getElementById('fecha').value;
                    var email = document.getElementById('email').value;
                    var c1 = document.getElementById('password1').value;
                    var c2 = document.getElementById('password2').value;
                    
                    if (!validar_nombre(nombre)) {
                        alert('Nombre de usuario inválido');
                        return;
                    }
                    if (!validar_dni(dni)) {
                        alert('DNI inválido. Formato: 12345678-A');
                        return;
                    }
                    if (!validar_telefono(telefono)) {
                        alert('Teléfono inválido. Formato: 123456789');
                        return;
                    }
                    if (!validar_fecha(fecha)) {
                        alert('Fecha inválida. Formato: yyyy-mm-dd');
                        return;
                    }
                    if (!validar_email(email)) {
                        alert('Email inválido');
                        return;
                    }

                    if (c1.length > 0) {
                        if (!validar_passwords(c1, c2)) {
                            alert('Contraseña inválida. Las contraseñas deben coincidir y no ser nulas');
                            return;
                        }
                        if (!verificar_password(c1)){
                            alert('Contraseña inválida. Debe de tener algunas caracteristicas');
                            return;
                        }
                    }

                    // todo ok
                    document.user_modify_form.submit();
                }
            </script>

            <form name='user_modify_form' id='user_modify_form' action='modify_user.php?user={$usuario}' method='POST'>
                <label for='name'>Nombre y apellidos:</label><br>
                <input type='text' id='nombre' name='nombre' value='" . htmlspecialchars($row['nombre']) . "' placeholder='Solo se acepta texto'><br>
                <label for='name'>DNI:</label><br>
                <input type='text' id='dni' name='dni' value='" . htmlspecialchars($row['dni']) . "'placeholder='Formato: 00000000-T'><br>
                <label for='name'>Teléfono:</label><br>
                <input type='text' id='telefono' name='telefono' value='" . htmlspecialchars($row['telefono']) . "'placeholder='Formato: 123456789'><br>
                <label for='name'>Fecha de nacimiento:</label><br>
                <input type='text' id='fecha' name='fecha' value='" . htmlspecialchars($row['fecha']) . "' placeholder='Formato: aaaa-mm-dd'><br>
                <label for='name'>Email:</label><br>
                <input type='text' id='email' name='email' value='" . htmlspecialchars($row['email']) . "' placeholder='Formato: nombre@dominio'><br>
                <label id='c1'>Contraseña (vacía si no quiere cambiarla):</label><br>
                <input type='password' id='password1' name='password1'><br>
                 <div id='requisitos_contrasena'>
            <ul>
                <li>Al menos 6 caracteres</li>
                <li>Al menos una letra mayúscula</li>
                <li>Al menos una letra minúscula</li>
                <li>Al menos un número</li>
                <li>Al menos un carácter especial (!@#$%^&*(),.?:{}|<>)</li>
            </ul>
        </div>
                <label id='c2'>Repetir contraseña:</label><br>
                <input type='password' id='password2' name='password2'><br>
                <input type='submit' value='Submit' id='user_modify_submit''>
            </form>
            </body>";
        }
    }
    // Una vez introducidos los datos del usuario a modifivar accede a este if
    else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = $_POST['nombre'];
        $dni = $_POST['dni'];
        $telefono = $_POST['telefono'];
        $fecha = $_POST['fecha'];
        $email = $_POST['email'];
        parse_str($_SERVER['QUERY_STRING'], $params);
        $usuario = $params['user'];

        $c1 = $_POST['password1'];
        $c2 = $_POST['password2'];

        // Generar hash seguro de la contraseña, en PHP la funcion 
        // password_hash genera automaticamente un salt y realiza el hash
        $hashed_password = password_hash($c1, PASSWORD_DEFAULT);

        // query
        $hostname = "db";
        $username = "admin";
        $password = "test";
        $db = "database";

        $conn = mysqli_connect($hostname,$username,$password,$db);
        if ($conn->connect_error) {
            die("Database connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("UPDATE usuarios SET nombre = ?, dni = ?, telefono = ?, fecha = ?, email = ? WHERE username = ?");
        if (!$stmt) {
            echo "Error preparando la consulta: " . $conn->error;
            exit();
        }
        $stmt->bind_param("ssssss", $nombre, $dni, $telefono, $fecha, $email, $usuario);
        if (!$stmt->execute()) {
            echo "Error al actualizar los datos: " . $stmt->error;
        }
        $stmt->close();

        // Comprueba si se ha decido cambiar la contraseña o no
        if (strlen($c1) > 0) {
                $stmt = $conn->prepare("UPDATE usuarios SET contraseña = ? WHERE username = ?");
                if (!$stmt) {
                    echo "Error preparando la consulta de contraseña: " . $conn->error;
                    exit();
                }
                $stmt->bind_param("ss", $hashed_password, $usuario);
                if (!$stmt->execute()) {
                    echo "Error al actualizar la contraseña: " . $stmt->error;
                }
                $stmt->close();
        }
        echo '<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Inicio de Sesión</title>
        <link rel="stylesheet" href="estilos.css">
    </head>
    <body>
        <div class="message-container">
            
                 <h1>Datos actualizados</h1>
                <a href="/" class="link-button">Ir a la Página Principal</a>
        </div>
    </body>';

    }

?>