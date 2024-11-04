<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de usuario</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<?php

    include "config.php";
    include "validar.php";

    //Registra en la BD los datos que ha introducido los usuarios
    $nombre = $_POST['nombre'];
    $dni = $_POST['dni'];
    $telefono = $_POST['telefono'];
    $fecha = $_POST['fecha'];
    $email = $_POST['email'];
    $username = $_POST['username'];

    $c1 = $_POST['password1'];
    $c2 = $_POST['password2'];

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
    $consulta->bind_param("s", $usuario);
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

    $consulta = $conn->prepare("
        INSERT INTO usuarios(dni, nombre, telefono, fecha, email, username, contraseña)
        VALUES(?, ?, ?, ?, ?, ?, ?)
    ");
    $consulta->bind_param("sssssss", $dni, $nombre, $telefono, $fecha, $email, $username, $c1);
    

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

    $consulta->close();
?>

</body>
</html>
