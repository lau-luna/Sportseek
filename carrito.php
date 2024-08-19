<?php include("template/cabecera.php"); ?>

<br><br>

<?php

include("administrador/config/bd.php");

// Obtener carrito del usuario
$sentenciaSQL = $conexion->prepare("SELECT * FROM Carritos INNER JOIN Usuarios ON Usuarios.ID_Usuario=Carritos.Usuarios_ID_Usuario WHERE Usuarios.ID_Usuario=:IdUsuario");
$sentenciaSQL->bindParam(":IdUsuario", $_SESSION['ID_Usuario']);
$sentenciaSQL->execute();
$carrito = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);

// Si el usuario tiene un carrito guardado
if (isset($carrito['ID_Carrito'])) {

    // Si se manda un producto desde productoDetalle.php
    if (isset($_POST['IdProducto'])) {
        //Comprobar si ya tiene el producto seleccionado para aumentar su cantidad
        $sentenciaSQL = $conexion->prepare("SELECT Productos_ID_Producto, Cantidad_Productos FROM Carritos_Productos WHERE Carritos_ID_Carrito=:IdCarrito AND Productos_ID_Producto=:IdProducto");
        $sentenciaSQL->bindParam(":IdCarrito", $carrito['ID_Carrito']);
        $sentenciaSQL->bindParam(":IdProducto", $_POST['IdProducto']);
        $sentenciaSQL->execute();
        $IdProducto = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);

        if (isset($IdProducto['Productos_ID_Producto'])) {
            $cantidad = intval($IdProducto['Cantidad_Productos']) + intval($_POST['cantidadProducto']);
            $sentenciaSQL = $conexion->prepare("UPDATE Carritos_Productos SET Cantidad_Productos=:cantidad WHERE Carritos_ID_Carrito=:IdCarrito AND Productos_ID_Producto=:IdProducto");
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

    if (isset($_POST['IdProducto'])) {
        // Insertar productos en el nuevo carrito
        $sentenciaSQL = $conexion->prepare("INSERT INTO Carritos_Productos (Carritos_ID_Carrito, Productos_ID_Producto, Cantidad_Productos) VALUES (:IdCarrito, :IdProducto, :cantidad)");
        $sentenciaSQL->bindParam(":IdCarrito", $carrito['ID_Carrito']);
        $sentenciaSQL->bindParam(":IdProducto", $_POST['IdProducto']);
        $sentenciaSQL->bindParam(":cantidad", $_POST['cantidadProducto']);
        $sentenciaSQL->execute();
    }
}

// Obtener lista de productos en el carrito
$sentenciaSQL = $conexion->prepare("SELECT Productos.*, Carritos_Productos.Cantidad_Productos FROM Carritos_Productos INNER JOIN Productos ON Carritos_Productos.Productos_ID_Producto=Productos.ID_Producto WHERE Carritos_Productos.Carritos_ID_Carrito=:IdCarrito");
$sentenciaSQL->bindParam(":IdCarrito", $carrito['ID_Carrito']);
$sentenciaSQL->execute();
$listaCarritosProductos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

$txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : "";
$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";

switch ($accion) {
    case 'Quitar del carrito':
        // Borrar producto del carrito
        $sentenciaSQL = $conexion->prepare("DELETE FROM Carritos_Productos WHERE Productos_ID_Producto=:idProducto AND Carritos_ID_Carrito=:idCarrito");
        $sentenciaSQL->bindParam(':idProducto', $txtID);
        $sentenciaSQL->bindParam(':idCarrito', $carrito['ID_Carrito']);
        $sentenciaSQL->execute();

        break;
    case 'Continuar con la compra':
        // Crear Pedido
        

        // Crear Factura

        $sentenciaSQL = $conexion->prepare("SELECT * FROM Carritos_Productos WHERE Carritos_ID_Carrito=:IdCarrito AND Productos_ID_Producto=:IdProducto");
        $sentenciaSQL->bindParam(":IdCarrito", $carrito['ID_Carrito']);
        $sentenciaSQL->bindParam(":IdProducto", $_POST['IdProducto']);
        $sentenciaSQL->execute();
        $listaCarritosProductos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

        foreach ($listaCarritosProductos as $carrritoProducto) {
            $sentenciaSQL = $conexion->prepare("INSERT INTO Facturas_Productos (Pedidos_ID_Pedido)");
        }
        
        break;
}

?>

<div class="container">
    <h3>Carrito de compras</h3>

    <table id="carrito-table" class="table">
        <thead>
            <tr>
                <th>Producto</th>
                <th style="width: 20%;">Precio Unitario</th>
                <th style="width: 10%;">Cantidad</th>
                <th style="width: 25%;"></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total = 0;
            foreach ($listaCarritosProductos as $producto) {
                $total = $total + ((floatval($producto['Precio_Producto'])) * (floatval($producto['Cantidad_Productos'])));

            ?>
                <tr>
                    <td class="text-info">
                        <?php if ($producto['Imagen_Producto'] != 'imagen.jpg') { ?>
                            <img class="img-thumbnail rounded" style="margin-right: 2%;" src="imgProductos/<?php echo htmlspecialchars($producto['Imagen_Producto']); ?>" width="50">
                        <?php } ?>
                        <?php echo htmlspecialchars($producto['Nombre_Producto']); ?>
                    </td>
                    <td class="text-success">$ <?php echo htmlspecialchars($producto['Precio_Producto']); ?></td>
                    <td><?php echo htmlspecialchars($producto['Cantidad_Productos']); ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="txtID" id="txtID" value="<?php echo $producto['ID_Producto']; ?>">
                            <input type="submit" name="accion" value="Quitar del carrito" class="btn btn-danger">
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <h4>Total: $<span id="total"> <?php echo htmlspecialchars($total); ?> </span></h4>

    <?php if (isset($carrito['ID_Carrito'])) { ?>
        <form method="POST">
            <input type="submit" name="accion" value="Continuar con la compra" class="btn btn-success">
        </form>
    <?php } ?>

</div>

<?php include("template/pie.php"); ?>