<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Videojuegos</title>
    <link rel="stylesheet" href="estilos.css"> <!-- Incluye el CSS externo -->
</head>
<body>


<?php
include 'config.php'; // Asegúrate de incluir tu configuración de base de datos

// Consulta para obtener todos los videojuegos
$query = "SELECT id, titulo, desarrolladora FROM videojuegos";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    echo "<h1>Lista de Videojuegos</h1>";
    echo "<ul>"; // Comienza una lista no ordenada

    // Recorre cada videojuego y muestra los datos
    while ($row = $result->fetch_assoc()) {
        echo "<li>";
        echo "<strong>Título:</strong> " . ($row['titulo']) . "<br>";  // Muestra el título
        echo "<strong>Desarrolladora:</strong> " . ($row['desarrolladora']) . "<br>";  // Muestra la desarrolladora
        echo "<a href='/show_item?item=" . ($row['id']) . " ' class='link-button'>Ver Detalles</a> | "; // Enlace a detalles
        echo "<a href='/modify_item?item=" . ($row['id']) . "' class='link-button' >Modificar</a> | "; // Enlace para modificar
        echo "<a href='/delete_item?item=" . ($row['id']) . "' class='link-button'>Eliminar</a>"; // Enlace para eliminar
        echo "</li>";
    }
    
    echo "</ul>"; // Cierra la lista no ordenada
} else {
    echo "<p>No hay videojuegos disponibles.</p>";
}

$conn->close(); // Cierra la conexión
?>
<a href="/">Volver a la página principal</a>
