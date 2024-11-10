<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validación de campos
    if (empty($_POST['id']) || empty($_POST['titulo']) || empty($_POST['desarrolladora']) || empty($_POST['rating'])
            || empty($_POST['precio']) || empty($_POST['genero'])) {
        echo "Todos los campos son obligatorios.";
        exit();
    }

    // Recogemos y validamos los datos de entrada
    $id = (int)$_POST['id'];
    $titulo = $_POST['titulo'];
    $desarrolladora = $_POST['desarrolladora'];
    $rating = (float)$_POST['rating'];
    $precio = (float)$_POST['precio'];
    $genero = $_POST['genero'];

    // Consulta parametrizada para actualizar el juego
    $query = "UPDATE videojuegos SET titulo = ?, desarrolladora = ?, rating = ?, precio = ?, genero = ? WHERE id = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        // Vinculamos los parámetros
        $stmt->bind_param("ssddsi", $titulo, $desarrolladora, $rating, $precio, $genero, $id);

        // Ejecutamos la consulta
        if ($stmt->execute()) {
            header("Location: /items?message=Juego%20modificado%20exitosamente");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        // Cerramos la declaración
        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $conn->error;
    }

    $conn->close();
} else {
    parse_str($_SERVER['QUERY_STRING'], $params);

    if (!isset($params['item'])) {
        echo 'No se ha especificado un ID de videojuego<br>';
        echo '<a href="/">Página inicial</a>';
        return;
    }

    $itemId = (int)$params['item']; // Sanitizamos el valor recibido para evitar inyecciones

    // Consulta parametrizada para obtener los detalles del juego
    $stmt = $conn->prepare("SELECT * FROM videojuegos WHERE id = ?");
    if ($stmt) {
        // Vinculamos el parámetro
        $stmt->bind_param("i", $itemId);
        $stmt->execute();

        // Obtenemos el resultado
        $result = $stmt->get_result();
        $item = $result->fetch_assoc();

        if (!$item) {
            echo "No existe un videojuego con ID '$itemId'<br>";
            echo '<a href="/">Página inicial</a>';
            exit();
        }

        // Cerramos la declaración
        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $conn->error;
        exit();
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Juego</title>
    <link rel="stylesheet" type="text/css" href="estilos.css">
    <?php if (isset($_SESSION['usuario'])): ?>
    <script src="inactividad.js"></script>
    <?php endif; ?>
</head>

<body class="añadir-juego">
    <h1>Modificar Juego</h1>
    <form action="modify_item.php" id="item_modify_form" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($item['id']); ?>">

        <label for="titulo">Título:</label>
        <input type="text" name="titulo" id="titulo" value="<?php echo htmlspecialchars($item['titulo']); ?>" required><br>

        <label for="desarrolladora">Desarrolladora:</label>
        <input type="text" name="desarrolladora" id="desarrolladora" value="<?php echo htmlspecialchars($item['desarrolladora']); ?>" required><br>

        <label for="rating">Rating:</label>
        <input type="number" step="0.1" name="rating" id="rating" value="<?php echo htmlspecialchars($item['rating']); ?>" required min="0" max="10"><br>

        <label for="precio">Precio:</label>
        <input type="number" step="0.01" name="precio" id="precio" value="<?php echo htmlspecialchars($item['precio']); ?>" required min="0"><br>

        <label for="genero">Género:</label>
        <input type="text" name="genero" id="genero" value="<?php echo htmlspecialchars($item['genero']); ?>" required><br>

        <input type="submit" id="item_modify_submit" value="Modificar">
    </form>
    <a href="/">Volver a la página principal</a>
</body>
</html>
<?php
}
?>
