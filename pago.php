<?php include("template/cabecera.php"); ?>

<!--Conexión a base de datos -->
<?php include("administrador/config/bd.php"); ?>


<?php

// Obtener lista de productos en el carrito
$sentenciaSQL = $conexion->prepare("SELECT * FROM Carritos_Productos INNER JOIN Productos ON Carritos_Productos.Productos_ID_Producto=Productos.ID_Producto WHERE Carritos_Productos.Carritos_ID_Carrito=:IdCarrito");
$sentenciaSQL->bindParam(":IdCarrito", $_SESSION['ID_Carrito']);
$sentenciaSQL->execute();
$listaCarritosProductos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);


if ($_GET) {

    // Obtener datos del cliente
    $sentenciaSQL = $conexion->prepare("SELECT * FROM Usuarios INNER JOIN Localidades ON Usuarios.Localidades_ID_Localidades=Localidades.ID_Localidades INNER JOIN Provincias ON Localidades.Provincias_ID_Provincia=Provincias.ID_Provincia WHERE Usuarios.ID_Usuario=:IdUsuario");
    $sentenciaSQL->bindParam(":IdUsuario", $_SESSION['ID_Usuario']);
    $sentenciaSQL->execute();
    $datosCliente = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);

    // Crear Pedido con datos del cliente
    // Crear Pedido
    $fecha = new DateTime();
    $fechaPedido = date('Y-m-d H:i:s', $fecha->getTimestamp());

    $sentenciaSQL = $conexion->prepare("INSERT INTO Pedidos (ID_Usuario, Usuarios_ID_Usuario, Estados_Pedidos_ID_Estado_Pedido, Fecha_Pedido, Nombre_Usuario, Apellidos_Usuario, DNI_Usuario, Email_Usuario, Direccion_Usuario, Telefono_Usuario, Localidad_Usuario, Provincia_Usuario) VALUES (:IdUsuario, :IdUsuario, 1, :fecha, :nombreUsuario, :apellidosUsuario, :dniUsuario, :emailUsuario, :direccionUsuario, :telefonoUsuario, :localidadUsuario, :provinciaUsuario)");
    $sentenciaSQL->bindParam(":IdUsuario", $datosCliente['ID_Usuario']);
    $sentenciaSQL->bindParam(":fecha", $fechaPedido);
    $sentenciaSQL->bindParam(":nombreUsuario", $datosCliente['Nombre_Usuario']);
    $sentenciaSQL->bindParam(":apellidosUsuario", $datosCliente['Apellidos_Usuario']);
    $sentenciaSQL->bindParam(":dniUsuario", $datosCliente['DNI_Usuario']);
    $sentenciaSQL->bindParam(":emailUsuario", $datosCliente['Email_Usuario']);
    $sentenciaSQL->bindParam(":direccionUsuario", $datosCliente['Direccion_Usuario']);
    $sentenciaSQL->bindParam(":telefonoUsuario", $datosCliente['Telefono_Usuario']);
    $sentenciaSQL->bindParam(":localidadUsuario", $datosCliente['Nombre_Localidad']);
    $sentenciaSQL->bindParam(":provinciaUsuario", $datosCliente['Nombre_Provincia']);
    $sentenciaSQL->execute();

    $IdNuevoPedido = $conexion->lastInsertId();


    // Crear Factura con datos del cliente
    // Crear Factura
    $sentenciaSQL = $conexion->prepare("SELECT Metodo_Pago FROM Metodos_Pago WHERE ID_Metodo_Pago=:IdMetodoPago");
    $sentenciaSQL->bindParam(":IdMetodoPago", $_GET['metodoPago']);
    $sentenciaSQL->execute();
    $metodoPago = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);

    $fechaFactura = date('Y-m-d H:i:s', $fecha->getTimestamp());
    $sentenciaSQL = $conexion->prepare("INSERT INTO Facturas (Fecha_Emision_Factura, Total_Factura, IVA_Factura, Estados_Facturas_ID_Estados_Factura, Usuarios_ID_Usuario, Metodos_Pago_ID_Metodo_Pago, ID_Pedido, ID_Usuario, Nombre_Usuario, Apellidos_Usuario, DNI_Usuario, Email_Usuario, Direccion_Usuario, Telefono_Usuario, Localidad_Usuario, Provincia_Usuario, Metodo_Pago) VALUES (:fecha, :total, :iva, 1, :IdUsuario, :IdMetodoPago, :IdPedido, :IdUsuario, :nombreUsuario, :apellidosUsuario, :dniUsuario, :emailUsuario, :direccionUsuario, :telefonoUsuario, :localidadUsuario, :provinciaUsuario, :metodoPago)");
    $sentenciaSQL->bindParam(":fecha", $fechaFactura);
    $sentenciaSQL->bindParam(":total", $_SESSION['totalConIVA']);
    $sentenciaSQL->bindParam(":iva", $_SESSION['valorIVA']);
    $sentenciaSQL->bindParam(":IdUsuario", $datosCliente['ID_Usuario']);
    $sentenciaSQL->bindParam(":IdMetodoPago", $_GET['metodoPago']);
    $sentenciaSQL->bindParam(":IdPedido", $IdNuevoPedido);
    $sentenciaSQL->bindParam(":nombreUsuario", $datosCliente['Nombre_Usuario']);
    $sentenciaSQL->bindParam(":apellidosUsuario", $datosCliente['Apellidos_Usuario']);
    $sentenciaSQL->bindParam(":dniUsuario", $datosCliente['DNI_Usuario']);
    $sentenciaSQL->bindParam(":emailUsuario", $datosCliente['Email_Usuario']);
    $sentenciaSQL->bindParam(":direccionUsuario", $datosCliente['Direccion_Usuario']);
    $sentenciaSQL->bindParam(":telefonoUsuario", $datosCliente['Telefono_Usuario']);
    $sentenciaSQL->bindParam(":localidadUsuario", $datosCliente['Nombre_Localidad']);
    $sentenciaSQL->bindParam(":provinciaUsuario", $datosCliente['Nombre_Provincia']);
    $sentenciaSQL->bindParam(":metodoPago", $metodoPago['Metodo_Pago']);


    $sentenciaSQL->execute();


    $IdNuevaFactura = $conexion->lastInsertId();



    // Transferir productos del carrito al Pedido y a las Facturas
    foreach ($listaCarritosProductos as $carritoProducto) {
        $sentenciaSQL = $conexion->prepare("INSERT INTO Facturas_Pedidos_Productos (Facturas_ID_Factura, Pedidos_ID_Pedido, Productos_ID_Productos, ID_Producto, Cantidad_Productos, Precio_Producto, Nombre_Producto) VALUES (:IdFactura, :IdPedido, :IdProducto, :IdProducto, :cantidad, :precioProducto, :nombreProducto)");
        $sentenciaSQL->bindParam(":IdFactura", $IdNuevaFactura);
        $sentenciaSQL->bindParam(":IdPedido", $IdNuevoPedido);
        $sentenciaSQL->bindParam(":IdProducto", $carritoProducto['ID_Producto']);
        $sentenciaSQL->bindParam(":cantidad", $carritoProducto['Cantidad_Productos']);
        $sentenciaSQL->bindParam(":precioProducto", $carritoProducto['Precio_Producto']);
        $sentenciaSQL->bindParam(":nombreProducto", $carritoProducto['Nombre_Producto']);
        $sentenciaSQL->execute();
    }


    // Eliminar este carrito
    $sentenciaSQL = $conexion->prepare("DELETE FROM Carritos WHERE ID_Carrito=:IdCarrito");
    $sentenciaSQL->bindParam(":IdCarrito", $_SESSION['ID_Carrito']);
    $sentenciaSQL->execute();

    $_SESSION['ID_Pedido'] = $IdNuevoPedido;

    echo "<script>window.location.href='pedido.php';</script>";
}

