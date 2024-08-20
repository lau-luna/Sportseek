<?php include('../template/cabecera.php') ?>
<!--Conexión a base de datos -->
<?php include("../config/bd.php"); ?>

<?php

// Obtener el filtro seleccionada del formulario
$filtroSeleccionado = isset($_GET['txtFiltro']) ? $_GET['txtFiltro'] : 'ninguno';

if ($filtroSeleccionado == 'ninguno') {
    $sentenciaSQL = $conexion->prepare("SELECT * FROM Facturas ORDER BY Fecha_Emision_Factura DESC");
    $sentenciaSQL->execute();
    $listaFacturas = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
} else {
    $sentenciaSQL = $conexion->prepare("SELECT * FROM Facturas WHERE Usuarios_ID_Usuario=:IdUsuario AND Estados_Facturas_ID_Estado_Factura=:estado ORDER BY Fecha_Emision_Factura DESC");
    $sentenciaSQL->bindParam(":IdUsuario", $_SESSION['ID_Usuario']);
    $sentenciaSQL->bindParam(":estado", $filtroSeleccionado);
    $sentenciaSQL->execute();
    $listaFacturas = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
}

?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="./css/factura.css" rel="stylesheet">

<div class="container">
    <form method="GET" class="form-inline" id="formulario-busqueda-facturas">
        <input class="form-control" name="busqueda" type="text" placeholder="Buscar por usuario o ID">
        <button class="btn btn-primary" type="submit" style="display: flex; align-items: center; justify-content: center; padding: 0.39rem;">
            <img src="../../img/logoBuscador.png" style="height: 1.5rem; width: auto;" />
        </button>
    </form>

    <form method="GET" action="">
        <div class="col-md-2 mb-2">
            <label class="form-label">Filtrar por estado:</label>
            <select name="txtFiltro" id="filtro" class="form-control" onchange="this.form.submit()">
                <option value="ninguno" <?php if ($filtroSeleccionado == 'ninguno') echo 'selected'; ?>>Todas</option>
                <option value="1" <?php if ($filtroSeleccionado == 1) echo 'selected'; ?>>Pagadas</option>
                <option value="2" <?php if ($filtroSeleccionado == 2) echo 'selected'; ?>>No Pagadas</option>
                <option value="3" <?php if ($filtroSeleccionado == 3) echo 'selected'; ?>>Canceladas</option>
            </select>
        </div>
    </form>

    <div class="col-md-12">
        <table class="table table-bordered" id="tabla-productos">
            <thead>
                <tr style="font-size: small;">
                    <th style="width: 10%;" id="th-ID">ID Factura</th>
                    <th style="width: 10%;" id="th-ID">ID Usuario</th>
                    <th style="width: 30%;" id="th-ID">Nombre usuario</th>
                    <th id="th-estado">Estado</th>
                    <th style="width: 25%;" id="th-fecha">Fecha de Emisión</th>
                    <th style="width: 10%;" id="th"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listaFacturas as $factura) {
                    $sentenciaSQL = $conexion->prepare("SELECT Estados_Facturas.Estado_Factura FROM Facturas INNER JOIN Estados_Facturas ON Facturas.Estados_Facturas_ID_Estados_Factura=Estados_Facturas.ID_Estados_Factura WHERE Facturas.ID_Factura=:IdFactura");
                    $sentenciaSQL->bindParam(":IdFactura", $factura['ID_Factura']);
                    $sentenciaSQL->execute();
                    $estadoFactura = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

                    $sentenciaSQL = $conexion->prepare("SELECT Nombre_Usuario, Apellidos_Usuario, ID_Usuario FROM Facturas INNER JOIN Usuarios ON Facturas.Usuarios_ID_Usuario=Usuarios.ID_Usuario WHERE Facturas.ID_Factura=:IdFactura");
                    $sentenciaSQL->bindParam(":IdFactura", $factura['ID_Factura']);
                    $sentenciaSQL->execute();
                    $usuario = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

                    $classFactura = "";
                    switch ($estadoFactura->Estado_Factura) {
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
                            <td><?php echo htmlspecialchars($usuario['ID_Usuario']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['Apellidos_Usuario'].", ".$usuario['Nombre_Usuario']); ?></td>
                            
                            <td>
                                <div class="alert <?php echo htmlspecialchars($classFactura); ?>" role="alert"> <?php echo htmlspecialchars($estadoFactura->Estado_Factura); ?> </div>
                            </td>
                            <td><?php echo htmlspecialchars($factura['Fecha_Emision_Factura']); ?></td>
                            <td><button style="width: 100%" type="submit" class="btn btn-outline-primary">Ver Detalle</button></td>
                        </tr>
                    </form>

                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php include('../template/pie.php') ?>
