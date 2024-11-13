<?php 
try {
    $host = 'lau-raspberry-dev.freemyip.com';
    $port = '3306';
    $bd = 'sportseek';
    $usuario = 'root';
    $contrasenia = 'lau1545';

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