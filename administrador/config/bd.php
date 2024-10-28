<?php 
try {
    $host = getenv('DB_HOST');
    $port = getenv('DB_PORT');
    $bd = getenv('DB_NAME');
    $usuario = getenv('DB_USER');
    $contrasenia = getenv('DB_PASSWORD');

    // Conexión PDO con la base de datos
    $conexion = new PDO("mysql:host=$host;port=$port;dbname=$bd", $usuario, $contrasenia);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $ex) {
    // Manejo de errores más específico
    echo "Error de conexión: " . $ex->getMessage();
}