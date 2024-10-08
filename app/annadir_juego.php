<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['titulo']) || empty($_POST['desarrolladora']) || empty($_POST['rating']) || empty($_POST['precio'])) {
        echo "Todos los campos son obligatorios.";
        exit();
    }

    $titulo = $_POST['titulo'];
    $desarrolladora = $_POST['desarrolladora'];
    $rating = (float)$_POST['rating'];
    $precio = (float)$_POST['precio'];

    $query = "INSERT INTO videojuegos (Titulo, Desarrolladora, Rating, Precio) VALUES ('$titulo', '$desarrolladora', '$rating', $precio)";

    if ($conn->query($query) === TRUE) {
        header("Location: /?message=Juego%20añadido%20exitosamente");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
} else {
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir Juego</title>
</head>
<body>
    <h2>Añadir Juego</h2>
    <form action="annadir_juego.php" method="post">


        <label for="titulo">Título:</label>
        <input type="text" name="titulo" id="titulo" required><br>

        <label for="desarrolladora">Desarrolladora:</label>
        <input type="text" name="desarrolladora" id="desarrolladora" required><br>

        <label for="rating">Rating:</label>
        <input type="number" step="0.1" name="rating" id="rating" required min="0" max="10"><br> <!-- step="0.1" permite decimales -->

        <label for="precio">Precio:</label>
        <input type="number" step="0.01" name="precio" id="precio" required min="0"><br> <!-- step="0.1" permite decimales -->

        <input type="submit" value="Añadir">
    </form>
    <a href="/">Volver a la página principal</a>
</body>
</html>
<?php
}
?>
