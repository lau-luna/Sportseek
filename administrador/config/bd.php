<?php 
try {
    $host = getenv('DB_HOST');
    $port = getenv('DB_PORT');
    $bd = getenv('DB_NAME');
    $usuario = getenv('DB_USER');
    $contrasenia = getenv('DB_PASSWORD');

    // Conexión PDO con la base de datos
    $conexion = new PDO("mysql:host=$host;port=$port;dbname=$bd", $usuario, $contrasenia);

} catch (Exception $ex) {
    // En caso de fallo en la conexión con la BD
    echo $ex->getMessage();
}