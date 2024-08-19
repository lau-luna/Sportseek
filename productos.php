<?php include("template/cabecera.php"); ?>

<!-- Conexión a base de datos -->
<?php include("administrador/config/bd.php");
// Variables para conexion con el host



// Obtener la categoría seleccionada y el filtro desde GET
$categoriaSeleccionada = isset($_GET['txtCategoria']) ? $_GET['txtCategoria'] : 'todas';
$filtroSeleccionado = isset($_GET['txtFiltro']) ? $_GET['txtFiltro'] : 'ninguno';



if (isset($categoriaSeleccionada)) {
    if ($categoriaSeleccionada == 'todas') {
        switch ($filtroSeleccionado) {
            case 'precioMasBajo':
                $sentenciaSQL = $conexion->prepare("SELECT * FROM Productos ORDER BY Precio_Producto ASC");
                break;
            case 'precioMasAlto':
                $sentenciaSQL = $conexion->prepare("SELECT * FROM Productos ORDER BY Precio_Producto DESC");
                break;
            case 'ninguno':
                $sentenciaSQL = $conexion->prepare("SELECT * FROM Productos ORDER BY ID_Producto DESC");
                break;
        }
        $sentenciaSQL->execute();
        $listaProductos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
    } else {
        switch ($filtroSeleccionado) {
            case 'precioMasBajo':
                $sentenciaSQL = $conexion->prepare("SELECT * FROM Productos WHERE Categorias_ID_Categoria=:IdCategoria ORDER BY Precio_Producto ASC");
                break;
            case 'precioMasAlto':
                $sentenciaSQL = $conexion->prepare("SELECT * FROM Productos WHERE Categorias_ID_Categoria=:IdCategoria ORDER BY Precio_Producto DESC");
                break;
            case 'ninguno':
                $sentenciaSQL = $conexion->prepare("SELECT * FROM Productos WHERE Categorias_ID_Categoria=:IdCategoria ORDER BY ID_Producto DESC");
                break;
        }

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

        <!-- Formulario de filtros -->
            <form method="GET" action="">
                <div data-mdb-input-init class="categoria mb-2">
                    <label class="form-label">Filtrar por:</label>
                    <select name="txtFiltro" id="filtro" class="form-control" onchange="this.form.submit()">
                        <option value="ninguno" <?php if ($filtroSeleccionado == 'ninguno') echo 'selected'; ?>>Sin filtro</option>
                        <option value="precioMasBajo" <?php if ($filtroSeleccionado == 'precioMasBajo') echo 'selected'; ?>>Precio más bajo</option>
                        <option value="precioMasAlto" <?php if ($filtroSeleccionado == 'precioMasAlto') echo 'selected'; ?>>Precio más alto</option>
                    </select>
                    <!-- Campo oculto para mantener la categoría seleccionada -->
                    <input type="hidden" name="txtCategoria" value="<?php echo htmlspecialchars($categoriaSeleccionada); ?>">
                </div>
            </form>

            <div class="card">
                <div class="card-header">
                    Categorías
                </div>
                <div>
                    <form method="GET">
                        <!-- Botón para Todas las categorías -->
                        <button type="submit" class="btn text-secondary" style="width: 100%; text-align:left; <?php if ($categoriaSeleccionada == 'todas') echo 'font-weight: bold;'; ?>" name="txtCategoria" value="todas">
                            Todas las categorías
                        </button>

                        <?php
                        $sentenciaSQL = $conexion->prepare("SELECT * FROM Categorias");
                        $sentenciaSQL->execute();
                        $listaCategorias = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($listaCategorias as $categoria) { ?>
                            <button style="width: 100%; text-align:left; <?php if ($categoriaSeleccionada == $categoria['ID_Categoria']) echo 'font-weight: bold;'; ?>" type="submit" class="btn text-secondary" name="txtCategoria" value="<?php echo htmlspecialchars($categoria['ID_Categoria']); ?>">
                                <?php echo htmlspecialchars($categoria['Nombre_Categoria']); ?>
                            </button>
                        <?php } ?>
                        <!-- Mantener el filtro seleccionado en la URL -->
                        <input type="hidden" name="txtFiltro" value="<?php echo htmlspecialchars($filtroSeleccionado); ?>">
                    </form>
                </div>
            </div>

    </aside>

    <!-- Productos -->
    <div class="col-md-10">
        <div class="row">
            <?php foreach ($listaProductos as $producto) {
                // Generar un ID único para cada formulario
                $formId = 'postForm' . htmlspecialchars($producto['ID_Producto']);
            ?>
                <div class="col-md-3 mb-4">
                    <form id="<?php echo $formId; ?>" action="productoDetalle.php" method="GET">
                        <input type="hidden" name="IdProducto" value="<?php echo htmlspecialchars($producto['ID_Producto']) ?>">
                        <input type="hidden" name="txtCategoria" value="<?php echo htmlspecialchars($categoriaSeleccionada); ?>">
                        <input type="hidden" name="txtFiltro" value="<?php echo htmlspecialchars($filtroSeleccionado); ?>">
                        <a href="#" onclick="document.getElementById('<?php echo $formId; ?>').submit();">
                            <div class="card">
                                <img class="card-img-top" src="./imgProductos/<?php echo htmlspecialchars($producto['Imagen_Producto']) ?>" alt="">
                                <div class="card-body h-100">
                                    <h5 class="card-title"><?php echo htmlspecialchars($producto['Nombre_Producto']) ?></h5>
                                    <p class="text-info"><?php echo "$ " . htmlspecialchars($producto['Precio_Producto']) ?></p>
                                    <?php if ($producto['Tiene_Stock_Producto'] == 0) { ?>
                                        <p class="text-danger"><?php echo "Sin Stock" ?></p>
                                    <?php } ?>
                                </div>
                            </div>
                        </a>
                    </form>

                </div>
            <?php } ?>
        </div>
    </div>

</div>





<?php include("template/pie.php"); ?>