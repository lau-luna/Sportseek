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

// Crear las condiciones para nombre, apellidos o ID de pedido
foreach ($palabras as $index => $palabra) {
    $params[":busqueda$index"] = "%$palabra%";
    $condiciones[] = "(Usuarios.Nombre_Usuario LIKE :busqueda$index OR Usuarios.Apellidos_Usuario LIKE :busqueda$index OR Pedidos.ID_Pedido LIKE :busqueda$index)";
}

$condiciones = implode(' OR ', $condiciones);

$sql = "SELECT DISTINCT Pedidos.ID_Pedido, Usuarios.ID_Usuario, Usuarios.Nombre_Usuario, Usuarios.Apellidos_Usuario, Pedidos.Fecha_Pedido, Estados_Pedidos.Estado_Pedido
        FROM Pedidos
        INNER JOIN Usuarios ON Pedidos.Usuarios_ID_Usuario = Usuarios.ID_Usuario
        INNER JOIN Estados_Pedidos ON Pedidos.Estados_Pedidos_ID_Estado_Pedido = Estados_Pedidos.ID_Estado_Pedido
        WHERE (:estado = 'ninguno' OR Pedidos.Estados_Pedidos_ID_Estado_Pedido = :estado)
        AND ($condiciones)
        ORDER BY Pedidos.Fecha_Pedido DESC";

$sentenciaSQL = $conexion->prepare($sql);
$sentenciaSQL->bindParam(':estado', $filtroSeleccionado);

foreach ($params as $param => $value) {
    $sentenciaSQL->bindValue($param, $value);
}

$sentenciaSQL->execute();
$listaPedidos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

// Actualizar el estado del pedido si se envía el formulario de actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['estado_pedido'], $_POST['ID_Pedido'])) {
    $nuevoEstado = $_POST['estado_pedido'];
    $ID_Pedido = $_POST['ID_Pedido'];

    $sqlUpdate = "UPDATE Pedidos SET Estados_Pedidos_ID_Estado_Pedido = :nuevoEstado WHERE ID_Pedido = :ID_Pedido";
    $sentenciaUpdate = $conexion->prepare($sqlUpdate);
    $sentenciaUpdate->bindParam(':nuevoEstado', $nuevoEstado);
    $sentenciaUpdate->bindParam(':ID_Pedido', $ID_Pedido);
    $sentenciaUpdate->execute();

    // Redirigir para evitar reenvío del formulario
    header("Location: ".$_SERVER['REQUEST_URI']);
    exit;
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="./css/factura.css" rel="stylesheet">

<div class="container">
    <div class="d-flex justify-content-between mb-2 busqueda-filtro">
        <form method="GET" class="form-inline flex-grow-1 me-2" id="formulario-busqueda-pedidos">
            <input class="form-control w-100" name="busqueda" type="text" placeholder="Buscar por usuario, apellidos o ID de pedido" value="<?php echo htmlspecialchars($busqueda); ?>" style="max-width: 500px;">
            <button class="btn btn-primary" type="submit" style="display: flex; align-items: center; justify-content: center; padding: 0.39rem;">
                <img src="../../img/logoBuscador.png" style="height: 1.5rem; width: auto;" />
            </button>
            <div class="d-flex flex-column align-items-end">
                <label class="form-label">Filtrar por estado:</label>
                <select name="txtFiltro" id="filtro" class="form-control" onchange="this.form.submit()">
                    <option value="ninguno" <?php echo ($filtroSeleccionado == 'ninguno') ? 'selected' : ''; ?>>Todos</option>
                    <option value="2" <?php echo ($filtroSeleccionado == 1) ? 'selected' : ''; ?>>Completados</option>
                    <option value="1" <?php echo ($filtroSeleccionado == 2) ? 'selected' : ''; ?>>Pendientes</option>
                    <option value="3" <?php echo ($filtroSeleccionado == 3) ? 'selected' : ''; ?>>Cancelados</option>
                </select>
            </div>
        </form>
    </div>

    <div class="col-md-12">
        <table class="table table-bordered" id="tabla-pedidos">
            <thead>
                <tr style="font-size: small;">
                    <th style="width: 10%;" id="th-ID">ID Pedido</th>
                    <th style="width: 10%;" id="th-ID">ID Usuario</th>
                    <th style="width: 30%;" id="th-ID">Nombre usuario</th>
                    <th id="th-estado">Estado</th>
                    <th style="width: 25%;" id="th-fecha">Fecha de Emisión</th>
                    <th style="width: 12%;" id="th"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listaPedidos as $pedido) {
                    $classPedido = "";
                    switch ($pedido['Estado_Pedido']) {
                        case 'Entregado':
                            $classPedido = 'alert-success';
                            break;
                        case 'Pendiente':
                            $classPedido = 'alert-warning';
                            break;
                        case 'Cancelado':
                            $classPedido = 'alert-danger';
                            break;
                    } ?>
                    <tr>
                        <td><?php echo htmlspecialchars($pedido['ID_Pedido']); ?></td>
                        <td><?php echo htmlspecialchars($pedido['ID_Usuario']); ?></td>
                        <td><?php echo htmlspecialchars($pedido['Apellidos_Usuario'] . ", " . $pedido['Nombre_Usuario']); ?></td>
                        <td>
                            <div class="alert <?php echo htmlspecialchars($classPedido); ?>" role="alert"> <?php echo htmlspecialchars($pedido['Estado_Pedido']); ?> </div>
                        </td>
                        <td><?php echo htmlspecialchars($pedido['Fecha_Pedido']); ?></td>
                        <td>
                            <!-- Formulario para ver detalle -->
                            <form action="pedido.php" method="GET" style="display: inline;">
                                <input type="hidden" name="ID_Pedido" value="<?php echo htmlspecialchars($pedido['ID_Pedido']); ?>">
                                <button type="submit" class="btn btn-outline-primary">Ver Detalle</button>
                            </form>

                            <!-- Formulario para cambiar estado -->
                            <form action="" method="POST" style="display: inline;">
                                <input type="hidden" name="ID_Pedido" value="<?php echo htmlspecialchars($pedido['ID_Pedido']); ?>">
                                <select name="estado_pedido" class="form-control mt-2" onchange="this.form.submit()">
                                    <option value="2" <?php echo ($pedido['Estado_Pedido'] == 'Completado') ? 'selected' : ''; ?>>Completado</option>
                                    <option value="1" <?php echo ($pedido['Estado_Pedido'] == 'Pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                                    <option value="3" <?php echo ($pedido['Estado_Pedido'] == 'Cancelado') ? 'selected' : ''; ?>>Cancelado</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php include('../template/pie.php'); ?>
