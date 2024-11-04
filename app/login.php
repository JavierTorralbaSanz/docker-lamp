<?php

session_start();
    //Obtener datos del usuario
    $nombreUsuario = $_POST['nombre'];
    $contraseña = $_POST['contraseña'];
    
    //Proceso para conectarese a la base de datos
    $hostname = "db";
    $username = "admin";
    $password = "test";
    $db = "database";

    $conn = mysqli_connect($hostname,$username,$password,$db);
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

// Busca  en la sql si algún usuario tiene ese nombre y esa contraseña
$sql = "SELECT * FROM usuarios WHERE username = '$nombreUsuario' AND contraseña = '$contraseña'";
$resultado = $conn->query($sql);
if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conn));
}


// Preparar la consulta SQL para evitar inyecciones
$sql = "SELECT contraseña FROM usuarios WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nombreUsuario); // "s" indica que es una cadena de texto
$stmt->execute();
$resultado = $stmt->get_result();

// Verificar si el usuario existe y la contraseña coincide
if ($resultado->num_rows > 0) {
    //Para realizar esto primero se debería de encriptar las claves
    //$row = $resultado->fetch_assoc();
    // if (password_verify($contraseña, $row['contraseña'])) {} 
    // Suponiendo que las contraseñas es
    $_SESSION['usuario'] = $nombreUsuario;
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
    //echo "Inicio de sesión exitoso. Bienvenido " . $nombreUsuario . "<br>";
    //echo '<a href="/">Página principal</a>';
  //  header("Location: register.php");
    exit; 
} else {
    echo "Error: Nombre de usuario o contraseña incorrectos.";
}

?>
