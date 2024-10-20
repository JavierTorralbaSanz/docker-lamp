<?php
    include 'config.php'; //Realiza la conexion con la sql

    //Se asocia el dato indicado con el videojuego a eliminar
    parse_str($_SERVER['QUERY_STRING'], $params);

    //Comprueba si el id tiene valor, siempre debería de tener
    if (!isset($params['item'])) {
        echo 'No se ha especificado un ID de videojuego<br>';
        echo '<a href="/">Página inicial</a>';
        return; 
    }
    //Se busca el videojuego y se elimina, mostrando un aviso al usuario
    $itemId = $params['item'];
    include 'config.php';
    $query = mysqli_query($conn, "DELETE FROM videojuegos WHERE id = '$itemId'")
        or die(mysqli_error($conn));

        echo '<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Inicio de Sesión</title>
        <link rel="stylesheet" href="estilos.css">
    </head>
    <body>
        <div class="message-container">
            
                 <h1>El videojuego seleccionado se ha eliminado correctamente </h1>
                <a href="/items" class="link-button">Ir a mostrar juegos</a>
        </div>
    </body>';
      
    exit();
    
?>
