<?php

session_start();

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

$sql = "SELECT * FROM usuarios WHERE username = '$nombreUsuario' AND contrasena = '$contraseña'";
$resultado = $conn->query($sql);
if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conn));
}

//Verificar si el usuario existe y la contraseña coincide
if (mysqli_num_rows($resultado) > 0) {
    $_SESSION['usuario'] = $nombreUsuario;
    echo "Inicio de sesión exitoso. Bienvenido " . $nombreUsuario;
  //  header("Location: register.php");
    exit; 
} else {
    echo "Error: Nombre de usuario o contraseña incorrectos.";
}

?>
