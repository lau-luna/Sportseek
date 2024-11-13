<?php include("template/cabecera.php"); ?>

<!-- Conexión a base de datos -->
<?php include("administrador/config/bd.php");

// Verifica si se ha enviado una búsqueda

$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';


// Dividir la búsqueda en palabras (si hay más de una)
$palabras = explode(' ', $busqueda);
$condiciones = [];
$params = [];

// Crear las condiciones para nombre o categoría
if ($busqueda) {
    foreach ($palabras as $index => $palabra) {
        // Añadir las condiciones para cada palabra en la búsqueda
        $params[":busqueda$index"] = "%" . strtolower($palabra) . "%";
        $condiciones[] = "(LOWER(Productos.Nombre_Producto) LIKE :busqueda$index OR LOWER(Categorias.Nombre_Categoria) LIKE :busqueda$index)";
    }
    $condicionesStr = implode(' OR ', $condiciones);
} else {
    $condicionesStr = '1'; // Siempre verdadero si no hay búsqueda
}

// Configuración de paginación
$productosPorPagina = 15;
$paginaActual = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
$offset = ($paginaActual - 1) * $productosPorPagina;

// Obtener la categoría seleccionada y el filtro desde GET
$categoriaSeleccionada = (isset($_GET['txtCategoria'])) ? $_GET['txtCategoria'] : 'todas';
$filtroSeleccionado = (isset($_GET['txtFiltro']) && preg_match('/^[a-zA-Z]+$/',  $_GET['txtFiltro'])) ? $_GET['txtFiltro'] : 'ninguno';


// Preparar la consulta SQL base
$sqlBase = "SELECT Productos.*, Categorias.Nombre_Categoria, 
            MATCH (Productos.Nombre_Producto) AGAINST (:busqueda IN BOOLEAN MODE) AS relevance
            FROM Productos
            INNER JOIN Categorias ON Productos.Categorias_ID_Categoria = Categorias.ID_Categoria
            WHERE $condicionesStr";

// Añadir filtro de categoría si es necesario
if ($categoriaSeleccionada != 'todas') {
    $sqlBase .= " AND Productos.Categorias_ID_Categoria = :IdCategoria";
}

// Añadir filtro y ordenamiento
$sqlBase .= " ORDER BY 
            CASE 
                WHEN :filtro = 'precioMasBajo' THEN Precio_Producto 
                WHEN :filtro = 'precioMasAlto' THEN Precio_Producto * -1 
                WHEN :busqueda = '' THEN ID_Producto
                ELSE relevance 
            END DESC 
            LIMIT :limit OFFSET :offset";

// Preparar la consulta
$sentenciaSQL = $conexion->prepare($sqlBase);

// Asignar parámetros de búsqueda
foreach ($params as $param => $value) {
    $sentenciaSQL->bindValue($param, $value, PDO::PARAM_STR);
}
if ($categoriaSeleccionada != 'todas') {
    $sentenciaSQL->bindValue(':IdCategoria', $categoriaSeleccionada, PDO::PARAM_INT);
}
$sentenciaSQL->bindValue(':filtro', $filtroSeleccionado, PDO::PARAM_STR);
$sentenciaSQL->bindValue(':limit', $productosPorPagina, PDO::PARAM_INT);
$sentenciaSQL->bindValue(':offset', $offset, PDO::PARAM_INT);
$sentenciaSQL->bindValue(':busqueda', $busqueda, PDO::PARAM_STR);

// Ejecutar la consulta
$sentenciaSQL->execute();
$listaProductos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

// Obtener el número total de productos que coinciden con la búsqueda
$sqlCount = "SELECT COUNT(*) FROM Productos
            INNER JOIN Categorias ON Productos.Categorias_ID_Categoria = Categorias.ID_Categoria
            WHERE $condicionesStr";
