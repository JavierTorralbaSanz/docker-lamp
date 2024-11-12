<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información del Usuario</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<?php

    include "config.php";
    include 'caducidad_sesion.php';
    parse_str($_SERVER['QUERY_STRING'], $params);

    if (!$params) {
        echo 'No se ha especificado un usuario<br>';
        echo '<a href="/">Página inicial</a>';
        return;
    }

    if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] != $params['user']) {
        echo "Debes iniciar sesión para ver tus datos<br>";
        echo '<a href="/">Página inicial</a>';
        return;
    }

    $usuario = $params['user'];

    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE username = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    $conn = mysqli_connect($hostname,$username,$password,$db);
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE username = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
       
        echo'<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Información del Usuario</title>
        <link rel="stylesheet" href="estilos.css">
        <script src="inactividad.js"></script>
        </head>
        <body>
            <div class="user-info-container">
                <h1>Información del Usuario</h1>
                <?php
                    <p><strong>Nombre de usuario:</strong> ' . htmlspecialchars($usuario) . '</p>
                    <p><strong>DNI:</strong> ' . htmlspecialchars($row['dni']) . '</p>
                    <p><strong>Nombre:</strong> ' . htmlspecialchars($row['nombre']) . '</p>
                    <p><strong>Teléfono:</strong> ' . htmlspecialchars($row['telefono']) . '</p>
                    <p><strong>Fecha de nacimiento:</strong> ' . htmlspecialchars($row['fecha']). '</p>
                    <p><strong>Email:</strong> ' . htmlspecialchars($row['email']) . '</p>
                    <a href="/modify_user?user=' . urlencode($usuario) . '" class="link-button">Modificar datos</a>
            </div>
        </body>';
    }
    else {
        echo 'No existe ningún usuario con DNI \'' .  htmlspecialchars($usuario) . '\'<br>';
        echo '<a href="/">Página inicial</a>';
    }
?>

</body>
