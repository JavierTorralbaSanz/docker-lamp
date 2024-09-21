<?php
    $nombre = $_POST['nombre'];
    $dni = $_POST['dni'];
    $telefono = $_POST['telefono'];
    $fecha = $_POST['fecha'];
    $email = $_POST['email'];

    $hostname = "db";
    $username = "admin";
    $password = "test";
    $db = "database";

    $conn = mysqli_connect($hostname,$username,$password,$db);
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    if (mysqli_query($conn, "INSERT INTO usuarios(dni, nombre, telefono, fecha, email) VALUES('$dni', '$nombre', '$telefono', '$fecha', '$email')")) {
        echo 'Usuario creado';
    }
    else {
        die('error: ' . mysqli_error($conn));
    }

?>
