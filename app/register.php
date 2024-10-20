<?php
    //Registra en la BD los datos que ha introducido los usuarios
    $nombre = $_POST['nombre'];
    $dni = $_POST['dni'];
    $telefono = $_POST['telefono'];
    $fecha = $_POST['fecha'];
    $email = $_POST['email'];
    $usuario = $_POST['username'];

    $c1 = $_POST['password1'];
    $c2 = $_POST['password2'];

    $hostname = "db";
    $username = "admin";
    $password = "test";
    $db = "database";

    $conn = mysqli_connect($hostname,$username,$password,$db);
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    if (mysqli_query($conn, "SELECT * FROM usuarios WHERE DNI='$dni'")->num_rows != 0) {
        echo "Ya existe un usuario con DNI $dni<br>";
        echo "<a href='/'>Página inicial</a>";
        return;
    }

    if (mysqli_query($conn, "SELECT * FROM usuarios WHERE USERNAME='$usuario'")->num_rows != 0) {
        echo "Ya existe un usuario con nombre de usuario '$usuario'<br>";
        echo "<a href='/'>Página inicial</a>";
        return;
    }
    //Registra al usuario
    if (mysqli_query($conn, "INSERT INTO usuarios(dni, nombre, telefono, fecha, email, username, contraseña) VALUES('$dni', '$nombre', '$telefono', '$fecha', '$email', '$usuario', '$c1')")) {
        
        echo '<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Inicio de Sesión</title>
        <link rel="stylesheet" href="estilos.css">
    </head>
    <body>
        <div class="message-container">
            
                 <h1>Usuario registrado</h1>
                <a href="/" class="link-button">Página inicial</a>
        </div>
    </body>';
       
    }
    else {
        die('error: ' . mysqli_error($conn));
    }
?>
