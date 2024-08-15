<?php 
try {
    $host="localhost";
    $port = '3307';
    $bd="deportes";
    $usuario="root";
    $contrasenia="";

    // Conexion PDO con la base de datos
    $conexion=new PDO("mysql:host=$host;port=$port;dbname=$bd",$usuario,$contrasenia);

} catch ( Exception $ex) {
    // En caso de fallo en la concecion con la BD
      echo $ex->getMessage();
}
?>