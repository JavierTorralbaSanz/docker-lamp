<?php
    $nombreUsuario = $_POST['nombre'];
    $contraseña = $_POST['contraseña'];

    $hostname = "db";
    $username = "admin";
    $password = "test";
    $db = "database";

    $conn = mysqli_connect($hostname,$username,$password,$db);
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    $resultado = mysqli_query($conn, "SELECT contraseña FROM usuarios WHERE username = '$nombreUsuario'");

    if ($resultado->num_rows == 1) {
        session_start();
        $resultado = mysqli_fetch_array($resultado);
        if ($resultado['contraseña'] == $contraseña) {
            echo 'Usuario y contraseña correctos<br>';
            $_SESSION['usuario'] = $nombreUsuario;
        }
        else {
            echo 'Contraseña incorrecta<br>';
            echo '<a href="/">Página principal</a>';
        }
    }
    else {
        die('error: ' . mysqli_error($conn));
    }

?>
