<?php
    parse_str($_SERVER['QUERY_STRING'], $params);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        include 'config.php'; //Realiza la conexion con la sql

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
    
    }

    else {
        echo '
            <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Inicio de Sesión</title>
            <link rel="stylesheet" href="estilos.css">
            </head>
            <body>
                <div class="message-container">
                        <p>Está a punto de eliminar ' . $params['item'] . '. ¿Seguro que quiere continuar?</p>
                        <form action="delete_item?item=' . $params['item'] . '" method="post">
                        <input type="submit" id="item_delete_submit" value="Eliminar juego">
                        </form>
                </div>
            </body>
        ';
    }
?>
