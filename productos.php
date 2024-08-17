<?php include("template/cabecera.php"); ?>

<!-- Conexión a base de datos -->
<?php include("administrador/config/bd.php");
// Variables para conexion con el host



// Obtener la categoría seleccionada del formulario
$categoriaSeleccionada = isset($_POST['txtCategoria']) ? $_POST['txtCategoria'] : 'todas';

if (isset($categoriaSeleccionada)) {
    if ($categoriaSeleccionada == 'todas') {
        $sentenciaSQL = $conexion->prepare("SELECT * FROM Productos");
        $sentenciaSQL->execute();
        $listaProductos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $sentenciaSQL = $conexion->prepare("SELECT * FROM Productos WHERE Categorias_ID_Categoria=:IdCategoria");
        $sentenciaSQL->bindParam(":IdCategoria", $categoriaSeleccionada);
        $sentenciaSQL->execute();
        $listaProductos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

        echo "<script>
        window.onload = function() {
            var element = document.getElementById('tabla-productos');
            if (element) {
                element.scrollIntoView({behavior: 'auto'});
            }
        };
      </script>";
    }
}

?>

<br>

<div class="row">
    <!-- Sidebar -->
    <aside class="col-md-2">
        
        <form method="POST" action="">
            <div data-mdb-input-init class="categoria mb-2">
                <label class="form-label">Filtrar por:</label>
                <select name="txtFiltro" id="categoria" class="form-control" onchange="this.form.submit()">
                    <option value="todas" <?php if ($categoriaSeleccionada == 'todas') echo 'selected'; ?>>Todas las Categorías</option>
                    <?php
                    $sentenciaSQL = $conexion->prepare("SELECT * FROM Categorias");
                    $sentenciaSQL->execute();
                    $listaCategorias = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($listaCategorias as $categoria) { ?>
                        <option value="<?php echo htmlspecialchars($categoria['ID_Categoria']); ?>" <?php if ($categoriaSeleccionada == $categoria['ID_Categoria']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($categoria['Nombre_Categoria']); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </form>
        <div class="card">
            <div class="card-header">
                Categorias
            </div>
            <div>
                <form method="POST">
                    <!-- Botón para Todas las categorías -->
                    <button type="submit" class="btn text-secondary" style="width: 100%; text-align:left;" name="txtCategoria" value="todas" <?php if ($categoriaSeleccionada == 'todas') echo 'style="font-weight: bold;"'; ?>>
                        Todas las categorías
                    </button>

                    <?php
                    $sentenciaSQL = $conexion->prepare("SELECT * FROM Categorias");
                    $sentenciaSQL->execute();
                    $listaCategorias = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($listaCategorias as $categoria) { ?>
                        <button style="width: 100%; text-align:left;" type="submit" class="btn text-secondary" name="txtCategoria" value="<?php echo htmlspecialchars($categoria['ID_Categoria']); ?>" <?php if ($categoriaSeleccionada == $categoria['ID_Categoria']) echo 'style="font-weight: bold;"'; ?>>
                            <?php echo htmlspecialchars($categoria['Nombre_Categoria']); ?>
                        </button>
                    <?php } ?>
                </form>
            </div>
        </div>

    </aside>

    <!-- Productos -->
    <div class="col-md-10">
        <div class="row">
            <?php foreach ($listaProductos as $producto) { ?>
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <img class="card-img-top" src="./imgProductos/<?php echo htmlspecialchars($producto['Imagen_Producto']) ?>" alt="">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($producto['Nombre_Producto']) ?></h5>
                                <p class="text-info"><?php echo "$ ".htmlspecialchars($producto['Precio_Producto']) ?></p>
                                <?php if($producto['Tiene_Stock_Producto']==0) { ?>
                                    <p class="text-danger"><?php echo "Sin Stock" ?></p>
                                <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>





<?php include("template/pie.php"); ?>