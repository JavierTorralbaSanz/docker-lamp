<?php
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

    $conn = mysqli_connect($hostname,$username,$password,$db);
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    $query = mysqli_query($conn, "SELECT * FROM usuarios WHERE username = '$usuario'")
        or die (mysqli_error($conn));

    $row = mysqli_fetch_array($query);

    if ($row) {
        echo'<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Información del Usuario</title>
        <link rel="stylesheet" href="estilos.css">
        </head>
        <body>
            <div class="user-info-container">
                <h1>Información del Usuario</h1>
                <?php
                    <p><strong>Nombre de usuario:</strong> ' . $usuario . '</p>
                    <p><strong>DNI:</strong> ' . $row['dni'] . '</p>
                    <p><strong>Nombre:</strong> ' . $row['nombre'] . '</p>
                    <p><strong>Teléfono:</strong> ' . $row['telefono'] . '</p>
                    <p><strong>Fecha de nacimiento:</strong> ' . $row['fecha'] . '</p>
                    <p><strong>Email:</strong> ' . $row['email'] . '</p>
                    <a href="/modify_user?user=' . $usuario . '" class="link-button">Modificar datos</a>
            </div>
        </body>';
    }
    else {
        echo 'No existe ningún usuario con DNI \'' . $usuario . '\'<br>';
        echo '<a href="/">Página inicial</a>';
    }
?>
