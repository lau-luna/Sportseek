<?php include("template/cabecera.php"); ?>
<!--Conexión a base de datos -->
<?php include("administrador/config/bd.php"); ?>

<?php

// Obtener el filtro seleccionada del formulario
$filtroSeleccionado = isset($_POST['txtFiltro']) ? $_POST['txtFiltro'] : 'ninguno';

if ($filtroSeleccionado == 'ninguno') {
    $sentenciaSQL = $conexion->prepare("SELECT * FROM Pedidos WHERE Usuarios_ID_Usuario=:IdUsuario ORDER BY Fecha_Pedido DESC");
    $sentenciaSQL->bindParam(":IdUsuario", $_SESSION['ID_Usuario']);
    $sentenciaSQL->execute();
    $listaPedidos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
} else {
    $sentenciaSQL = $conexion->prepare("SELECT * FROM Pedidos WHERE Usuarios_ID_Usuario=:IdUsuario AND Estados_Pedidos_ID_Estado_Pedido=:estado ORDER BY Fecha_Pedido DESC");
    $sentenciaSQL->bindParam(":IdUsuario", $_SESSION['ID_Usuario']);
    $sentenciaSQL->bindParam(":estado", $filtroSeleccionado);
    $sentenciaSQL->execute();
    $listaPedidos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
}

?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="./css/factura.css" rel="stylesheet">

<div class="container">
    <form method="POST" action="">
        <div class="col-md-2 mb-2">
            <label class="form-label">Filtrar por estado:</label>
            <select name="txtFiltro" id="filtro" class="form-control" onchange="this.form.submit()">
                <option value="ninguno" <?php if ($filtroSeleccionado == 'ninguno') echo 'selected'; ?>>Todos</option>
                <option value="1" <?php if ($filtroSeleccionado == 1) echo 'selected'; ?>>Pendientes</option>
                <option value="2" <?php if ($filtroSeleccionado == 2) echo 'selected'; ?>>Entregados</option>
                <option value="3" <?php if ($filtroSeleccionado == 3) echo 'selected'; ?>>Cancelados</option>
            </select>
        </div>
    </form>

    <div class="col-md-12">
        <table class="table table-bordered" id="tabla-productos">
            <thead>
                <tr style="font-size: small;">
                    <th style="width: 10%;" id="th-ID">ID Pedido</th>
                    <th id="th-estado">Estado</th>
                    <th style="width: 25%;" id="th-fecha">Fecha</th>
                    <th style="width: 10%;" id="th"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listaPedidos as $pedido) {
                    $sentenciaSQL = $conexion->prepare("SELECT Estados_Pedidos.Estado_Pedido FROM Pedidos INNER JOIN Estados_Pedidos ON Pedidos.Estados_Pedidos_ID_Estado_Pedido=Estados_Pedidos.ID_Estado_Pedido WHERE Pedidos.ID_Pedido=:IdPedido");
                    $sentenciaSQL->bindParam(":IdPedido", $pedido['ID_Pedido']);
                    $sentenciaSQL->execute();
                    $estadoPedido = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

                    $classPedido = "";
                    switch ($estadoPedido->Estado_Pedido) {
                        case 'Entregado':
                            $classPedido = 'alert-success';
                            break;
                        case 'Pendiente':
                            $classPedido = 'alert-primary';
                            break;
                        case 'Cancelado':
                            $classPedido = 'alert-danger';
                            break;
                    } ?>

                    <form id="form-pedido-<?php echo htmlspecialchars($pedido['ID_Pedido']); ?>" action="pedido.php" method="POST">
                        <input type="hidden" name="ID_Pedido" value="<?php echo htmlspecialchars($pedido['ID_Pedido']); ?>">
                        <tr>
                            <td><?php echo htmlspecialchars($pedido['ID_Pedido']); ?></td>
                            <td>
                                <div class="alert <?php echo htmlspecialchars($classPedido); ?>" role="alert"> <?php echo htmlspecialchars($estadoPedido->Estado_Pedido); ?> </div>
                            </td>
                            <td><?php echo htmlspecialchars($pedido['Fecha_Pedido']); ?></td>
                            <td><button type="submit" class="btn btn-primary">Ver Detalle</button></td>
                        </tr>
                    </form>

                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php include("template/pie.php"); ?>
