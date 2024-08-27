<?php include('../template/cabecera.php'); ?>
<!--Conexión a base de datos -->
<?php include("../config/bd.php"); ?>

<?php
$mesActual = date('n');
$mesActual;

$mesSeleccionado = (isset($_GET['mes']))? $_GET['mes']:  $mesActual;





?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="../../css/factura.css" rel="stylesheet">

<div class="container mt-2">
    <div class="d-flex justify-content-between mb-3 busqueda-filtro">
        <form method="GET" class="form-inline flex-grow-1 ml-3 me-2" id="formulario-busqueda-facturas">
            <div class="d-flex ml-4">
                <label class="form-label">Mes:</label>
                <select name="mes" id="mes" class="form-control ml-2" onchange="this.form.submit()">
                    <option value="1" <?php echo ($mesActual == 1) ? 'selected' : ''; ?>>Enero</option>
                    <option value="2" <?php echo ($mesActual == 2) ? 'selected' : ''; ?>>Febrero</option>
                    <option value="3" <?php echo ($mesActual == 3) ? 'selected' : ''; ?>>Marzo</option>
                    <option value="4" <?php echo ($mesActual == 4) ? 'selected' : ''; ?>>Abril</option>
                    <option value="5" <?php echo ($mesActual == 5) ? 'selected' : ''; ?>>Mayo</option>
                    <option value="6" <?php echo ($mesActual == 6) ? 'selected' : ''; ?>>Junio</option>
                    <option value="7" <?php echo ($mesActual == 7) ? 'selected' : ''; ?>>Julio</option>
                    <option value="8" <?php echo ($mesActual == 8) ? 'selected' : ''; ?>>Agosto</option>
                    <option value="9" <?php echo ($mesActual == 9) ? 'selected' : ''; ?>>Septiembre</option>
                    <option value="10" <?php echo ($mesActual == 10) ? 'selected' : ''; ?>>Octubre</option>
                    <option value="11" <?php echo ($mesActual == 11) ? 'selected' : ''; ?>>Noviembre</option>
                    <option value="12" <?php echo ($mesActual == 12) ? 'selected' : ''; ?>>Diciembre</option>
                </select>
            </div>
        </form>
    </div>


    <!-- Agregamos la clase d-flex y justify-content-end para alinear a la derecha -->
    <div class="div-botones-imprimir-descargar mb-2 d-flex justify-content-end">
        <button class="btn btn-outline-primary mr-2 col-md-2" id="boton-imprimir" onclick="imprimirPedido()">
            <img style="width: 10%;" src="../../img/impresora.png" alt="">
            Imprimir Factura</button>
        <button class="btn btn-outline-danger col-md-2" id="boton-descargar" onclick="descargarPDF()">
            <img style="width: 10%;" src="../../img/pdf.png" alt="">
            Descargar como PDF</button>
    </div>


        <table class="table table-bordered mt-4">
            <thead class="table-light table-bordered">
                <tr>
                    <th style="width: 10%;">ID Pedido</th>
                    <th style="width: 10%;">ID Producto</th>
                    <th >Nombre Producto</th>
                    <th style="width: 5%;">Cantidad</th>
                    <th style="width: 10%;">Precio Unitario</th>
                    <th style="width: 10%;">I.V.A. 21%</th>
                    <th style="width: 10%;" class="text-end">Precio Total </th>

                </tr>
            </thead>
            <tbody>
                <?php
                $sentenciaSQL = $conexion->prepare("SELECT Facturas_Pedidos_Productos.ID_Producto, Facturas_Pedidos_Productos.Nombre_Producto, Facturas_Pedidos_Productos.Cantidad_Productos, Facturas_Pedidos_Productos.Precio_Producto, Facturas_Pedidos_Productos.Pedidos_ID_Pedido
                FROM Facturas_Pedidos_Productos INNER JOIN Pedidos ON Facturas_Pedidos_Productos.Facturas_ID_Factura=Pedidos.ID_Pedido
                WHERE MONTH(Pedidos.Fecha_Pedido) = :mesSeleccionado");
                $sentenciaSQL->bindParam(":mesSeleccionado", $mesSeleccionado);
                $sentenciaSQL->execute();
                $listaProductosCantidades = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

                $precioTotal = 0;

                foreach ($listaProductosCantidades as $productoCantidad) {
                $precio = $productoCantidad['Cantidad_Productos'] *  $productoCantidad['Precio_Producto'];
                $IVA = ($precio * 21)/100;
                $precio = $precio+$IVA;
                $precioTotal += $precio;
                ?>
                    <tr>
                        <td> <?php echo htmlspecialchars($productoCantidad['Pedidos_ID_Pedido']) ?> </td>
                        <td> <?php echo htmlspecialchars($productoCantidad['ID_Producto']) ?> </td>
                        <td> <?php echo htmlspecialchars($productoCantidad['Nombre_Producto']) ?> </td>
                        <td> <?php echo htmlspecialchars($productoCantidad['Cantidad_Productos']) ?> </td>
                        <td>$ <?php echo htmlspecialchars($productoCantidad['Precio_Producto']) ?></td>
                        <td>$ <?php echo htmlspecialchars($IVA) ?></td>
                        <td class="text-end">$ <?php echo htmlspecialchars($precio) ?> </td>

                    </tr>

                <?php } ?>

            </tbody>
            <tfoot>

                <tr class="total-row">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                    <td>Total:</td>
                    <td class="text-end">$ <?php echo htmlspecialchars($precioTotal) ?> </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<script src="../../js/imprimirDescargarFactura.js"></script>

<?php include('../template/pie.php'); ?>