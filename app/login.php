<?php
    $nombreUsuario = $_POST['nombreUsuario'];
    $contraseña = $_POST['contraseña'];

    $hostname = "db";
    $username = "admin";
    $password = "test";
    $db = "database";

    $conn = mysqli_connect($hostname,$username,$password,$db);
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    if (mysqli_query($conn, "INSERT INTO datosLogin(nombreUsuario,contraseña) VALUES('$nombreUsuario','$contraseña')")) {
        echo 'Login exitoso';
    }
    else {
        die('error: ' . mysqli_error($conn));
    }

?>