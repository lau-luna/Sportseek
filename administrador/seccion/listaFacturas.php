<?php include('../template/cabecera.php'); ?>
<!--Conexión a base de datos -->
<?php include("../config/bd.php"); ?>

<?php
// Obtener el filtro seleccionada del formulario
$filtroSeleccionado = isset($_GET['txtFiltro']) ? $_GET['txtFiltro'] : 'ninguno';
$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';

// Dividir la búsqueda en palabras
$palabras = explode(' ', $busqueda);
$condiciones = [];
$params = [];

// Crear las condiciones para nombre, apellidos o ID de factura
foreach ($palabras as $index => $palabra) {
    $params[":busqueda$index"] = "%$palabra%";
    $condiciones[] = "(Usuarios.Nombre_Usuario LIKE :busqueda$index OR Usuarios.Apellidos_Usuario LIKE :busqueda$index OR Facturas.ID_Factura LIKE :busqueda$index)";
}

$condiciones = implode(' OR ', $condiciones);

$sql = "SELECT DISTINCT Facturas.ID_Factura, Usuarios.ID_Usuario, Usuarios.Nombre_Usuario, Usuarios.Apellidos_Usuario, Facturas.Fecha_Emision_Factura, Estados_Facturas.Estado_Factura, Facturas.Total_Factura, Facturas.IVA_Factura, Facturas.Metodo_Pago
        FROM Facturas
        INNER JOIN Usuarios ON Facturas.Usuarios_ID_Usuario = Usuarios.ID_Usuario
        INNER JOIN Facturas_Pedidos_Productos ON Facturas.ID_Factura = Facturas_Pedidos_Productos.Facturas_ID_Factura
        INNER JOIN Estados_Facturas ON Facturas.Estados_Facturas_ID_Estados_Factura = Estados_Facturas.ID_Estados_Factura
        WHERE (:estado = 'ninguno' OR Facturas.Estados_Facturas_ID_Estados_Factura = :estado)
        AND ($condiciones)
        ORDER BY Facturas.Fecha_Emision_Factura DESC";

$sentenciaSQL = $conexion->prepare($sql);
$sentenciaSQL->bindParam(':estado', $filtroSeleccionado);

foreach ($params as $param => $value) {
    $sentenciaSQL->bindValue($param, $value);
}

$sentenciaSQL->execute();
$listaFacturas = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="./css/factura.css" rel="stylesheet">

<div class="container">
    <div class="d-flex justify-content-between mb-3 busqueda-filtro">
        <form method="GET" class="form-inline flex-grow-1 ml-3 me-2" id="formulario-busqueda-facturas">
            <input class="form-control w-100" name="busqueda" type="text" placeholder="Buscar por usuario, apellidos o ID de factura" value="<?php echo htmlspecialchars($busqueda); ?>" style="max-width: 500px;">
            <button class="btn btn-primary" type="submit" style="display: flex; align-items: center; justify-content: center; padding: 0.39rem;">
                <img src="../../img/logoBuscador.png" style="height: 1.5rem; width: auto;" />
            </button>
            <div class="d-flex ml-4">
                <label class="form-label">Filtrar por estado:</label>
                <select name="txtFiltro" id="filtro" class="form-control ml-2" onchange="this.form.submit()">
                    <option value="ninguno" <?php echo ($filtroSeleccionado == 'ninguno') ? 'selected' : ''; ?>>Todas</option>
                    <option value="1" <?php echo ($filtroSeleccionado == 1) ? 'selected' : ''; ?>>Pagadas</option>
                    <option value="2" <?php echo ($filtroSeleccionado == 2) ? 'selected' : ''; ?>>No Pagadas</option>
                    <option value="3" <?php echo ($filtroSeleccionado == 3) ? 'selected' : ''; ?>>Canceladas</option>
                </select>
            </div>
        </form>
    </div>

    <div class="col-md-12">
        <table class="table table-bordered" id="tabla-productos">
            <thead>
                <tr style="font-size: small;">
                    <th style="width: 10%;">ID Factura</th>
                    <th style="width: 10%;">ID Usuario</th>
                    <th style="width: 20%;">Nombre Usuario</th>
                    <th style="width: 10%;">Estado</th>
                    <th style="width: 15%;">Fecha de Emisión</th>
                    <th style="width: 15%;">Total Factura</th>
                    <th style="width: 10%;">IVA</th>
                    <th style="width: 10%;">Método de Pago</th>
                    <th style="width: 10%;"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listaFacturas as $factura) {
                    $classFactura = "";
                    switch ($factura['Estado_Factura']) {
                        case 'Pagado':
                            $classFactura = 'alert-success';
                            break;
                        case 'No pagado':
                            $classFactura = 'alert-warning';
                            break;
                        case 'Cancelado':
                            $classFactura = 'alert-danger';
                            break;
                    } ?>
                    <form id="form-factura-<?php echo htmlspecialchars($factura['ID_Factura']); ?>" action="factura.php" method="GET">
                        <input type="hidden" name="ID_Factura" value="<?php echo htmlspecialchars($factura['ID_Factura']); ?>">
                        <tr>
                            <td><?php echo htmlspecialchars($factura['ID_Factura']); ?></td>
                            <td><?php echo htmlspecialchars($factura['ID_Usuario']); ?></td>
                            <td><?php echo htmlspecialchars($factura['Apellidos_Usuario'] . ", " . $factura['Nombre_Usuario']); ?></td>
                            <td>
                                <div class="alert <?php echo htmlspecialchars($classFactura); ?>" role="alert"> <?php echo htmlspecialchars($factura['Estado_Factura']); ?> </div>
                            </td>
                            <td><?php echo htmlspecialchars($factura['Fecha_Emision_Factura']); ?></td>
                            <td>$<?php echo htmlspecialchars(number_format($factura['Total_Factura'], 2)); ?></td>
                            <td>$<?php echo htmlspecialchars(number_format($factura['IVA_Factura'], 2)); ?></td>
                            <td><?php echo htmlspecialchars($factura['Metodo_Pago']); ?></td>
                            <td><button style="width: 100%" type="submit" class="btn btn-outline-primary">Ver Detalle</button></td>
                        </tr>
                    </form>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php include('../template/pie.php'); ?>
