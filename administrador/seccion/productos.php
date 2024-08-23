<?php include('../template/cabecera.php') ?>

<?php
// Recibir los datos del formulario y guardarlo en variables. Si no hay datos se guardan vacías
$txtID = (isset($_POST['txtID']) && preg_match('/^[0-9]+$/',  $_POST['txtID'])) ? $_POST['txtID'] : "";
$txtNombre = (isset($_POST['txtNombre']) && preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ,.0-9: ]+$/',  $_POST['txtNombre'])) ? $_POST['txtNombre'] : "";
$numPrecio = (isset($_POST['numPrecio']) && preg_match('/^[0-9]+$/',  $_POST['numPrecio'])) ? $_POST['numPrecio'] : "";
$boolStock = (isset($_POST['boolStock'])) ? 1 : 0;
$txtDescripcion = (isset($_POST['txtDescripcion']) && preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ,.0-9: ]+$/',  $_POST['txtDescripcion'])) ? $_POST['txtDescripcion'] : "";
$txtImagen = (isset($_FILES['txtImagen']['name'])) ? $_FILES['txtImagen']['name'] : "";
$txtEspecificaciones = (isset($_POST['txtEspecificaciones']) && preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ,.0-9: ]+$/',  $_POST['txtEspecificaciones'])) ? $_POST['txtEspecificaciones'] : "";
$txtCategoria = (isset($_POST['txtCategoria'])) ? $_POST['txtCategoria'] : "";
$accion = (isset($_POST['accion']) && preg_match('/^[a-zA-Z]+$/',  $_POST['accion'])) ? $_POST['accion'] : "";

include('../config/bd.php');

