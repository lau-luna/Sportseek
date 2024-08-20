<?php include("template/cabecera.php"); ?>

<!-- Conexión a base de datos -->
<?php include("administrador/config/bd.php");

// Verifica si se ha enviado una búsqueda
$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : "";

// Configuración de paginación
$productosPorPagina = 12;
$paginaActual = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
$offset = ($paginaActual - 1) * $productosPorPagina;

// Obtener la categoría seleccionada y el filtro desde GET
$categoriaSeleccionada = isset($_GET['txtCategoria']) ? $_GET['txtCategoria'] : 'todas';
$filtroSeleccionado = isset($_GET['txtFiltro']) ? $_GET['txtFiltro'] : 'ninguno';

// Consulta para la búsqueda
if ($busqueda) {
    if ($categoriaSeleccionada == 'todas') {
        $sentenciaSQL = $conexion->prepare("SELECT * FROM Productos WHERE Nombre_Producto LIKE :busqueda ORDER BY 
        CASE 
            WHEN :filtro = 'precioMasBajo' THEN Precio_Producto 
            WHEN :filtro = 'precioMasAlto' THEN Precio_Producto * -1 
            ELSE ID_Producto 
        END LIMIT :limit OFFSET :offset");
    } else {
        $sentenciaSQL = $conexion->prepare("SELECT * FROM Productos WHERE Categorias_ID_Categoria=:IdCategoria 
        AND Nombre_Producto LIKE :busqueda ORDER BY 
        CASE 
            WHEN :filtro = 'precioMasBajo' THEN Precio_Producto 
            WHEN :filtro = 'precioMasAlto' THEN Precio_Producto * -1 
            ELSE ID_Producto 
        END LIMIT :limit OFFSET :offset");
        $sentenciaSQL->bindParam(":IdCategoria", $categoriaSeleccionada);
    }
    $sentenciaSQL->bindValue(':busqueda', '%' . $busqueda . '%', PDO::PARAM_STR);
    $sentenciaSQL->bindValue(':filtro', $filtroSeleccionado, PDO::PARAM_STR);
    $sentenciaSQL->bindValue(':limit', $productosPorPagina, PDO::PARAM_INT);
    $sentenciaSQL->bindValue(':offset', $offset, PDO::PARAM_INT);
    $sentenciaSQL->execute();
    $listaProductos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    // Obtener el número total de productos que coinciden con la búsqueda para la paginación
    $sentenciaSQLCount = $conexion->prepare("SELECT COUNT(*) FROM Productos WHERE Nombre_Producto LIKE :busqueda");
    if ($categoriaSeleccionada != 'todas') {
        $sentenciaSQLCount->bindParam(":IdCategoria", $categoriaSeleccionada);
    }
    $sentenciaSQLCount->bindValue(':busqueda', '%' . $busqueda . '%', PDO::PARAM_STR);
    $sentenciaSQLCount->execute();
    $totalProductos = $sentenciaSQLCount->fetchColumn();
    $totalPaginas = ceil($totalProductos / $productosPorPagina);
} else {
    // Consulta cuando no hay búsqueda
    if ($categoriaSeleccionada == 'todas') {
        switch ($filtroSeleccionado) {
            case 'precioMasBajo':
                $sentenciaSQL = $conexion->prepare("SELECT * FROM Productos ORDER BY Precio_Producto ASC LIMIT :limit OFFSET :offset");
                break;
            case 'precioMasAlto':
                $sentenciaSQL = $conexion->prepare("SELECT * FROM Productos ORDER BY Precio_Producto DESC LIMIT :limit OFFSET :offset");
                break;
            case 'ninguno':
                $sentenciaSQL = $conexion->prepare("SELECT * FROM Productos ORDER BY ID_Producto DESC LIMIT :limit OFFSET :offset");
                break;
        }
    } else {
        switch ($filtroSeleccionado) {
            case 'precioMasBajo':
                $sentenciaSQL = $conexion->prepare("SELECT * FROM Productos WHERE Categorias_ID_Categoria=:IdCategoria ORDER BY Precio_Producto ASC LIMIT :limit OFFSET :offset");
                break;
            case 'precioMasAlto':
                $sentenciaSQL = $conexion->prepare("SELECT * FROM Productos WHERE Categorias_ID_Categoria=:IdCategoria ORDER BY Precio_Producto DESC LIMIT :limit OFFSET :offset");
                break;
            case 'ninguno':
                $sentenciaSQL = $conexion->prepare("SELECT * FROM Productos WHERE Categorias_ID_Categoria=:IdCategoria ORDER BY ID_Producto DESC LIMIT :limit OFFSET :offset");
                break;
        }
        $sentenciaSQL->bindParam(":IdCategoria", $categoriaSeleccionada);
    }

    $sentenciaSQL->bindValue(':limit', $productosPorPagina, PDO::PARAM_INT);
    $sentenciaSQL->bindValue(':offset', $offset, PDO::PARAM_INT);
    $sentenciaSQL->execute();
    $listaProductos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    // Obtener el número total de productos para paginación
    if ($categoriaSeleccionada == 'todas') {
        $sentenciaSQLCount = $conexion->prepare("SELECT COUNT(*) FROM Productos");
    } else {
        $sentenciaSQLCount = $conexion->prepare("SELECT COUNT(*) FROM Productos WHERE Categorias_ID_Categoria=:IdCategoria");
        $sentenciaSQLCount->bindParam(":IdCategoria", $categoriaSeleccionada);
    }
    $sentenciaSQLCount->execute();
    $totalProductos = $sentenciaSQLCount->fetchColumn();
    $totalPaginas = ceil($totalProductos / $productosPorPagina);
}

echo "<script>
    window.onload = function() {
        var element = document.getElementById('tabla-productos');
        if (element) {
            element.scrollIntoView({behavior: 'auto'});
        }
    };
</script>";
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
                <!-- Campo oculto para mantener la búsqueda -->
                <input type="hidden" name="busqueda" value="<?php echo htmlspecialchars($busqueda); ?>">
                <input type="hidden" name="txtCategoria" value="<?php echo htmlspecialchars($categoriaSeleccionada); ?>">
                <input type="hidden" name="pagina" value="<?php echo htmlspecialchars($paginaActual); ?>">
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
                    <input type="hidden" name="pagina" value="<?php echo htmlspecialchars($paginaActual); ?>">
                </form>
            </div>
        </div>

    </aside>

    <!-- Productos -->
    <div class="col-md-10">
        <div class="row">
            <?php if (!empty($listaProductos)) { ?>
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
                                <div class="cardLista">
                                    <div class="cardProd">
                                        <img class="card-img-topProd img-square" src="./imgProductos/<?php echo htmlspecialchars($producto['Imagen_Producto']) ?>" alt="">
                                        <div class="card-bodyProd">
                                            <h5 class="card-titleProd"><?php echo htmlspecialchars($producto['Nombre_Producto']) ?></h5>
                                            <p class="text-infoProd"><?php echo "$ " . htmlspecialchars($producto['Precio_Producto']) ?></p>
                                            <?php if ($producto['Tiene_Stock_Producto'] == 0) { ?>
                                                <p class="text-danger stock-labelProd"><?php echo "Sin Stock" ?></p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>


                            </a>
                        </form>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p>No se encontraron productos que coincidan con la búsqueda.</p>
            <?php } ?>
        </div>

        <!-- Productos -->
        <div class="col-md-10">
            <div class="row">

            </div>

            <!-- Navegación de páginas -->
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <li class="page-item <?php if ($paginaActual <= 1) echo 'disabled'; ?>">
                        <a class="page-link" href="?pagina=<?php echo max(1, $paginaActual - 1); ?>&txtCategoria=<?php echo htmlspecialchars($categoriaSeleccionada); ?>&txtFiltro=<?php echo htmlspecialchars($filtroSeleccionado); ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <?php for ($i = 1; $i <= $totalPaginas; $i++) { ?>
                        <li class="page-item <?php if ($i == $paginaActual) echo 'active'; ?>">
                            <a class="page-link" href="?pagina=<?php echo $i; ?>&txtCategoria=<?php echo htmlspecialchars($categoriaSeleccionada); ?>&txtFiltro=<?php echo htmlspecialchars($filtroSeleccionado); ?>">
                                <?php echo $i; ?>
                            </a>
                        </li>
                    <?php } ?>
                    <li class="page-item <?php if ($paginaActual >= $totalPaginas) echo 'disabled'; ?>">
                        <a class="page-link" href="?pagina=<?php echo min($totalPaginas, $paginaActual + 1); ?>&txtCategoria=<?php echo htmlspecialchars($categoriaSeleccionada); ?>&txtFiltro=<?php echo htmlspecialchars($filtroSeleccionado); ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>

        </div>
    </div>

    <?php include("template/pie.php"); ?>