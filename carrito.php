<?php include("template/cabecera.php"); ?>

<br><br>

<?php

include("administrador/config/bd.php");

if (!isset($_SESSION['ID_Usuario'])) {
    echo "<script>window.location.href='loginUsuario.php';</script>";
}

// Obtener carrito del usuario
$sentenciaSQL = $conexion->prepare("SELECT * FROM Carritos INNER JOIN Usuarios ON Usuarios.ID_Usuario = Carritos.Usuarios_ID_Usuario WHERE Usuarios.ID_Usuario = :IdUsuario");
$sentenciaSQL->bindParam(":IdUsuario", $_SESSION['ID_Usuario']);
$sentenciaSQL->execute();
$carrito = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);

// Si el usuario tiene un carrito guardado
if (isset($carrito['ID_Carrito'])) {

    // Si se manda un producto desde productoDetalle.php
    if (isset($_POST['IdProducto']) && preg_match('/^[0-9]+$/', $_POST['IdProducto'])) {
        // Comprobar si ya tiene el producto seleccionado para aumentar su cantidad
        $sentenciaSQL = $conexion->prepare("SELECT Productos_ID_Producto, Cantidad_Productos FROM Carritos_Productos WHERE Carritos_ID_Carrito = :IdCarrito AND Productos_ID_Producto = :IdProducto");
        $sentenciaSQL->bindParam(":IdCarrito", $carrito['ID_Carrito']);
        $sentenciaSQL->bindParam(":IdProducto", $_POST['IdProducto']);
        $sentenciaSQL->execute();
        $productoExistente = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);

        if (isset($productoExistente['Productos_ID_Producto'])) {
            $cantidad = intval($productoExistente['Cantidad_Productos']) + intval($_POST['cantidadProducto']);
            $sentenciaSQL = $conexion->prepare("UPDATE Carritos_Productos SET Cantidad_Productos = :cantidad WHERE Carritos_ID_Carrito = :IdCarrito AND Productos_ID_Producto = :IdProducto");
            $sentenciaSQL->bindParam(":IdCarrito", $carrito['ID_Carrito']);
            $sentenciaSQL->bindParam(":IdProducto", $_POST['IdProducto']);
            $sentenciaSQL->bindParam(":cantidad", $cantidad);
            $sentenciaSQL->execute();
        } else {
            // Insertar el nuevo producto seleccionado en el carrito
            $sentenciaSQL = $conexion->prepare("INSERT INTO Carritos_Productos (Carritos_ID_Carrito, Productos_ID_Producto, Cantidad_Productos) VALUES (:IdCarrito, :IdProducto, :cantidad)");
            $sentenciaSQL->bindParam(":IdCarrito", $carrito['ID_Carrito']);
            $sentenciaSQL->bindParam(":IdProducto", $_POST['IdProducto']);
            $sentenciaSQL->bindParam(":cantidad", $_POST['cantidadProducto']);
            $sentenciaSQL->execute();
        }

        header("Location: carrito.php");

    }
} else {
    // Crear nuevo carrito si no existe
    $fecha = new DateTime();
    $fechaCarrito = date('Y-m-d H:i:s', $fecha->getTimestamp());

    $sentenciaSQL = $conexion->prepare("INSERT INTO Carritos (Fecha_Creacion_Carrito, Usuarios_ID_Usuario) VALUES (:fecha, :IdUsuario)");
    $sentenciaSQL->bindParam(":IdUsuario", $_SESSION['ID_Usuario']);
    $sentenciaSQL->bindParam(":fecha", $fechaCarrito);
    $sentenciaSQL->execute();

    // Obtener el ID del carrito recién creado
    $carrito['ID_Carrito'] = $conexion->lastInsertId();

    if (isset($_POST['IdProducto']) && preg_match('/^[0-9]+$/', $_POST['IdProducto'])) {
        // Insertar productos en el nuevo carrito
        $sentenciaSQL = $conexion->prepare("INSERT INTO Carritos_Productos (Carritos_ID_Carrito, Productos_ID_Producto, Cantidad_Productos) VALUES (:IdCarrito, :IdProducto, :cantidad)");
        $sentenciaSQL->bindParam(":IdCarrito", $carrito['ID_Carrito']);
        $sentenciaSQL->bindParam(":IdProducto", $_POST['IdProducto']);
        $sentenciaSQL->bindParam(":cantidad", $_POST['cantidadProducto']);
        $sentenciaSQL->execute();
    }
}