if ($_POST) {
    if (preg_match('/^[a-zA-Z]+$/',  $_POST['accion'])) {
            switch ($accion) {
                case "Agregar":
                    if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ.,: ]+$/',  $txtNombre) && preg_match('/^[0-9]+$/',  $numPrecio) && preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ.,: ]+$/',  $txtDescripcion) && preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ,.0-9: ]+$/',  $txtEspecificaciones)) { 
                         // Insertar datos a tabla Productos
                    $sentenciaSQL = $conexion->prepare("INSERT INTO Productos (Nombre_Producto, Precio_Producto, Descripcion_Producto, Tiene_Stock_Producto, Imagen_Producto, Especificaciones_Producto, Categorias_ID_Categoria) VALUES (:nombre, :precio, :descripcion, :stock, :imagen, :especificaciones, :IdCategoria);");
                    $sentenciaSQL->bindParam(':nombre', $txtNombre);
                    $sentenciaSQL->bindParam(':precio', $numPrecio);
                    $sentenciaSQL->bindParam(':descripcion', $txtDescripcion);
                    $sentenciaSQL->bindParam(':stock', $boolStock);

                    $fecha = new DateTime();
                    $nombreArchivo = ($txtImagen != "") ? $fecha->getTimestamp() . "_" . $_FILES["txtImagen"]["name"] : "imagen.jpg";

                    $tmpImagen = $_FILES["txtImagen"]["tmp_name"];

                    if ($tmpImagen != "") {
                        move_uploaded_file($tmpImagen, "../../imgProductos/" . $nombreArchivo);
                    }

                    $sentenciaSQL->bindParam(':imagen', $nombreArchivo);
                    $sentenciaSQL->bindParam(':especificaciones', $txtEspecificaciones);
                    $sentenciaSQL->bindParam(':IdCategoria', $txtCategoria);

                    $sentenciaSQL->execute();

                    header('Location:productos.php');

                    echo "<script>
                    window.onload = function() {
                        var element = document.getElementById('tabla-productos');
                        if (element) {
                            element.scrollIntoView({behavior: 'auto'});
                        }
                    };
                  </script>";
                    } else {
                        $mensaje =  "Error en los caracteres de los datos";
                    }
                   
                    break;
                case "Modificar":
                    if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ.,: ]+$/',  $txtNombre) && preg_match('/^[0-9]+$/',  $numPrecio) && preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ.,: ]+$/',  $txtDescripcion) && preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ,.0-9: ]+$/',  $txtEspecificaciones)) {
                    $sentenciaSQL = $conexion->prepare("UPDATE Productos SET Nombre_Producto=:nombre, Precio_Producto=:precio, Descripcion_Producto=:descripcion, Tiene_Stock_Producto=:stock, Especificaciones_Producto=:especificaciones, Categorias_ID_Categoria=:IdCategoria WHERE ID_Producto=:id");
                    $sentenciaSQL->bindParam(':nombre', $txtNombre);
                    $sentenciaSQL->bindParam(':precio', $numPrecio);
                    $sentenciaSQL->bindParam(':descripcion', $txtDescripcion);
                    $sentenciaSQL->bindParam(':stock', $boolStock);
                    $sentenciaSQL->bindParam(':especificaciones', $txtEspecificaciones);
                    $sentenciaSQL->bindParam(':IdCategoria', $txtCategoria);
                    $sentenciaSQL->bindParam(':id', $txtID);
                    $sentenciaSQL->execute();

                    if ($txtImagen != "") {
                        // Subir nueva imagen
                        $fecha = new DateTime();
                        $nombreArchivo = ($txtImagen != "") ? $fecha->getTimestamp() . "_" . $_FILES["txtImagen"]["name"] : "imagen.jpg";

                        $tmpImagen = $_FILES["txtImagen"]["tmp_name"];
                        move_uploaded_file($tmpImagen, "../../imgProductos/" . $nombreArchivo);

                        // Borrar Imagen anterior
                        $sentenciaSQL = $conexion->prepare("SELECT Imagen_Producto FROM Productos WHERE ID_Producto=:id");
                        $sentenciaSQL->bindParam(':id', $txtID);
                        $sentenciaSQL->execute();
                        $producto = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

                        if (isset($producto['Imagen_Producto']) && ($producto['Imagen_Producto'] != "imagen.jpg")) {
                            if (file_exists("../../imgProductos/" . $producto['Imagen_Producto'])) {
                                unlink("../../imgProductos/" . $producto['Imagen_Producto']);
                            }
                        }

                        $sentenciaSQL = $conexion->prepare("UPDATE Productos SET Imagen_Producto=:imagen WHERE ID_Producto=:id");
                        $sentenciaSQL->bindParam(':imagen', $nombreArchivo);
                        $sentenciaSQL->bindParam(':id', $txtID);
                        $sentenciaSQL->execute();
                    }

                    header('Location:productos.php');
                } else {
                    $mensaje =  "Error en los caracteres de los datos";
                }
                    break;
                case "Cancelar":
                    header('Location:productos.php');
                    break;
                case 'Seleccionar':
                    $sentenciaSQL = $conexion->prepare("SELECT * FROM Productos WHERE ID_Producto=:id");
                    $sentenciaSQL->bindParam(':id', $txtID);
                    $sentenciaSQL->execute();
                    $producto = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

                    $txtNombre = $producto['Nombre_Producto'];
                    $numPrecio = $producto['Precio_Producto'];
                    $txtDescripcion = $producto['Descripcion_Producto'];
                    $boolStock = $producto['Tiene_Stock_Producto'];
                    $txtImagen = $producto['Imagen_Producto'];
                    $txtCategoria = $producto['Categorias_ID_Categoria'];
                    $txtEspecificaciones = $producto['Especificaciones_Producto'];

                    break;
                case 'Borrar':
                    // Borrar Imagen
                    $sentenciaSQL = $conexion->prepare("SELECT Imagen_producto FROM Productos WHERE ID_Producto=:id");
                    $sentenciaSQL->bindParam(':id', $txtID);
                    $sentenciaSQL->execute();
                    $producto = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

                    if (isset($producto['Imagen_producto']) && ($producto['Imagen_producto'] != "imagen.jpg")) {
                        if (file_exists("../../imgProductos/" . $producto['Imagen_producto'])) {
                            unlink("../../imgProductos/" . $producto['Imagen_producto']);
                        }
                    }

                    // Borrar resto de datos
                    $sentenciaSQL = $conexion->prepare("DELETE FROM Productos WHERE ID_Producto=:id");
                    $sentenciaSQL->bindParam(':id', $txtID);
                    $sentenciaSQL->execute();

                    header('Location:productos.php');
                    break;
            }
        } else {
            $mensaje =  "Error en los caracteres de los datos";
        }
} 



include("../config/bd.php");





// Parámetros para la paginación
$productosPorPagina = 10;
$paginaActual = (isset($_GET['pagina']) && preg_match('/^[0-9]+$/',  $_GET['pagina'])) ? (int)$_GET['pagina'] : 1;
$offset = ($paginaActual - 1) * $productosPorPagina;

// Obtener la categoría seleccionada del formulario
$categoriaSeleccionada = (isset($_GET['txtCategoria']) && preg_match('/^[a-zA-ZnÑáéíóúÁÉÍÓÚ0-9 ]+$/',  $_GET['txtCategoria'])) ? $_GET['txtCategoria'] : 'todas';