?>

<div class="container">
    <div class="text-center">
        <h2>Método de pago</h2>
    </div>
    <form method="GET">
        <div class="row">
            <div class="col-md-4 order-md-2 mb-4">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Resumen de compra</span>
                </h4>
                <ul class="list-group mb-3">
                    <?php foreach ($listaCarritosProductos as $producto) { ?>

                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div>
                                <h6 class="my-0"><?php echo htmlspecialchars($producto['Nombre_Producto']); ?></h6>
                            </div>
                            <span class="text-muted">$ <?php echo htmlspecialchars($producto['Precio_Producto']); ?></span>
                        </li>
                    <?php } ?>
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                            <h6 class="my-0">IVA 21%</h6>
                        </div>

                        <?php
                        $_SESSION['valorIVA'] = (floatval($_SESSION['total']) * 21) / 100;
                        $_SESSION['totalConIVA'] = floatval($_SESSION['total']) + floatval($_SESSION['valorIVA']);

                        ?>
                        <span class="text-muted">$ <?php echo htmlspecialchars($_SESSION['valorIVA']); ?></span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between">
                        <span>Total</span>
                        <strong>$ <?php echo htmlspecialchars($_SESSION['totalConIVA']); ?></strong>
                    </li>
                </ul>
                <hr class="mb-4">
                <button class="btn btn-primary btn-lg btn-block" type="submit">Continuar</button>
            </div>
            <div class="col-md-8 order-md-1">
                <h4 class="mb-3">Elegí cómo pagar</h4>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="metodoPago" id="paymentMethod1" value="1">
                    <label class="form-check-label" for="paymentMethod1">
                        Tarjeta
                    </label>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="metodoPago" id="paymentMethod2" value="2">
                    <label class="form-check-label" for="paymentMethod2">
                        Transferencia Bancaria
                    </label>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="metodoPago" id="paymentMethod5" value="3">
                    <label class="form-check-label" for="paymentMethod5">
                        Efectivo en puntos de pago
                    </label>
                </div>

            </div>
        </div>
    </form>
</div>

<?php include("template/pie.php"); ?>