<?php
    parse_str($_SERVER['QUERY_STRING'], $params);

    if (!isset($params['item'])) {
        echo 'No se ha especificado un ID de videojuego<br>';
        echo '<a href="/">Página inicial</a>';
        return; 
    }

    $itemId = $params['item'];

    include 'config.php';
    $query = mysqli_query($conn, "SELECT * FROM videojuegos WHERE id = '$itemId'")
        or die(mysqli_error($conn));

    $item = mysqli_fetch_array($query);

    if ($item) {
        echo'<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Información del Usuario</title>
        <link rel="stylesheet" href="estilos.css">
        </head>
        <body>
            <div class="user-info-container">
                <h1>Detalles del Videojuego</h1>
                <?php
                    <p><strong>Nombre de videojuego:</strong> ' . $$itemId . '</p>
                    <p><strong>Título:</strong> ' . $item['titulo'] . '</p>
                    <p><strong>Desarrolladora:</strong> ' . $item['desarrolladora'] . '</p>
                    <p><strong>Rating:</strong> ' . $item['rating'] . '</p>
                    <p><strong>Precio:</strong> ' . $item['precio'] . '</p>
                    <p><strong>Género:</strong> ' . $item['genero'] . '</p>
                    <a href="/" class="link-button">Volver</a>
            </div>
        </body>';
        //echo '<h2>Detalles del Videojuego</h2>';
        //echo 'Nombre de usuario: ' . $itemId . '<br>';
        //echo 'Título: ' . $item['titulo'] . '<br>';
        //echo 'Desarrolladora: ' . $item['desarrolladora'] . '<br>';
        //echo 'Rating: ' . $item['rating'] . '<br>';
        //echo 'Precio: ' . $item['precio'] . '<br>';
        //echo 'Género: ' . $item['genero'] . '<br>';
        //echo '<a href="/">Volver</a>';
    } else {
        echo 'No existe un videojuego con ID \'' . $itemId . '\'<br>';
        echo '<a href="/">Página inicial</a>';
    }
?>