if ($categoriaSeleccionada == 'todas') {
    $sentenciaSQL = $conexion->prepare("SELECT * FROM Productos ORDER BY ID_Producto DESC LIMIT :offset, :productosPorPagina");
    $sentenciaSQL->bindParam(':offset', $offset, PDO::PARAM_INT);
    $sentenciaSQL->bindParam(':productosPorPagina', $productosPorPagina, PDO::PARAM_INT);
    $sentenciaSQL->execute();
    $listaProductos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    $totalProductosSQL = $conexion->prepare("SELECT COUNT(*) FROM Productos ORDER BY ID_Producto DESC");
    $totalProductosSQL->execute();
    $totalProductos = $totalProductosSQL->fetchColumn();
} else {
    $sentenciaSQL = $conexion->prepare("SELECT * FROM Productos WHERE Categorias_ID_Categoria=:IdCategoria ORDER BY ID_Producto DESC LIMIT :offset, :productosPorPagina");
    $sentenciaSQL->bindParam(":IdCategoria", $categoriaSeleccionada);
    $sentenciaSQL->bindParam(':offset', $offset, PDO::PARAM_INT);
    $sentenciaSQL->bindParam(':productosPorPagina', $productosPorPagina, PDO::PARAM_INT);
    $sentenciaSQL->execute();
    $listaProductos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    $totalProductosSQL = $conexion->prepare("SELECT COUNT(*) FROM Productos WHERE Categorias_ID_Categoria=:IdCategoria ORDER BY ID_Producto DESC");
    $totalProductosSQL->bindParam(":IdCategoria", $categoriaSeleccionada);
    $totalProductosSQL->execute();
    $totalProductos = $totalProductosSQL->fetchColumn();
}

// Calcular el número total de páginas
$totalPaginas = ceil($totalProductos / $productosPorPagina);

?>

<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            Datos del producto
        </div>
        <div class="card-body">

            <form method="POST" enctype="multipart/form-data">

                <?php if (isset($mensaje)) { ?>
                    <div class="alert alert-danger" role="alert">
                        ⚠️ <?php echo htmlspecialchars($mensaje) ?>
                    </div>
                <?php } ?>
                <section style="display: flex;">
                    <div style="width: 48%; margin-right:4%;">
                        <div class="form-group">
                            <label for="txtID">ID:</label>
                            <input type="text" required readonly value="<?php echo htmlspecialchars($txtID); ?>" class="form-control" name="txtID" id="txtID" placeholder="ID">
                        </div>

                        <div class="form-group">
                            <label for="txtNombre">Nombre:</label>
                            <input type="text" required value="<?php echo htmlspecialchars($txtNombre); ?>" class="form-control" name="txtNombre" id="txtNombre" placeholder="Nombre del producto">
                        </div>

                        <div class="form-group">
                            <label for="numPrecio">Precio:</label>
                            <input type="number" min="0" required value="<?php echo $numPrecio; ?>" class="form-control" name="numPrecio" id="numPrecio" placeholder="Precio del producto">
                        </div>


                        <div class="form-group">
                            <label for="txtDescripcion">Descripción:</label>
                            <textarea required class="form-control" name="txtDescripcion" id="txtDescripcion" rows="5" placeholder="Descripción del producto"><?php echo htmlspecialchars($txtDescripcion); ?></textarea>
                        </div>
                    </div>

                    <div style="width: 48%;">
                        <div class="form-group">
                            <label for="boolStock">Stock:</label>
                            <input type="checkbox" <?php echo ($boolStock) ? "checked" : ""; ?> class="form-control" name="boolStock" id="boolStock">
                        </div>

                        <div class="form-group">
                            <label for="txtImagen">Imagen:</label>
                            <input type="file" class="form-control" name="txtImagen" id="txtImagen" placeholder="Nombre del producto">
                        </div>

                        <div class="form-group">
                            <label for="txtCategoria">Categoría:</label>
                            <select class="form-control" name="txtCategoria" id="txtCategoria">
                                <?php
                                $sentenciaSQL = $conexion->prepare("SELECT * FROM Categorias");
                                $sentenciaSQL->execute();
                                $listaCategorias = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($listaCategorias as $categoria) {
                                ?>
                                    <option value="<?php echo $categoria['ID_Categoria']; ?>" <?php echo ($txtCategoria == $categoria['ID_Categoria']) ? 'selected' : ''; ?>> <?php echo htmlspecialchars($categoria['Nombre_Categoria']) ?> </option>
                                <?php } ?>

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="txtEspecificaciones">Especificaciones:</label>
                            <textarea rows="5" class="form-control" name="txtEspecificaciones" id="txtEspecificaciones" placeholder="Especificaciones del producto"><?php echo htmlspecialchars($txtEspecificaciones); ?></textarea>
                        </div>
                    </div>


                </section>

                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" name="accion" <?php echo ($accion == "Seleccionar") ? "disabled" : ""; ?> value="Agregar" class="btn btn-success">Agregar</button>
                    <button type="submit" name="accion" <?php echo ($accion != "Seleccionar") ? "disabled" : ""; ?> value="Modificar" class="btn btn-warning">Modificar</button>
                    <button type="submit" name="accion" <?php echo ($accion != "Seleccionar") ? "disabled" : ""; ?> value="Cancelar" class="btn btn-info">Cancelar</button>
                </div>
            </form>

        </div>
    </div>
