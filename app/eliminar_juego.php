<?php
    include 'config.php';

    parse_str($_SERVER['QUERY_STRING'], $params);

    if (!isset($params['item'])) {
        echo 'No se ha especificado un ID de videojuego<br>';
        echo '<a href="/">Página inicial</a>';
        return; 
    }
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
