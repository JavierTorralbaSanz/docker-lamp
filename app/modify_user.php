<!DOCTYPE html>
<html>
<head>
    <link rel='stylesheet' type='text/css' href='estilos.css'> <!--Parte visual en estilos.css-->
    <script src='inactividad.js'></script>
    <script src='validacion.js'></script> <!-- Enlace a tu archivo de validaciones -->
</head>

<?php

    include "config.php";
    include "validar.php";

    //If valido cuando se entra por primera vez
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        parse_str($_SERVER['QUERY_STRING'], $params);

        if (!$params) {
            echo 'No se ha especificado un usuario<br>';
            echo '<a href="/">Página inicial</a>';
            return;
        }

        if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] != $params['user']) {
            echo "Debes iniciar sesión para modificar tus datos<br>";
            echo '<a href="/">Página inicial</a>';
            return;
        }

        $usuario = $params['user'];

        //Se realiza la conexión

         // Consulta parametrizada para buscar al usuario
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE username = ?");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        //Si existe el usuario muestra la interfaz para que el usuario pueda cambiar los valores
        if ($row) {

            echo "<body class='register-page'>
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
            </form>";
        }
    }
    // Una vez introducidos los datos del usuario a modificar accede a este if
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

        echo "<body>";

        if (!validar_dni($dni)) {
            echo "<div class='message-container'>";
            echo "El DNI es inválido<br>";
            echo "<a href='/modify_user?user=" . urlencode($usuario) . "'>Volver a modificar</button>";
            echo "</div>";
            return;
        }
        if (!validar_nombre($nombre)) {
            echo "<div class='message-container'>";
            echo "El nombre es inválido<br>";
            echo "<a href='/modify_user?user=" . urlencode($usuario) . "'>Volver a modificar</button>";
            echo "</div>";
            return;
        }
        if (!validar_telefono($telefono)) {
            echo "<div class='message-container'>";
            echo "El teléfono es inválido<br>";
            echo "<a href='/modify_user?user=" . urlencode($usuario) . "'>Volver a modificar</button>";
            echo "</div>";
            return;
        }
        if (!validar_fecha($fecha)) {
            echo "<div class='message-container'>";
            echo "La fecha de nacimiento es inválida<br>";
            echo "<a href='/modify_user?user=" . urlencode($usuario) . "'>Volver a modificar</button>";
            echo "</div>";
            return;
        }
        if (!validar_email($email)) {
            echo "<div class='message-container'>";
            echo "El email es inválido<br>";
            echo "<a href='/modify_user?user=" . urlencode($usuario) . "'>Volver a modificar</button>";
            echo "</div>";
            return;
        }
        if (!validar_username($usuario)) {
            echo "<div class='message-container'>";
            echo "El nombre de usuario no puede estar vacío<br>";
            echo "<a href='/modify_user?user=" . urlencode($usuario) . "'>Volver a modificar</button>";
            echo "</div>";
            return;
        }
        if (strlen($c1)!=0 || strlen($c2)!=0){
            if (!validar_passwords($c1, $c2)) {
                echo "<div class='message-container'>";
                echo "Las contraseñas no coinciden<br>";
                echo "<a href='/modify_user?user=" . urlencode($usuario) . "'>Volver a modificar</button>";
                echo "</div>";
                return;
            }
            if (!verificar_password($c1)) {
                echo "<div class='message-container'>";
                echo "La contraseña no cumple con los requisitos<br>";
                echo "<a href='/modify_user?user=" . urlencode($usuario) . "'>Volver a modificar</button>";
                echo "</div>";
                return;
            }
        } 

        $stmt = $conn->prepare("UPDATE usuarios SET nombre = ?, dni = ?, telefono = ?, fecha = ?, email = ? WHERE username = ?");
        $stmt->bind_param("ssssss", $nombre, $dni, $telefono, $fecha, $email, $usuario);
        if (!$stmt->execute()) {
            echo 'Error interno del servidor<br>';
            echo '<a href="/">Página principal</a>';
            error_log("Error al actualizar los datos: " . $stmt->error);
            return;
        }
        $stmt->close();

        // Comprueba si se ha decido cambiar la contraseña o no
        if (strlen($c1) > 0) {
                $stmt = $conn->prepare("UPDATE usuarios SET contraseña = ? WHERE username = ?");
                $stmt->bind_param("ss", $hashed_password, $usuario);
                if (!$stmt->execute()) {
                    echo 'Error interno del servidor<br>';
                    echo '<a href="/">Página principal</a>';
                    error_log("Error al actualizar los datos: " . $stmt->error);
                    return;
                }
                $stmt->close();
        }

        echo '<body>
            <div class="message-container">
                <h1>Datos actualizados</h1>
                <a href="/" class="link-button">Ir a la Página Principal</a>
            </div>';
    }

?>

</body>
</html>
