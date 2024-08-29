<?php include("template/cabecera.php"); ?>

<!--Conexión a base de datos -->
<?php include("administrador/config/bd.php"); ?>

<?php
if (isset($_GET['ID_Pedido']) && preg_match('/^[0-9]+$/', $_GET['ID_Pedido'])) {
    $IdPedido = $_GET['ID_Pedido'];
} else if (preg_match('/^[0-9]+$/', $_SESSION['ID_Pedido'])) {
    $IdPedido = intval($_SESSION['ID_Pedido']);
}

$sentenciaSQL = $conexion->prepare("SELECT * FROM Pedidos WHERE ID_Pedido=:IdPedido");
$sentenciaSQL->bindParam(":IdPedido", $IdPedido);
$sentenciaSQL->execute();
$pedido = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="./css/factura.css" rel="stylesheet">

<br>

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

                <p>
                    <?php echo htmlspecialchars("Nombre o razón social: " . $pedido['Apellidos_Usuario'] . ", " . $pedido['Nombre_Usuario']) ?> <br>
                    <?php echo htmlspecialchars("Dirección: " . $pedido['Direccion_Usuario']) ?> <br>
                    <?php echo htmlspecialchars("Telefono: " . $pedido['Telefono_Usuario']) ?> <br>
                    <?php echo htmlspecialchars("Email: " . $pedido['Email_Usuario']) ?> <br>
                    <?php echo htmlspecialchars("Localidad: " . $pedido['Localidad_Usuario']) ?> <br>
                    <?php echo htmlspecialchars("Provincia: " . $pedido['Provincia_Usuario']) ?> <br>
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
                $sentenciaSQL = $conexion->prepare("SELECT * FROM Facturas_Pedidos_Productos WHERE Facturas_Pedidos_Productos.Pedidos_ID_Pedido=:IdPedido");
                $sentenciaSQL->bindParam(":IdPedido", $IdPedido);
                $sentenciaSQL->execute();
                $listaProductosCantidades = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

              
                foreach ($listaProductosCantidades as $productoCantidad) {

                ?>
                    <tr>
                        <td> <?php echo htmlspecialchars($productoCantidad['Nombre_Producto']) ?> </td>
                        <td class="text-end"> <?php echo htmlspecialchars($productoCantidad['Cantidad_Productos']) ?> </td>
                    </tr>

                <?php } ?>
            </tbody>
        </table>

        <div class="card-footer text-muted">
            <p class="text-center text-body-secondary">© 2024 Sportseek S.A.S.</p>
        </div>

    </div>
</div>

<script src="./js/imprimirDescargarPedido.js"></script>

<?php include("template/pie.php"); ?>