</div>


<div class="col-md-12" id="tabla-productos">

    <div class="table-responsive">
        <div class="card-header">
            Lista de productos
        </div>

        <div class="card-body">
            <form method="get" action="">
                <div class="form-group">
                    <label for="txtCategoria">Filtrar por categoría:</label>
                    <select class="form-control" name="txtCategoria" id="txtCategoria" onchange="this.form.submit()">
                        <option value="todas">Todas</option>
                        <?php
                        $sentenciaSQL = $conexion->prepare("SELECT * FROM Categorias");
                        $sentenciaSQL->execute();
                        $listaCategorias = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($listaCategorias as $categoria) {
                        ?>
                            <option value="<?php echo $categoria['ID_Categoria']; ?>" <?php echo ($categoriaSeleccionada == $categoria['ID_Categoria']) ? 'selected' : ''; ?>> <?php echo htmlspecialchars($categoria['Nombre_Categoria']) ?> </option>
                        <?php } ?>

                    </select>
                </div>
            </form>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Descripción</th>
                        <th>Stock</th>
                        <th>Imagen</th>
                        <th>Especificaciones</th>
                        <th>Categoría</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    foreach ($listaProductos as $producto) { ?>
                        <?php
                        $sentenciaSQL = $conexion->prepare("SELECT Nombre_Categoria FROM Categorias INNER JOIN Productos ON Categorias.ID_Categoria=Productos.Categorias_ID_Categoria WHERE Productos.ID_Producto=:IdProducto");
                        $sentenciaSQL->bindParam(":IdProducto", $producto['ID_Producto']);
                        $sentenciaSQL->execute();
                        $categoria = $sentenciaSQL->fetch(PDO::FETCH_LAZY);
                        ?>

                        <tr>
                            <td><?php echo htmlspecialchars($producto['ID_Producto']);  ?></td>
                            <td><?php echo htmlspecialchars($producto['Nombre_Producto']); ?></td>
                            <td><?php echo htmlspecialchars($producto['Precio_Producto']); ?></td>
                            <td><?php echo htmlspecialchars($producto['Descripcion_Producto']); ?></td>
                            <td><?php echo htmlspecialchars($producto['Tiene_Stock_Producto'] ? 'Sí' : 'No'); ?></td>
                            <td>
                                <img src="../../imgProductos/<?php echo $producto['Imagen_Producto']; ?>" width="50" alt="">
                            </td>
                            <td><?php echo htmlspecialchars($producto['Especificaciones_Producto']); ?></td>
                            <td><?php echo htmlspecialchars($categoria['Nombre_Categoria']); ?></td>
                            <td>
                                <form method="post">
                                    <input type="hidden" name="txtID" id="txtID" value="<?php echo htmlspecialchars($producto['ID_Producto']); ?>" />
                                    <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary mb-2" />
                                    <input type="submit" name="accion" value="Borrar" class="btn btn-danger" />
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <!-- Navegación de la paginación -->
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?php echo $paginaActual <= 1 ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?pagina=<?php echo $paginaActual - 1; ?>&txtCategoria=<?php echo $categoriaSeleccionada; ?>">Anterior</a>
                    </li>
                    <?php for ($i = 1; $i <= $totalPaginas; $i++) { ?>
                        <li class="page-item <?php echo $i == $paginaActual ? 'active' : ''; ?>">
                            <a class="page-link" href="?pagina=<?php echo $i; ?>&txtCategoria=<?php echo $categoriaSeleccionada; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php } ?>
                    <li class="page-item <?php echo $paginaActual >= $totalPaginas ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?pagina=<?php echo $paginaActual + 1; ?>&txtCategoria=<?php echo $categoriaSeleccionada; ?>">Siguiente</a>
                    </li>
                </ul>
            </nav>

        </div>

    </div>
</div>

<?php include('../template/pie.php') ?>