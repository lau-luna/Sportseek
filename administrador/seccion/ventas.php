<?php include('../template/cabecera.php'); ?>
<!-- Conexión a base de datos -->
<?php include("../config/bd.php"); ?>

<?php
$mesActual = date('n');
$anoActual = date('Y');
$anoInicio = 2024; // Año inicial
$mesSeleccionado = isset($_GET['mes']) ? $_GET['mes'] : $mesActual;
$anoSeleccionado = isset($_GET['ano']) ? $_GET['ano'] : $anoActual;

// Obtener todas las categorías y sus ventas
$sentenciaSQL = $conexion->prepare("
    SELECT c.Nombre_Categoria, SUM(fp.Cantidad_Productos) AS Total_Vendido
    FROM Facturas_Pedidos_Productos fp
    INNER JOIN Productos p ON fp.ID_Producto = p.ID_Producto
    INNER JOIN Categorias c ON p.Categorias_ID_Categoria = c.ID_Categoria
    INNER JOIN Pedidos pd ON fp.Facturas_ID_Factura = pd.ID_Pedido
    WHERE MONTH(pd.Fecha_Pedido) = :mesSeleccionado AND YEAR(pd.Fecha_Pedido) = :anoSeleccionado
    GROUP BY c.Nombre_Categoria
");
$sentenciaSQL->bindParam(":mesSeleccionado", $mesSeleccionado);
$sentenciaSQL->bindParam(":anoSeleccionado", $anoSeleccionado);
$sentenciaSQL->execute();
$ventasPorCategoria = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

// Preparar los datos para el gráfico
$etiquetasCategorias = array_column($ventasPorCategoria, 'Nombre_Categoria');
$datosVentas = array_column($ventasPorCategoria, 'Total_Vendido');
$nombresMeses = [
    1 => 'Enero',
    2 => 'Febrero',
    3 => 'Marzo',
    4 => 'Abril',
    5 => 'Mayo',
    6 => 'Junio',
    7 => 'Julio',
    8 => 'Agosto',
    9 => 'Septiembre',
    10 => 'Octubre',
    11 => 'Noviembre',
    12 => 'Diciembre'
];
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="../../css/factura.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="container mt-2">
    <div class="d-flex justify-content-between mb-3 busqueda-filtro">
        <form method="GET" class="form-inline flex-grow-1 ml-3 me-2" id="formulario-busqueda-facturas">
            <div class="d-flex ml-4">
                <label class="form-label">Mes:</label>
                <select name="mes" id="mes" class="form-control ml-2" onchange="updateUrl(this.value, '<?php echo $anoSeleccionado; ?>')">
                    <?php foreach ($nombresMeses as $numeroMes => $nombreMes) : ?>
                        <option value="<?php echo $numeroMes; ?>" <?php echo ($mesSeleccionado == $numeroMes) ? 'selected' : ''; ?>>
                            <?php echo $nombreMes; ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <select name="ano" id="ano" class="form-control ml-2" onchange="updateUrl('<?php echo $mesSeleccionado; ?>', this.value)">
                    <?php for ($i = $anoInicio; $i <= $anoActual + 10; $i++) : ?>
                        <option value="<?php echo $i; ?>" <?php echo ($anoSeleccionado == $i) ? 'selected' : ''; ?>>
                            <?php echo $i; ?>
                        </option>
                    <?php endfor; ?>
                </select>

                <script>
                    function updateUrl(mes, ano) {
                        window.location.search = `?mes=${mes}&ano=${ano}`;
                    }
                </script>
            </div>
        </form>
    </div>

    <div style="max-width: 800px; max-height: 400px; margin: auto;">
        <canvas id="grafico"></canvas>
    </div>

    <script>
        const $grafico = document.querySelector("#grafico");
        const etiquetasCategorias = <?php echo json_encode($etiquetasCategorias); ?>;
        const datosCategorias = {
            label: "Ventas por Categoría en <?php echo $nombresMeses[$mesSeleccionado] . ' ' . htmlspecialchars($anoSeleccionado); ?>",
            data: <?php echo json_encode($datosVentas); ?>,
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        };
        new Chart($grafico, {
            type: 'bar',
            data: {
                labels: etiquetasCategorias,
                datasets: [datosCategorias]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <table class="table table-bordered mt-4">
        <thead class="table-light table-bordered">
            <tr>
                <th style="width: 8%;">ID Pedido</th>
                <th style="width: 8%;">ID Producto</th>
                <th style="width: 10%;">Categoria</th>
                <th>Nombre Producto</th>
                <th style="width: 2%;">Cantidad</th>
                <th style="width: 10%;">Precio Unitario</th>
                <th style="width: 10%;">I.V.A. 21%</th>
                <th style="width: 10%;" class="text-end">Precio Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sentenciaSQL = $conexion->prepare("
                SELECT Categorias.Nombre_Categoria, Facturas_Pedidos_Productos.ID_Producto, Facturas_Pedidos_Productos.Nombre_Producto, Facturas_Pedidos_Productos.Cantidad_Productos, Facturas_Pedidos_Productos.Precio_Producto, Facturas_Pedidos_Productos.Pedidos_ID_Pedido
                FROM Facturas_Pedidos_Productos 
                INNER JOIN Pedidos ON Facturas_Pedidos_Productos.Facturas_ID_Factura = Pedidos.ID_Pedido
                INNER JOIN Productos ON Facturas_Pedidos_Productos.Productos_ID_Productos = Productos.ID_Producto
                INNER JOIN Categorias ON Categorias.ID_Categoria = Productos.Categorias_ID_Categoria
                WHERE MONTH(Pedidos.Fecha_Pedido) = :mesSeleccionado AND YEAR(Pedidos.Fecha_Pedido) = :anoSeleccionado
            ");
            $sentenciaSQL->bindParam(":mesSeleccionado", $mesSeleccionado);
            $sentenciaSQL->bindParam(":anoSeleccionado", $anoSeleccionado);
            $sentenciaSQL->execute();
            $listaProductosCantidades = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

            $precioTotal = 0;

            foreach ($listaProductosCantidades as $productoCantidad) {
                $precio = $productoCantidad['Cantidad_Productos'] *  $productoCantidad['Precio_Producto'];
                $IVA = ($precio * 21) / 100;
                $precioConIVA = $precio + $IVA;
                $precioTotal += $precioConIVA;
            ?>
                <tr>
                    <td> <?php echo htmlspecialchars($productoCantidad['Pedidos_ID_Pedido']) ?> </td>
                    <td> <?php echo htmlspecialchars($productoCantidad['ID_Producto']) ?> </td>
                    <td> <?php echo htmlspecialchars($productoCantidad['Nombre_Categoria']) ?> </td>
                    <td> <?php echo htmlspecialchars($productoCantidad['Nombre_Producto']) ?> </td>
                    <td> <?php echo htmlspecialchars($productoCantidad['Cantidad_Productos']) ?> </td>
                    <td>$ <?php echo htmlspecialchars($productoCantidad['Precio_Producto']) ?></td>
                    <td>$ <?php echo htmlspecialchars($IVA) ?></td>
                    <td class="text-end">$ <?php echo htmlspecialchars($precioConIVA) ?> </td>
                </tr>
            <?php } ?>
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="6"></td>
                <td class="text-end" style="font-weight: bold;">Total:</td>
                <td class="text-end">$ <?php echo htmlspecialchars($precioTotal) ?> </td>
            </tr>
        </tfoot>
    </table>
</div>

<script src="../../js/imprimirDescargarFactura.js"></script>

<?php include('../template/pie.php'); ?>