<?php include("template/cabecera.php"); ?>
<br> <br> <br>

<!-- Conexión a base de datos -->
<?php include("administrador/config/bd.php");
// Variables para conexion con el host


// Traer todos los datos de los productos en una lista
$sentenciaSQL= $conexion->prepare("SELECT * FROM productos");
$sentenciaSQL->execute();
$listaProductos=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>

<?php foreach($listaProductos as $producto) { ?>
<div class="col-md-2">
    <div class="card">
        <img class="card-img-top" src="./imgProductos/<?php echo $producto['Imagen_Producto'] ?>" alt="">
        <div class="card-body">
            <h4 class="card-title"><?php echo $producto['Nombre_Producto'] ?></h4>
            <a name="" id="" class="btn btn-primary" href="#" role="button">Añadir al carrito</a>
        </div>
    </div>
</div>

<?php } ?>



<?php include("template/pie.php"); ?>