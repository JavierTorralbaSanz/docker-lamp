<?php
    include 'caducidad_sesion.php';
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

       // Prepara y ejecuta la consulta segura para eliminar el videojuego
        $itemId = $params['item'];
        $stmt = $conn->prepare("DELETE FROM videojuegos WHERE id = ?");

        if ($stmt) {
            $stmt->bind_param("i", $itemId); // "i" indica que $itemId es un entero
    
            if ($stmt->execute()) 
            {
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
                echo "Error al eliminar el videojuego: " . $stmt->error;
            }
            $stmt->close();
        }
        else {
            echo "Error al preparar la consulta de eliminación: " . $conn->error;
        }
        $conn->close();
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
                        <p>Está a punto de eliminar ' . htmlspecialchars($params['item']) .  '. ¿Seguro que quiere continuar?</p>
                        <form action="delete_item?item=' . urlencode($params['item']) .'" method="post">
                        <input type="submit" id="item_delete_submit" value="Eliminar juego">
                        </form>
                </div>
            </body>
        ';
    }
?>
