<?php
// Proceso para conectarese a la base de datos
// Si no puede establecerse la conexión a la BD, logea el error
// Si se conecta, crea, la variable $conn

if (strlen($_ENV["DB_USER"]) == 0 || strlen($_ENV["DB_PASS"]) == 0
    || strlen($_ENV["DB_HOSTNAME"]) == 0 || strlen($_ENV["DB_NOMBREDB"]) == 0
) {
    error_log(
        "
        No se han definido todas las variables de entorno necesarias para conectarse a la BD:
        " . $_ENV["DB_USER"] . ":" . $_ENV["DB_PASS"] . ":" . $_ENV["DB_HOSTNAME"] . ":" . $_ENV["DB_NOMBREDB"]);
    
    die("<p>Error interno del servidor</p>");
}

else {
    $servername = $_ENV["DB_HOSTNAME"];
    $username = $_ENV["DB_USER"];
    $password = $_ENV["DB_PASS"];
    $dbname = $_ENV["DB_NOMBREDB"];
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        error_log("No se ha podido establecer una conexión con la BD: " . $conn->connect_error);
        die("<p>Error interno del servidor</p>");
    }
}

?>
