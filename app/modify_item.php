<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['id']) || empty($_POST['titulo']) || empty($_POST['desarrolladora']) || empty($_POST['rating']) || empty($_POST['precio'])) {
        echo "Todos los campos son obligatorios.";
        exit();
    }

    $id = (int)$_POST['id'];
    $titulo = $_POST['titulo'];
    $desarrolladora = $_POST['desarrolladora'];
    $rating = (float)$_POST['rating'];
    $precio = (float)$_POST['precio'];

    // Consulta para actualizar el juego
    $query = "UPDATE videojuegos SET Titulo = '$titulo', Desarrolladora = '$desarrolladora', Rating = '$rating', Precio = '$precio' WHERE id = $id";

    if ($conn->query($query) === TRUE) {
        header("Location: /items?message=Juego%20modificado%20exitosamente");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
} else {
   parse_str($_SERVER['QUERY_STRING'], $params);

    if (!isset($params['item'])) {
        echo 'No se ha especificado un ID de videojuego<br>';
        echo '<a href="/">Página inicial</a>';
        return; 
    }
    $itemId = $params['item'];
    // Consulta para obtener los detalles del juego
    $query = mysqli_query($conn, "SELECT * FROM videojuegos WHERE id = '$itemId'")
        or die(mysqli_error($conn));

    $item = mysqli_fetch_array($query);

    if (!$item) {
        echo "No existe un videojuego con ID '$itemId'<br>";
        echo '<a href="/">Página inicial</a>';
        exit();
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Juego</title>
</head>
<body>
    <h2>Modificar Juego</h2>
    <form action="modify_item.php" method="post">
        <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
        
        <label for="titulo">Título:</label>
        <input type="text" name="titulo" id="titulo" value="<?php echo $item['Titulo']; ?>" required><br>

        <label for="desarrolladora">Desarrolladora:</label>
        <input type="text" name="desarrolladora" id="desarrolladora" value="<?php echo $item['Desarrolladora']; ?>" required><br>

        <label for="rating">Rating:</label>
        <input type="number" step="0.1" name="rating" id="rating" value="<?php echo $item['Rating']; ?>" required min="0" max="10"><br>

        <label for="precio">Precio:</label>
        <input type="number" step="0.01" name="precio" id="precio" value="<?php echo $item['Precio']; ?>" required min="0"><br>

        <input type="submit" value="Modificar">
    </form>
    <a href="/">Volver a la página principal</a>
</body>
</html>
<?php
}
?>

