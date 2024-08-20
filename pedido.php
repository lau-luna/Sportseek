<?php include("template/cabecera.php"); ?>

<!--Conexión a base de datos -->
<?php include("administrador/config/bd.php"); ?>

<?php
if (isset($_GET['ID_Pedido'])) {
    $IdPedido = $_GET['ID_Pedido'];
} else {
    $IdPedido = intval($_SESSION['ID_Pedido']);
}

$sentenciaSQL = $conexion->prepare("SELECT * FROM Pedidos INNER JOIN Facturas_Pedidos_Productos ON Pedidos.ID_Pedido=Facturas_Pedidos_Productos.Pedidos_ID_Pedido WHERE ID_Pedido=:IdPedido");
$sentenciaSQL->bindParam(":IdPedido", $IdPedido);
$sentenciaSQL->execute();
$pedido = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="./css/factura.css" rel="stylesheet">

<div class="container mt-2">
    <div class="div-botones-imprimir-descargar mb-2 d-flex justify-content-end">
        <button class="btn btn-outline-primary mr-2 col-md-2" id="boton-imprimir" onclick="imprimirPedido()">
            <img style="width: 10%;" src="./img/impresora.png" alt="">
            Imprimir Pedido</button>
        <button class="btn btn-outline-danger col-md-2" id="boton-descargar" onclick="descargarPDF()">
            <img style="width: 10%;" src="./img/pdf.png" alt="">
            Descargar como PDF</button>
    </div>


    <div class="invoice-box" id="pedido">
        <div class="row">
            <div class="col-md-6">
                <img src="./img/LogoTiendaHeader.png" alt="Logo de la empresa" class="logo">
                <p>
                    Independencia 590<br>
                    Laboulaye, Córdoba.
                </p>
            </div>
            <div class="col-md-6 text-md-end">
                <p>
                    N° Pedido: <?php echo htmlspecialchars($pedido['ID_Pedido']) ?> <br>
                    Fecha: <?php echo htmlspecialchars($pedido['Fecha_Pedido']) ?><br>
                </p>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <h5>Información del solicitante:</h5>

                <?php
                $sentenciaSQL = $conexion->prepare("SELECT * FROM Pedidos INNER JOIN Usuarios ON Pedidos.Usuarios_ID_Usuario=Usuarios.ID_Usuario WHERE ID_Pedido=:IdPedido");
                $sentenciaSQL->bindParam(":IdPedido", $IdPedido);
                $sentenciaSQL->execute();
                $usuarioPedido = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);

                $sentenciaSQL = $conexion->prepare("SELECT Provincias.Nombre_Provincia, Localidades.Nombre_Localidad FROM (Provincias INNER JOIN Localidades ON Localidades.Provincias_ID_Provincia=Provincias.ID_Provincia) INNER JOIN Usuarios ON Localidades.ID_Localidades=Usuarios.Localidades_ID_Localidades WHERE Usuarios.ID_Usuario=:IdUsuario");
                $sentenciaSQL->bindParam(":IdUsuario", $usuarioPedido['ID_Usuario']);
                $sentenciaSQL->execute();
                $provinciaLocalidad = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
                ?>
                <p>
                    <?php echo htmlspecialchars("ID cliente: " . $usuarioPedido['ID_Usuario']) ?> <br>
                    <?php echo htmlspecialchars("Nombre o razón social: " . $usuarioPedido['Apellidos_Usuario'] . ", " . $usuarioPedido['Nombre_Usuario']) ?> <br>
                    <?php echo htmlspecialchars("Dirección: " . $usuarioPedido['Direccion_Usuario']) ?> <br>
                    <?php echo htmlspecialchars("Telefono: " . $usuarioPedido['Telefono_Usuario']) ?> <br>
                    <?php echo htmlspecialchars("Email: " . $usuarioPedido['Email_Usuario']) ?> <br>
                    <?php echo htmlspecialchars("Localidad: " . $provinciaLocalidad['Nombre_Localidad']) ?> <br>
                    <?php echo htmlspecialchars("Provincia: " . $provinciaLocalidad['Nombre_Provincia']) ?> <br>
                </p>
            </div>
            <div class="col-md-6 text-md-end">
                <h5>Estado del pedido:</h5>
                <?php
                $sentenciaSQL = $conexion->prepare("SELECT Estado_Pedido FROM Pedidos INNER JOIN Estados_Pedidos ON Pedidos.Estados_Pedidos_ID_Estado_Pedido=Estados_Pedidos.ID_Estado_Pedido WHERE ID_Pedido=:IdPedido");
                $sentenciaSQL->bindParam(":IdPedido", $IdPedido);
                $sentenciaSQL->execute();
                $estadoPedido = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
                ?>
                <p><?php echo htmlspecialchars($estadoPedido['Estado_Pedido']) ?> <br></p>
            </div>
        </div>

        <table class="table table-bordered mt-4">
            <thead class="table-light table-bordered">
                <tr>
                    <th style="width: 65%;">Producto</th>
                    <th class="text-end" style="width: 20%;">Cantidad</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sentenciaSQL = $conexion->prepare("SELECT Productos.Nombre_Producto, Productos.Precio_Producto, Facturas_Pedidos_Productos.Cantidad_Productos FROM Facturas_Pedidos_Productos INNER JOIN Productos ON Productos.ID_Producto=Facturas_Pedidos_Productos.Productos_ID_Productos WHERE Facturas_Pedidos_Productos.Pedidos_ID_Pedido=:IdPedido");
                $sentenciaSQL->bindParam(":IdPedido", $IdPedido);
                $sentenciaSQL->execute();
                $listaProductosCantidades = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

                $_SESSION['Total_Pedido'] = 0;
                foreach ($listaProductosCantidades as $productoCantidad) {

                    $_SESSION['Total_Pedido'] = $_SESSION['Total_Pedido'] + (floatval($productoCantidad['Precio_Producto']) * intval($productoCantidad['Cantidad_Productos']));
                ?>
                    <tr>
                        <td> <?php echo htmlspecialchars($productoCantidad['Nombre_Producto']) ?> </td>
                        <td class="text-end"> <?php echo htmlspecialchars($productoCantidad['Cantidad_Productos']) ?> </td>
                    </tr>

                <?php } ?>
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td>Total</td>
                    <?php
                    $valorIVA = (floatval($_SESSION['Total_Pedido']) * 21) / 100;
                    $_SESSION['totalConIVA'] = floatval($_SESSION['Total_Pedido']) + floatval($valorIVA);
                    ?>
                    <td class="text-end">$ <?php echo htmlspecialchars($_SESSION['totalConIVA']) ?> </td>
                </tr>
            </tfoot>
        </table>

        <div class="card-footer text-muted">
            <p class="text-center text-body-secondary">© 2024 Sportseek S.A.S.</p>
        </div>

    </div>
</div>

<script src="./js/imprimirDescargarPedido.js"></script>

<?php include("template/pie.php"); ?>