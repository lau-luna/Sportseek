<?php include('../template/cabecera.php') ?>

<?php
//Recibir los datos del formulario y guardarlo en variables. Si no hay datos se guardan vacías
$txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : "";
$txtNombre = (isset($_POST['txtNombre'])) ? $_POST['txtNombre'] : "";
$numPrecio = (isset($_POST['numPrecio'])) ? $_POST['numPrecio'] : "";
$boolStock = (isset($_POST['boolStock'])) ? 1 : 0;
$txtDescripcion = (isset($_POST['txtDescripcion'])) ? $_POST['txtDescripcion'] : "";
$txtImagen = (isset($_FILES['txtImagen']['name'])) ? $_FILES['txtImagen']['name'] : "";
$txtEspecificaciones = (isset($_POST['txtEspecificaciones'])) ? $_POST['txtEspecificaciones'] : "";
$txtCategoria = (isset($_POST['txtCategoria'])) ? $_POST['txtCategoria'] : "";
$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";

include("../config/bd.php");

switch ($accion) {
    case "Agregar":
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
        break;
    case "Modificar":
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

<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            Datos del producto
        </div>
        <div class="card-body">

            <form method="POST" enctype="multipart/form-data">
                <section style="display: flex;">
                    <div style="width: 48%; margin-right:4%;">
                        <div class="form-group">
                            <label for="txtID">ID:</label>
                            <input type="text" required readonly value="<?php echo $txtID; ?>" class="form-control" name="txtID" id="txtID" placeholder="ID">
                        </div>

                        <div class="form-group">
                            <label for="txtNombre">Nombre:</label>
                            <input type="text" required value="<?php echo $txtNombre; ?>" class="form-control" name="txtNombre" id="txtNombre" placeholder="Nombre">
                        </div>

                        <div class="form-group">
                            <label for="numPrecio">Precio:</label>
                            <input type="number" required value="<?php if (isset($numPrecio)) {
                                                                        echo floatval($numPrecio);
                                                                    } ?>" class="form-control" name="numPrecio" id="numPrecio" placeholder="$">
                        </div>

                        <div class="form-group" id="div-descripcion">
                            <div class="form-group" id="div-descripcion">
                                <label for="txtDescripcion">Descripción:</label>
                                <textarea maxlength="5000" required class="form-control" name="txtDescripcion" id="txtDescripcion" placeholder="Describe el producto" rows="4" style="resize: none;"><?php echo $txtDescripcion; ?></textarea>
                            </div>
                        </div>

                        <div class="btn-group" role="group" aria-label="">
                            <button type="submit" name="accion" <?php echo ($accion == "Seleccionar") ? "disabled" : ""; ?> value="Agregar" class="btn btn-success">Agregar</button>
                            <button type="submit" name="accion" <?php echo ($accion != "Seleccionar") ? "disabled" : ""; ?> value="Modificar" class="btn btn-warning">Modificar</button>
                            <button type="submit" name="accion" <?php echo ($accion != "Seleccionar") ? "disabled" : ""; ?> value="Cancelar" class="btn btn-info">Cancelar</button>
                        </div>

                    </div>


                    <div style="width: 50%;">
                        <div class="form-group">
                            <label for="boolStock">Tiene stock:</label>
                            <input type="checkbox" value="true" <?php if ($boolStock == 1) {
                                                                    echo 'checked';
                                                                } ?> class="form-control" name="boolStock" id="boolStock">
                        </div>

                        <div class="form-group">
                            <label for="txtImagen">Imagen:</label>

                            <?php if ($txtImagen != "") {
                                echo $producto['Imagen_Producto'];
                            } ?>

                            <input type="file" class="form-control" name="txtImagen" id="txtImagen" placeholder="Imagen">
                        </div>

                        <div data-mdb-input-init class="categoria mb-3">
                            <label class="form-label">Categoría</label>
                            <select name="txtCategoria" id="provincia" class="form-control" required>
                                <?php
                                $sentenciaSQL = $conexion->prepare("SELECT * FROM Categorias");
                                $sentenciaSQL->execute();
                                $listaCategorias = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($listaCategorias as $categoria) {
                                ?>
                                    <option <?php if(isset($txtCategoria) && $txtCategoria==$categoria['ID_Categoria']) { echo 'selected'; } ?> value="<?php echo $categoria['ID_Categoria'] ?>"><?php echo $categoria['Nombre_Categoria'] ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group" id="div-especificaciones">
                            <label for="txtEspecificaciones">Especificaciones:</label>
                            <textarea maxlength="5000" class="form-control" name="txtEspecificaciones" id="txtEspecificaciones" placeholder="Escribe las especificaciones del producto (opcional)" rows="4" style="resize: none;"><?php echo $txtEspecificaciones; ?></textarea>
                        </div>

                </section>

        </div>

        </form>

    </div>
</div>


</div>

<br> <br>

<hr>



<form method="POST" action="">
    <div data-mdb-input-init class="categoria col-md-3 mb-3">
        <label class="form-label">Filtrar por Categoría:</label>
        <select name="txtCategoria" id="categoria" class="form-control" onchange="this.form.submit()">
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



<div class="col-md-12">
    <table class="table table-bordered" id="tabla-productos">
        <thead>
            <tr style="font-size: small;">
                <th style="width: 3%;" id="th-ID">ID</th>
                <th style="width: 15%;" id="th-nombre">Nombre</th>
                <th style="width: 8%;" id="th-precio">Precio</th>
                <th style="width: 6%;" id="th-imagen">Imagen</th>
                <th style="width: 18%;" id="th-descripcion">Descripción</th>
                <th style="width: 7%;" id="th-stock">Stock</th>
                <th id="th-especificiaciones">Especificaciones</th>
                <th id="th-categoria">Categoria</th>
                <th style="width: 7%;" id="th-acciones">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($listaProductos as $producto) { ?>
                <tr>
                    <td><?php echo $producto['ID_Producto']; ?></td>
                    <td><?php echo $producto['Nombre_Producto']; ?></td>
                    <td><?php echo $producto['Precio_Producto']; ?></td>
                    <td id="td-imagen">
                        <?php if ($producto['Imagen_Producto'] != 'imagen.jpg') { ?>
                            <img class="img-thumbnail rounded" src="../../imgProductos/<?php echo $producto['Imagen_Producto']; ?>" width="50">
                        <?php } ?>
                    </td>
                    <td><?php echo $producto['Descripcion_Producto']; ?></td>
                    <td><?php if ($producto['Tiene_Stock_Producto'] == 1) {
                            echo "Tiene";
                        } else {
                            echo "No tiene";
                        } ?></td>
                    <td><?php echo $producto['Especificaciones_Producto']; ?></td>
                    <td><?php
                        $sentenciaSQL = $conexion->prepare("SELECT Categorias.Nombre_Categoria FROM Productos INNER JOIN Categorias ON Categorias.ID_Categoria=:IdCategoria WHERE Productos.ID_Producto=:IdProducto");
                        $sentenciaSQL->bindParam(":IdCategoria", $producto['Categorias_ID_Categoria']);
                        $sentenciaSQL->bindParam(":IdProducto", $producto['ID_Producto']);
                        $sentenciaSQL->execute();

                        $categoria = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

                        echo $categoria['Nombre_Categoria']; ?></td>

                    <td>
                        <form method="POST">
                            <input type="hidden" name="txtID" id="txtID" value="<?php echo $producto['ID_Producto']; ?>">

                            <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary">

                            <input type="submit" name="accion" value="Borrar" class="btn btn-danger">

                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php include('../template/pie.php') ?>