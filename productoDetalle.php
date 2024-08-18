<?php include("template/cabecera.php"); ?>

<!-- Conexión a base de datos -->
<?php include("administrador/config/bd.php"); ?>
<br>
<?php
$sentenciaSQL = $conexion->prepare("SELECT * FROM Productos WHERE ID_Producto=:id");
$sentenciaSQL->bindParam(':id', $_POST['IdProducto']);
$sentenciaSQL->execute();
$producto = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
$sentenciaSQL = $conexion->prepare("SELECT Categorias.Nombre_Categoria FROM Productos INNER JOIN Categorias ON Categorias.ID_Categoria=:IdCategoria WHERE ID_Producto=:id");
$sentenciaSQL->bindParam(':IdCategoria', $producto['Categorias_ID_Categoria']);
$sentenciaSQL->bindParam(':id', $_POST['IdProducto']);
$sentenciaSQL->execute();
$categoria = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

?>

<div class="container">
    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <img class="card-img-top" src="./imgProductos/<?php echo htmlspecialchars($producto['Imagen_Producto']) ?>" alt="Sin Imagen.">
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <p class="card-text text-success mb-1" style="font-size: smaller;"> <?php echo htmlspecialchars($categoria['Nombre_Categoria']) ?> </p>
                    <h3 class="card-title text-info"> <?php echo htmlspecialchars($producto['Nombre_Producto']) ?> </h3>
                    <p class="card-text text-danger mb-1" style="font-size:large;">$ <?php echo htmlspecialchars($producto['Precio_Producto']) ?> </p>
                    <div class="mb-4"></div>

                    <?php if ($producto['Tiene_Stock_Producto'] == 0) { ?>
                        <div class="alert alert-danger" role="alert">
                            Sin stock!
                        </div>
                    <?php } ?>

                    <p class=" mb-0" style="font-size:large; font-weight:bold;">Descripción</p>
                    <hr style="margin-top: 0.5%; margin-bottom: 1%;">
                    <p class="card-text mb-2" style="margin-bottom: 4%;"><?php echo htmlspecialchars($producto['Descripcion_Producto']) ?></p>

                    <p class="mb-0" style="font-size:large; font-weight:bold;">Especificaciones</p>
                    <hr style="margin-top: 0.5%; margin-bottom: 1%;">
                    <p class="card-text"><?php echo htmlspecialchars($producto['Especificaciones_Producto']) ?></p>
                </div>
                <div class="card-footer text-muted">
                    Sportseek
                </div>
            </div>
        </div>

    </div>

</div>



<?php include("template/pie.php"); ?>