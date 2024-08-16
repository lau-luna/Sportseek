<?php include('template/cabecera.php');?>

<?php 
// Extraer de la bd una lista con todos los usuarios
$sentenciaSQL = $conexion->prepare("SELECT * FROM Usuarios WHERE ID_Usuario=:ID");
$sentenciaSQL->bindParam(':ID', $_SESSION['ID_Usuario']);
$sentenciaSQL->execute();
$usuario = $sentenciaSQL->fetch(PDO::FETCH_LAZY);
?>

<?php echo $usuario['ID_Usuario'] ?>
<br>
<?php echo $usuario['Username_Usuario'] ?>
<br>
<?php echo $usuario['Nombre_Usuario'] ?>
<br>
<?php echo $usuario['Apellidos_Usuario'] ?>
<br>
<?php echo $usuario['Email_Usuario'] ?>
<br>
<?php echo $usuario['DNI_Usuario'] ?>
<br>
<?php echo $usuario['Contrasenia_Usuario'] ?>
<br>
<?php echo $usuario['Direccion_Usuario'] ?>
<br>
<?php echo $usuario['Localidades_ID_Localidades'] ?>
<br>

<?php include('template/pie.php'); ?>