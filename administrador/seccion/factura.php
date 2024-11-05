<?php include('../template/cabecera.php') ?>
<!--Conexión a base de datos -->
<?php include("../config/bd.php"); ?>

<?php
if (isset($_GET['ID_Factura']) && preg_match('/^[0-9]+$/', $_GET['ID_Factura'])) {
    $IdFactura = $_GET['ID_Factura'];
} else if (preg_match('/^[0-9]+$/', $_SESSION['ID_Factura'])) {
    $IdFactura = intval($_SESSION['ID_Factura']);
}

$sentenciaSQL = $conexion->prepare("SELECT * FROM Facturas WHERE ID_Factura=:IdFactura");
$sentenciaSQL->bindParam(":IdFactura", $IdFactura);
$sentenciaSQL->execute();
$factura = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="../../css/factura.css" rel="stylesheet">

<div class="container mt-2">
<!-- Agregamos la clase d-flex y justify-content-end para alinear a la derecha -->
<div class="div-botones-imprimir-descargar mb-2 d-flex justify-content-end">
        <button class="btn btn-outline-primary mr-2 col-md-2" id="boton-imprimir" onclick="imprimirPedido()">
            <img style="width: 10%;" src="../../img/impresora.png" alt="">
            Imprimir Factura</button>
        <button class="btn btn-outline-danger col-md-2" id="boton-descargar" onclick="descargarPDF()">
            <img style="width: 10%;" src="../../img/pdf.png" alt="">
            Descargar como PDF</button>
    </div>


    <div class="invoice-box" id="factura">
        <div class="row">
            <div class="col-md-6">
                <img src="../../img/LogoTiendaHeader.png" alt="Logo de la empresa" class="logo">
                <p>
                    Independencia 590<br>
                    Laboulaye, Córdoba.
                </p>
            </div>
            <div class="col-md-6 text-md-end">
                <p>
                    N° Factura: <?php echo htmlspecialchars($factura['ID_Factura']) ?> <br>
                    Fecha de Emisión: <?php echo htmlspecialchars($factura['Fecha_Emision_Factura']) ?><br>
                    ID Pedido vinculado: <?php echo htmlspecialchars($factura['ID_Pedido']) ?><br>
                </p>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <h5>Información del solicitante:</h5>

                <p>
                    <?php echo htmlspecialchars("ID cliente: " . $factura['ID_Usuario']) ?> <br>
                    <?php echo htmlspecialchars("Nombre o razón social: " . $factura['Apellidos_Usuario'] . ", " . $factura['Nombre_Usuario']) ?> <br>
                    <?php echo htmlspecialchars("Dirección: " . $factura['Direccion_Usuario']) ?> <br>
                    <?php echo htmlspecialchars("Telefono: " . $factura['Telefono_Usuario']) ?> <br>
                    <?php echo htmlspecialchars("Email: " . $factura['Email_Usuario']) ?> <br>
                    <?php echo htmlspecialchars("Localidad: " . $factura['Localidad_Usuario']) ?> <br>
                    <?php echo htmlspecialchars("Provincia: " . $factura['Provincia_Usuario']) ?> <br>

                </p>
            </div>
            <div class="col-md-6 text-md-end">
                <h5>Método de Pago:</h5>
                <p> <?php echo htmlspecialchars($factura['Metodo_Pago']);?></p>
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
                $sentenciaSQL = $conexion->prepare("SELECT * FROM Facturas_Pedidos_Productos WHERE Facturas_Pedidos_Productos.Facturas_ID_Factura=:IdFactura");
                $sentenciaSQL->bindParam(":IdFactura", $IdFactura);
                $sentenciaSQL->execute();
                $listaProductosCantidades = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

                foreach ($listaProductosCantidades as $productoCantidad) {
                ?>
                    <tr>
                        <td> <?php echo htmlspecialchars($productoCantidad['Nombre_Producto']) ?> </td>
                        <td> <?php echo htmlspecialchars($productoCantidad['Cantidad_Productos']) ?> </td>
                        <td class="text-end">$ <?php echo htmlspecialchars($productoCantidad['Precio_Producto']) ?></td>
                    </tr>

                <?php } ?>

            </tbody>
            <tfoot>
                
                <tr class="IVA-row">
                    <td></td>
                    <td>IVA 21%:</td>
                    <td class="text-end">$ <?php echo htmlspecialchars($factura['IVA_Factura']) ?> </td>
                </tr>
                <tr class="total-row">
                    <td></td>
                    <td>Total:</td>
                    <td class="text-end">$ <?php echo htmlspecialchars($factura['Total_Factura']) ?> </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<script src="../../js/imprimirDescargarFactura.js"></script>


<?php include('../template/pie.php') ?>