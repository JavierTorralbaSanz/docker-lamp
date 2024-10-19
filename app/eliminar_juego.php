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

    echo '<script>
    alert("El videojuego seleccionado se ha eliminado correctamente.");
    window.location.href = "/items";
</script>';
    exit();
    
?>
