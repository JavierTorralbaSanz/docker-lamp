<?php
    parse_str($_SERVER['QUERY_STRING'], $params);

    if (!$params) {
        echo 'No se ha especificado un DNI<br>';
        echo '<a href="/">Página inicial</a>';
        return;
    }

    $dni = $params['user'];

    $hostname = "db";
    $username = "admin";
    $password = "test";
    $db = "database";

    $conn = mysqli_connect($hostname,$username,$password,$db);
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    $query = mysqli_query($conn, "SELECT * FROM usuarios WHERE dni = '$dni'")
        or die (mysqli_error($conn));

    $row = mysqli_fetch_array($query);

    if ($row) {
        echo 'DNI: ' . $row['dni'] . '<br>';
        echo 'Nombre: ' . $row['nombre'] . '<br>';
        echo 'Teléfono: ' . $row['telefono'] . '<br>';
        echo 'Fecha de nacimiento: ' . $row['fecha'] . '<br>';
        echo 'Email: ' . $row['email'] . '<br>';
    }
    else {
        echo 'No existe ningún usuario con DNI \'' . $dni . '\'<br>';
        echo '<a href="/">Página inicial</a>';
    }
?>
