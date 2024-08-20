<?php include("template/cabecera.php"); ?>

<!--Conexión a base de datos -->
<?php include("administrador/config/bd.php"); ?>


<?php

// Obtener lista de productos en el carrito
$sentenciaSQL = $conexion->prepare("SELECT Productos.*, Carritos_Productos.Cantidad_Productos FROM Carritos_Productos INNER JOIN Productos ON Carritos_Productos.Productos_ID_Producto=Productos.ID_Producto WHERE Carritos_Productos.Carritos_ID_Carrito=:IdCarrito");
$sentenciaSQL->bindParam(":IdCarrito", $_SESSION['ID_Carrito']);
$sentenciaSQL->execute();
$listaCarritosProductos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

if ($_GET) {
    // Crear Pedido
    $fecha = new DateTime();
    $fechaPedido = date('Y-m-d H:i:s', $fecha->getTimestamp());

    $sentenciaSQL = $conexion->prepare("INSERT INTO Pedidos (Usuarios_ID_Usuario, Estados_Pedidos_ID_Estado_Pedido, Fecha_Pedido) VALUES (:IdUsuario, 1 ,:fecha)");
    $sentenciaSQL->bindParam(":IdUsuario", $_SESSION['ID_Usuario']);
    $sentenciaSQL->bindParam(":fecha", $fechaPedido);
    $sentenciaSQL->execute();

    // Obtener el ID del pedido recién creado
    $IdNuevoPedido = $conexion->lastInsertId();

    // Crear Factura
    $fechaFactura = date('Y-m-d H:i:s', $fecha->getTimestamp());


    $sentenciaSQL = $conexion->prepare("INSERT INTO Facturas (Fecha_Emision_Factura, Total_Factura, Estados_Facturas_ID_Estados_Factura, Usuarios_ID_Usuario, Metodos_Pago_ID_Metodo_Pago) VALUES (:fecha, :total, 1, :IdUsuario, :metodoPago )");
    $sentenciaSQL->bindParam(":fecha", $fechaFactura);
    $sentenciaSQL->bindParam(":total", $_SESSION['totalConIVA']);
    $sentenciaSQL->bindParam(":IdUsuario", $_SESSION['ID_Usuario']);
    $sentenciaSQL->bindParam(":metodoPago", $_GET['metodoPago']);
    $sentenciaSQL->execute();

    // Obtener el ID de la factura recién creada
    $IdNuevaFactura = $conexion->lastInsertId();


    // Transferir productos del carrito al Pedido y a las Facturas
    foreach ($listaCarritosProductos as $carrritoProducto) {
        $sentenciaSQL = $conexion->prepare("INSERT INTO Facturas_Pedidos_Productos (Facturas_ID_Factura, Pedidos_ID_Pedido, Productos_ID_Productos, Cantidad_Productos) VALUES (:IdFactura, :IdPedido, :IdProducto, :cantidad)");
        $sentenciaSQL->bindParam(":IdFactura", $IdNuevaFactura);
        $sentenciaSQL->bindParam(":IdPedido", $IdNuevoPedido);
        $sentenciaSQL->bindParam(":IdProducto", $carrritoProducto['ID_Producto']);
        $sentenciaSQL->bindParam(":cantidad", $carrritoProducto['Cantidad_Productos']);
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
                        $valorIVA = (floatval($_SESSION['total']) * 21) / 100;
                        $_SESSION['totalConIVA'] = floatval($_SESSION['total']) + floatval($valorIVA);

                        ?>
                        <span class="text-muted">$ <?php echo htmlspecialchars($valorIVA); ?></span>
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

    <footer class="my-5 pt-5 text-muted text-center text-small">
        <p class="mb-1">&copy; </p>
    </footer>
</div>

<?php include("template/pie.php"); ?>