// Obtener lista de productos en el carrito
$sentenciaSQL = $conexion->prepare("SELECT Productos.*, Carritos_Productos.Cantidad_Productos FROM Carritos_Productos INNER JOIN Productos ON Carritos_Productos.Productos_ID_Producto = Productos.ID_Producto WHERE Carritos_Productos.Carritos_ID_Carrito = :IdCarrito");
$sentenciaSQL->bindParam(":IdCarrito", $carrito['ID_Carrito']);
$sentenciaSQL->execute();
$listaCarritosProductos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

$txtID = (isset($_GET['txtID']) && preg_match('/^[0-9]+$/', $_GET['txtID'])) ? $_GET['txtID'] : "";
$accion = (isset($_GET['accion']) && preg_match('/^[a-zA-Z ]+$/', $_GET['accion'])) ? $_GET['accion'] : "";

switch ($accion) {
    case 'Quitar del carrito':
        // Borrar producto del carrito
        $sentenciaSQL = $conexion->prepare("DELETE FROM Carritos_Productos WHERE Productos_ID_Producto = :idProducto AND Carritos_ID_Carrito = :idCarrito");
        $sentenciaSQL->bindParam(':idProducto', $txtID);
        $sentenciaSQL->bindParam(':idCarrito', $carrito['ID_Carrito']);
        $sentenciaSQL->execute();

        echo '<script type="text/javascript">
        window.location.href = "carrito.php";
        </script>';
        break;
    case 'Continuar con la compra':
        $_SESSION['ID_Carrito'] = $carrito['ID_Carrito'];
        
        echo "<script>window.location.href='simulacion.php';</script>";
        exit;
        break;
}

?>

<br>

<div class="container">
    <h3>Carrito de compras</h3>
    <div class="table-responsive"> <!-- Contenedor responsivo -->
        <table id="carrito-table" class="table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th id="precioCarrito">Precio Unitario</th>
                    <th id="cantidadCarrito">Cantidad</th>
                    <th id="quitarCarrito"></th>
                </tr>
            </thead>
            <tbody>
                <?php
            $_SESSION['total'] = 0;
            foreach ($listaCarritosProductos as $producto) {
                // Formatear precios y calcular el total
                $precioFormateado = number_format($producto['Precio_Producto'], 0, ',', '.');
                $totalProducto = $producto['Cantidad_Productos'] * $producto['Precio_Producto'];
                $_SESSION['total'] += $totalProducto;
                $totalProductoFormateado = number_format($totalProducto, 0, ',', '.');
            ?>
                <tr>
                    <td class="text-info">
                        <?php if ($producto['Imagen_Producto'] != 'imagen.jpg') { ?>
                            <img class="img-thumbnail rounded" style="margin-right: 2%;" src="imgProductos/<?php echo htmlspecialchars($producto['Imagen_Producto']); ?>" width="50" alt="Imagen del producto">
                        <?php } ?>
                        <?php echo htmlspecialchars($producto['Nombre_Producto']); ?>
                    </td>
                    <td class="text-success precioCarrito">$ <?php echo htmlspecialchars($precioFormateado); ?></td>
                    <td><?php echo htmlspecialchars($producto['Cantidad_Productos']); ?></td>
                    <td>
                        <form method="GET">
                            <input type="hidden" name="txtID" id="txtID" value="<?php echo htmlspecialchars($producto['ID_Producto']); ?>">
                            <input type="submit"  name="accion" value="Quitar del carrito" class="btn btn-danger btnQuitarCarrito">
                        </form>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <h4>Total: $<span id="total"> <?php echo htmlspecialchars(number_format($_SESSION['total'], 0, ',', '.'));  ?> </span></h4>
    
    <?php if (isset($carrito['ID_Carrito']) && count($listaCarritosProductos) > 0) { ?>
    <form method="GET">
        <input type="submit" name="accion" value="Continuar con la compra" class="btn btn-success continuarCompra">
    </form>
<?php } ?>
</div>

<br>

<?php include("template/pie.php"); ?>