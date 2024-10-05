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
        echo '<h2>Detalles del Videojuego</h2>';
        echo 'Nombre de usuario: ' . $itemId . '<br>';
        echo 'Título: ' . $item['titulo'] . '<br>';
        echo 'Desarroladora: ' . $item['desarrolladora'] . '<br>';
        echo 'Rating: ' . $item['rating'] . '<br>';
        echo 'Precio: ' . $item['precio'] . '<br>'; 
        echo '<a href="/">Volver</a>';
    } else {
        echo 'No existe un videojuego con ID \'' . $itemId . '\'<br>';
        echo '<a href="/">Página inicial</a>';
    }
?>
