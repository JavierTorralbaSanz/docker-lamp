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
        echo 'Nombre de usuario: ' . $usuario . '<br>';
        echo 'DNI: ' . $row['dni'] . '<br>';
        echo 'Nombre: ' . $row['nombre'] . '<br>';
        echo 'Teléfono: ' . $row['telefono'] . '<br>';
        echo 'Fecha de nacimiento: ' . $row['fecha'] . '<br>';
        echo 'Email: ' . $row['email'] . '<br>';
        echo '<a href="/modify_user?user=' . $usuario . '">Modificar datos</a><br>';
    }
    else {
        echo 'No existe ningún usuario con DNI \'' . $usuario . '\'<br>';
        echo '<a href="/">Página inicial</a>';
    }
?>
