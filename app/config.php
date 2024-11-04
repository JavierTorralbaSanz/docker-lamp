<?php
// Proceso para conectarse a la base de datos
// Si no puede establecerse la conexión a la BD, logea el error
// Si se conecta, crea la variable $conn

if (strlen($_ENV["DB_USER"]) == 0 || strlen($_ENV["DB_PASS"]) == 0
    || strlen($_ENV["DB_HOSTNAME"]) == 0 || strlen($_ENV["DB_NOMBREDB"]) == 0
) {
    error_log(
        "No se han definido todas las variables de entorno necesarias para conectarse a la BD: "
        . "DB_USER=" . $_ENV["DB_USER"] . ", DB_PASS=" . $_ENV["DB_PASS"]
        . ", DB_HOSTNAME=" . $_ENV["DB_HOSTNAME"] . ", DB_NOMBREDB=" . $_ENV["DB_NOMBREDB"]
    );
    
    die("<p>Error interno del servidor</p>");
}

else {
    $db_servername = $_ENV["DB_HOSTNAME"];
    $db_username = $_ENV["DB_USER"];
    $db_password = $_ENV["DB_PASS"];
    $db_dbname = $_ENV["DB_NOMBREDB"];
    
    $conn = new mysqli($db_servername, $db_username, $db_password, $db_dbname);
    
    if ($conn->connect_error) {
        error_log("No se ha podido establecer una conexión con la BD: " . $conn->connect_error);
        die("<p>Error interno del servidor</p>");
    }
}

?>
