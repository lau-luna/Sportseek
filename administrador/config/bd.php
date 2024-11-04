<?php 
try {
    $host = getenv('DB_HOST');
    $port = getenv('DB_PORT');
    $bd = getenv('DB_NAME');
    $usuario = getenv('DB_USER');
    $contrasenia = getenv('DB_PASSWORD');

    // Conexión PDO con la base de datos
    $dsn = "mysql:host=$host;port=$port;dbname=$bd;charset=utf8mb4"; // Agrega charset
    $conexion = new PDO($dsn, $usuario, $contrasenia);
    
    // Configuración de atributos PDO
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch (Exception $ex) {
    // En caso de fallo en la conexión con la BD
    echo $ex->getMessage();
}
