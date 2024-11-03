<?php 
session_start();

// Duración máxima en segundos (ejemplo: 30 minutos)
$duracion_sesion = 1800;
if (isset($_SESSION['ultima_actividad']) && (time() - $_SESSION['ultima_actividad'] > $duracion_sesion)) {
    session_unset(); // Eliminar variables de sesión
    session_destroy(); // Destruir la sesión
    //header('Location: /');
    echo "<script>
            alert('Tu sesión ha expirado. Por favor, inicia sesión nuevamente.');
            window.location.href = '/';
          </script>";
    //echo '<script>window.location.href="/";</script>'; // Redirigir a inicio de sesión
    exit();
}

$_SESSION['ultima_actividad'] = time(); // Actualizar tiempo de última actividad
?>