if ($categoriaSeleccionada != 'todas') {
    $sqlCount .= " AND Productos.Categorias_ID_Categoria = :IdCategoria";
}
$sentenciaSQLCount = $conexion->prepare($sqlCount);
if ($categoriaSeleccionada != 'todas') {
    $sentenciaSQLCount->bindValue(":IdCategoria", $categoriaSeleccionada, PDO::PARAM_INT);
}
foreach ($params as $param => $value) {
    $sentenciaSQLCount->bindValue($param, $value, PDO::PARAM_STR);
}
$sentenciaSQLCount->execute();
$totalProductos = $sentenciaSQLCount->fetchColumn();
$totalPaginas = ceil($totalProductos / $productosPorPagina);
?>

<br>
<br>

<div class="contenedorProductos" id="filtros">
    <!-- Sidebar -->
    <aside class="ml-4 mr-3 aside-desktop">
        <!-- Formulario de filtros -->
        <form method="GET" action="">
            <div data-mdb-input-init class="categoria mb-2">
                <label class="form-label">Filtrar por:</label>
                <select name="txtFiltro" id="filtro" class="form-control" onchange="this.form.submit()">
                    <option value="ninguno" <?php if ($filtroSeleccionado == 'ninguno') echo 'selected'; ?>>Sin filtro</option>
                    <option value="precioMasBajo" <?php if ($filtroSeleccionado == 'precioMasBajo') echo 'selected'; ?>>Precio más alto</option>
                    <option value="precioMasAlto" <?php if ($filtroSeleccionado == 'precioMasAlto') echo 'selected'; ?>>Precio más bajo</option>
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
                    <input type="hidden" name="pagina" value="<?php if ($categoriaSeleccionada == 'todas' && $paginaActual != 1) {
                                                                    echo htmlspecialchars(1);
                                                                } else {
                                                                    echo htmlspecialchars($paginaActual);
                                                                } ?>">

                </form>
            </div>
        </div>
    </aside>

    <aside class="ml-4 mr-3 aside-mobile">
        <!-- Formulario de filtros -->
        <div class="filtros">
            <form method="GET" action="">
                <div data-mdb-input-init class="mb-2">
                    <label class="form-label">Filtrar por:</label>
                    <select name="txtFiltro" id="filtro" class="form-control" onchange="this.form.submit()">
                        <option value="ninguno" <?php if ($filtroSeleccionado == 'ninguno') echo 'selected'; ?>>Sin filtro</option>
                        <option value="precioMasBajo" <?php if ($filtroSeleccionado == 'precioMasBajo') echo 'selected'; ?>>Precio más alto</option>
                        <option value="precioMasAlto" <?php if ($filtroSeleccionado == 'precioMasAlto') echo 'selected'; ?>>Precio más bajo</option>
                    </select>
                    <!-- Campo oculto para mantener la búsqueda -->
                    <input type="hidden" name="busqueda" value="<?php echo htmlspecialchars($busqueda); ?>">
                    <input type="hidden" name="txtCategoria" value="<?php echo htmlspecialchars($categoriaSeleccionada); ?>">
                    <input type="hidden" name="pagina" value="<?php echo htmlspecialchars($paginaActual); ?>">
                </div>
            </form>
        </div>

        <div class="categorias">
            <form method="GET">
                <div class="dropdown dropdownCategorias">
                    <a class="btn btn-outline-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Categorías
                    </a>

                    <ul class="dropdown-menu">
                        <li>
                            <button type="submit" class="btn text-secondary" style="width: 100%; text-align:left; <?php if ($categoriaSeleccionada == 'todas') echo 'font-weight: bold;'; ?>" name="txtCategoria" value="todas">
                                Todas las categorías
                            </button>
                        </li>

                        <?php

                        $sentenciaSQL = $conexion->prepare("SELECT * FROM Categorias");
                        $sentenciaSQL->execute();
                        $listaCategorias = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($listaCategorias as $categoria) { ?>
                            <li>
                                <button style="width: 100%; text-align:left; <?php if ($categoriaSeleccionada == $categoria['ID_Categoria']) echo 'font-weight: bold;'; ?>" type="submit" class="btn text-secondary" name="txtCategoria" value="<?php echo htmlspecialchars($categoria['ID_Categoria']); ?>">
                                    <?php echo htmlspecialchars($categoria['Nombre_Categoria']); ?>
                                </button>
                            </li>

                        <?php } ?>
                        <!-- Mantener el filtro seleccionado en la URL -->
                        <input type="hidden" name="txtFiltro" value="<?php echo htmlspecialchars($filtroSeleccionado); ?>">
                        <input type="hidden" name="pagina" value="<?php if ($categoriaSeleccionada == 'todas' && $paginaActual != 1) {
                                                                        echo htmlspecialchars(1);
                                                                    } else {
                                                                        echo htmlspecialchars($paginaActual);
                                                                    } ?>">
                    </ul>
                </div>
            </form>


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
                    <div class=" col-md-3">
                        <form id="<?php echo $formId; ?>" action="productoDetalle.php" method="GET">
                            <input type="hidden" name="IdProducto" value="<?php echo htmlspecialchars($producto['ID_Producto']) ?>">
                            <input type="hidden" name="txtCategoria" value="<?php echo htmlspecialchars($categoriaSeleccionada); ?>">
                            <input type="hidden" name="txtFiltro" value="<?php echo htmlspecialchars($filtroSeleccionado); ?>">
                            <a href="#" style="text-decoration: none;" onclick="document.getElementById('<?php echo $formId; ?>').submit();">
                                <div class="cardLista-productos">
                                    <div class="cardProd-productos">
                                        <img class="card-img-topProd-productos w" src="./imgProductos/<?php echo htmlspecialchars($producto['Imagen_Producto']) ?>" alt="">
                                        <div class="card-bodyProd-productos">
                                            <h5 class="card-titleProd-productos"><?php echo htmlspecialchars($producto['Nombre_Producto']) ?></h5>
                                            <p class="text-infoProd-productos text-success"><?php echo "$ " . htmlspecialchars($producto['Precio_Producto']) ?></p>
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

        <!-- Navegación de páginas -->
        <nav aria-label="Page navigation">
            <ul class="pagination mt-4">
                <li class="page-item <?php if ($paginaActual <= 1) echo 'disabled'; ?>">
                    <a class="page-link" href="?busqueda=<?php echo htmlspecialchars($busqueda); ?>&txtCategoria=<?php echo htmlspecialchars($categoriaSeleccionada); ?>&txtFiltro=<?php echo htmlspecialchars($filtroSeleccionado); ?>&pagina=<?php echo $paginaActual - 1; ?>" tabindex="-1">Anterior</a>
                </li>
                <?php for ($i = 1; $i <= $totalPaginas; $i++) { ?>
                    <li class="page-item <?php if ($i == $paginaActual) echo 'active'; ?>">
                        <a class="page-link" href="?busqueda=<?php echo htmlspecialchars($busqueda); ?>&txtCategoria=<?php echo htmlspecialchars($categoriaSeleccionada); ?>&txtFiltro=<?php echo htmlspecialchars($filtroSeleccionado); ?>&pagina=<?php echo $i; ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php } ?>
                <li class="page-item <?php if ($paginaActual >= $totalPaginas) echo 'disabled'; ?>">
                    <a class="page-link" href="?busqueda=<?php echo htmlspecialchars($busqueda); ?>&txtCategoria=<?php echo htmlspecialchars($categoriaSeleccionada); ?>&txtFiltro=<?php echo htmlspecialchars($filtroSeleccionado); ?>&pagina=<?php echo $paginaActual + 1; ?>">Siguiente</a>
                </li>
            </ul>
        </nav>
    </div>
</div>

<?php include("template/pie.php"); ?>