<?php 
try {
    $host="lautaro-luna-lautaroluna906-b4ca.h.aivencloud.com";
    $port = '17205';
    $bd="defaultdb";
    $usuario="avnadmin";
    $contrasenia="AVNS_aOVthXr6XdGle8n0350";

    // Conexion PDO con la base de datos
    $conexion=new PDO("mysql:host=$host;port=$port;dbname=$bd",$usuario,$contrasenia);

} catch ( Exception $ex) {
    // En caso de fallo en la conexion con la BD
    echo $ex->getMessage();
}
