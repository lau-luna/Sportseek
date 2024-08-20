<?php include("template/cabecera.php"); ?>

<!--Conexión a base de datos -->
<?php include("administrador/config/bd.php"); ?>

<?php
if (isset($_GET['ID_Factura'])) {
    $IdFactura = $_GET['ID_Factura'];
} else {
    $IdFactura = intval($_SESSION['ID_Factura']);
}

$sentenciaSQL = $conexion->prepare("SELECT * FROM Facturas INNER JOIN Facturas_Pedidos_Productos ON Facturas.ID_Factura=Facturas_Pedidos_Productos.Facturas_ID_Factura WHERE ID_Factura=:IdFactura");
$sentenciaSQL->bindParam(":IdFactura", $IdFactura);
$sentenciaSQL->execute();
$factura = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="./css/factura.css" rel="stylesheet">

<div class="container mt-2">
<!-- Agregamos la clase d-flex y justify-content-end para alinear a la derecha -->
<div class="div-botones-imprimir-descargar mb-2 d-flex justify-content-end">
        <button class="btn btn-outline-primary mr-2 col-md-2" id="boton-imprimir" onclick="imprimirPedido()">
            <img style="width: 10%;" src="./img/impresora.png" alt="">
            Imprimir Factura</button>
        <button class="btn btn-outline-danger col-md-2" id="boton-descargar" onclick="descargarPDF()">
            <img style="width: 10%;" src="./img/pdf.png" alt="">
            Descargar como PDF</button>
    </div>


    <div class="invoice-box" id="factura">
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
                    N° Factura: <?php echo htmlspecialchars($factura['ID_Factura']) ?> <br>
                    Fecha de Emisión: <?php echo htmlspecialchars($factura['Fecha_Emision_Factura']) ?><br>
                </p>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <h5>Información del solicitante:</h5>

                <?php
                $sentenciaSQL = $conexion->prepare("SELECT * FROM Facturas INNER JOIN Usuarios ON Facturas.Usuarios_ID_Usuario=Usuarios.ID_Usuario WHERE ID_Factura=:IdFactura");
                $sentenciaSQL->bindParam(":IdFactura", $IdFactura);
                $sentenciaSQL->execute();
                $usuarioFactura = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);

                $sentenciaSQL = $conexion->prepare("SELECT Provincias.Nombre_Provincia, Localidades.Nombre_Localidad FROM (Provincias INNER JOIN Localidades ON Localidades.Provincias_ID_Provincia=Provincias.ID_Provincia) INNER JOIN Usuarios ON Localidades.ID_Localidades=Usuarios.Localidades_ID_Localidades WHERE Usuarios.ID_Usuario=:IdUsuario");
                $sentenciaSQL->bindParam(":IdUsuario", $usuarioFactura['ID_Usuario']);
                $sentenciaSQL->execute();
                $provinciaLocalidad = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
                ?>
                <p>
                    <?php echo htmlspecialchars("ID cliente: " . $usuarioFactura['ID_Usuario']) ?> <br>
                    <?php echo htmlspecialchars("Nombre o razón social: " . $usuarioFactura['Apellidos_Usuario'] . ", " . $usuarioFactura['Nombre_Usuario']) ?> <br>
                    <?php echo htmlspecialchars("Dirección: " . $usuarioFactura['Direccion_Usuario']) ?> <br>
                    <?php echo htmlspecialchars("Telefono: " . $usuarioFactura['Telefono_Usuario']) ?> <br>
                    <?php echo htmlspecialchars("Email: " . $usuarioFactura['Email_Usuario']) ?> <br>
                    <?php echo htmlspecialchars("Localidad: " . $provinciaLocalidad['Nombre_Localidad']) ?> <br>
                    <?php echo htmlspecialchars("Provincia: " . $provinciaLocalidad['Nombre_Provincia']) ?> <br>

                </p>
            </div>
            <div class="col-md-6 text-md-end">
                <h5>Método de Pago:</h5>
                <p>
                    <?php
                    $sentenciaSQL = $conexion->prepare("SELECT Metodos_Pago.Metodo_Pago FROM Facturas INNER JOIN Metodos_Pago ON Facturas.Metodos_Pago_ID_Metodo_Pago=Metodos_Pago.ID_Metodo_Pago WHERE Facturas.ID_Factura=:IdFactura");
                    $sentenciaSQL->bindParam(":IdFactura", $IdFactura);
                    $sentenciaSQL->execute();
                    $metodoPago = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

                    echo htmlspecialchars($metodoPago['Metodo_Pago']);
                    ?>
                </p>
            </div>
        </div>

        <table class="table table-bordered mt-4">
            <thead class="table-light table-bordered">
                <tr>
                    <th style="width: 65%;">Producto</th>
                    <th style="width: 10%;">Cantidad</th>
                    <th style="width: 25%;" class="text-end">Precio Unitario</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sentenciaSQL = $conexion->prepare("SELECT Productos.Nombre_Producto, Productos.Precio_Producto, Facturas_Pedidos_Productos.Cantidad_Productos FROM Facturas_Pedidos_Productos INNER JOIN Productos ON Productos.ID_Producto=Facturas_Pedidos_Productos.Productos_ID_Productos WHERE Facturas_Pedidos_Productos.Facturas_ID_Factura=:IdFactura");
                $sentenciaSQL->bindParam(":IdFactura", $IdFactura);
                $sentenciaSQL->execute();
                $listaProductosCantidades = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

                $_SESSION['Total_Factura'] = 0;
                foreach ($listaProductosCantidades as $productoCantidad) {

                    $_SESSION['Total_Factura'] = $_SESSION['Total_Factura'] + (floatval($productoCantidad['Precio_Producto']) * intval($productoCantidad['Cantidad_Productos']));
                ?>
                    <tr>
                        <td> <?php echo htmlspecialchars($productoCantidad['Nombre_Producto']) ?> </td>
                        <td> <?php echo htmlspecialchars($productoCantidad['Cantidad_Productos']) ?> </td>
                        <td class="text-end">$ <?php echo htmlspecialchars($productoCantidad['Precio_Producto']) ?></td>
                    </tr>

                <?php } ?>

            </tbody>
            <tfoot>
                <?php
                $valorIVA = (floatval($_SESSION['Total_Factura']) * 21) / 100;
                $_SESSION['totalConIVA'] = floatval($_SESSION['Total_Factura']) + floatval($valorIVA);
                ?>
                <tr class="IVA-row">
                    <td></td>
                    <td>IVA 21%:</td>
                    <td class="text-end">$ <?php echo htmlspecialchars($valorIVA) ?> </td>
                </tr>
                <tr class="total-row">
                    <td></td>
                    <td>Total:</td>
                    <td class="text-end">$ <?php echo htmlspecialchars($_SESSION['totalConIVA']) ?> </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<script src="./js/imprimirDescargarFactura.js"></script>


<?php include("template/pie.php"); ?>