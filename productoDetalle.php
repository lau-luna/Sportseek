<?php include("template/cabecera.php"); ?>

<!-- Conexión a base de datos -->
<?php include("administrador/config/bd.php"); ?>
<br>
<?php
if (preg_match('/^[0-9]+$/', $_GET['IdProducto'])) {
    // Obtener el producto específico
    $sentenciaSQL = $conexion->prepare("SELECT * FROM Productos WHERE ID_Producto = :id");
    $sentenciaSQL->bindParam(':id', $_GET['IdProducto']);
    $sentenciaSQL->execute();
    $producto = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);

    // Obtener la categoría del producto
    $sentenciaSQL = $conexion->prepare("SELECT Categorias.Nombre_Categoria FROM Productos INNER JOIN Categorias ON Categorias.ID_Categoria = Productos.Categorias_ID_Categoria WHERE Productos.ID_Producto = :id");
    $sentenciaSQL->bindParam(':id', $_GET['IdProducto']);
    $sentenciaSQL->execute();
    $categoria = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);

    // Formatear el precio del producto
    $precioFormateado = number_format($producto['Precio_Producto'], 0, ',', '.');
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <img class="card-img-top" src="./imgProductos/<?php echo htmlspecialchars($producto['Imagen_Producto']) ?>" alt="Imagen del producto">
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <p class="card-text text-success mb-1" style="font-size: smaller;"> <?php echo htmlspecialchars($categoria['Nombre_Categoria']) ?> </p>
                    <h3 class="card-title text-info"> <?php echo htmlspecialchars($producto['Nombre_Producto']) ?> </h3>
                    <p class="card-text text-danger mb-1" style="font-size: large;">$ <?php echo $precioFormateado ?> </p>
                    <div class="mb-4"></div>

                    <?php if ($producto['Tiene_Stock_Producto'] == 0) { ?>
                        <div class="alert alert-danger" role="alert">
                            Sin stock!
                        </div>
                    <?php } else { ?>

                        <form id="form" action="carrito.php" method="POST" onsubmit="return validateForm()">
                            <input type="hidden" name="IdProducto" value="<?php echo htmlspecialchars($producto['ID_Producto']) ?>">
                            <label for="cantidad">Cantidad:</label>
                            <input type="number" min="1" value="1" id="cantidad" class="form-control col-md-2 mb-2" name="cantidadProducto" required oninput="this.value = this.value.replace(/[^0-9]/g, '')">

                            <a href="#" onclick="document.getElementById('form').submit();">
                                <button type="button" class="btn btn-success mb-4">Agregar al carrito</button>
                            </a>
                        </form>
                    <?php } ?>

                    <p class="mb-0" style="font-size: large; font-weight: bold;">Descripción</p>
                    <hr style="margin-top: 0.5%; margin-bottom: 1%;">
                    <p class="card-text mb-2" style="margin-bottom: 4%;"><?php echo htmlspecialchars($producto['Descripcion_Producto']) ?></p>

                    <p class="mb-0" style="font-size: large; font-weight: bold;">Especificaciones</p>
                    <hr style="margin-top: 0.5%; margin-bottom: 1%;">
                    <p class="card-text"><?php echo htmlspecialchars($producto['Especificaciones_Producto']) ?></p>
                </div>
                <div class="card-footer text-muted">
                    Sportseek
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function validateForm() {
    var cantidad = document.getElementById("cantidad").value;
    if (isNaN(cantidad) || cantidad <= 0) {
        alert("Por favor, ingrese una cantidad válida.");
        return false; // Evita que el formulario se envíe si la cantidad no es válida
    }
    return true; // Permite que el formulario se envíe si la cantidad es válida
}
</script>

<?php include("template/pie.php"); ?>

<?php include("template/cabecera.php"); ?>

<br><br>

<?php

include("administrador/config/bd.php");

if (!isset($_SESSION['ID_Usuario'])) {
    echo "<script>window.location.href='loginUsuario.php';</script>";
}

// Obtener carrito del usuario
$sentenciaSQL = $conexion->prepare("SELECT * FROM Carritos INNER JOIN Usuarios ON Usuarios.ID_Usuario = Carritos.Usuarios_ID_Usuario WHERE Usuarios.ID_Usuario = :IdUsuario");
$sentenciaSQL->bindParam(":IdUsuario", $_SESSION['ID_Usuario']);
$sentenciaSQL->execute();
$carrito = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);

// Si el usuario tiene un carrito guardado
if (isset($carrito['ID_Carrito'])) {

    // Si se manda un producto desde productoDetalle.php
    if (isset($_POST['IdProducto']) && preg_match('/^[0-9]+$/', $_POST['IdProducto'])) {
        // Comprobar si ya tiene el producto seleccionado para aumentar su cantidad
        $sentenciaSQL = $conexion->prepare("SELECT Productos_ID_Producto, Cantidad_Productos FROM Carritos_Productos WHERE Carritos_ID_Carrito = :IdCarrito AND Productos_ID_Producto = :IdProducto");
        $sentenciaSQL->bindParam(":IdCarrito", $carrito['ID_Carrito']);
        $sentenciaSQL->bindParam(":IdProducto", $_POST['IdProducto']);
        $sentenciaSQL->execute();
        $productoExistente = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);

        if (isset($productoExistente['Productos_ID_Producto'])) {
            $cantidad = intval($productoExistente['Cantidad_Productos']) + intval($_POST['cantidadProducto']);
            $sentenciaSQL = $conexion->prepare("UPDATE Carritos_Productos SET Cantidad_Productos = :cantidad WHERE Carritos_ID_Carrito = :IdCarrito AND Productos_ID_Producto = :IdProducto");
            $sentenciaSQL->bindParam(":IdCarrito", $carrito['ID_Carrito']);
            $sentenciaSQL->bindParam(":IdProducto", $_POST['IdProducto']);
            $sentenciaSQL->bindParam(":cantidad", $cantidad);
            $sentenciaSQL->execute();
        } else {
            // Insertar el nuevo producto seleccionado en el carrito
            $sentenciaSQL = $conexion->prepare("INSERT INTO Carritos_Productos (Carritos_ID_Carrito, Productos_ID_Producto, Cantidad_Productos) VALUES (:IdCarrito, :IdProducto, :cantidad)");
            $sentenciaSQL->bindParam(":IdCarrito", $carrito['ID_Carrito']);
            $sentenciaSQL->bindParam(":IdProducto", $_POST['IdProducto']);
            $sentenciaSQL->bindParam(":cantidad", $_POST['cantidadProducto']);
            $sentenciaSQL->execute();
        }
    }
} else {
    // Crear nuevo carrito si no existe
    $fecha = new DateTime();
    $fechaCarrito = date('Y-m-d H:i:s', $fecha->getTimestamp());

    $sentenciaSQL = $conexion->prepare("INSERT INTO Carritos (Fecha_Creacion_Carrito, Usuarios_ID_Usuario) VALUES (:fecha, :IdUsuario)");
    $sentenciaSQL->bindParam(":IdUsuario", $_SESSION['ID_Usuario']);
    $sentenciaSQL->bindParam(":fecha", $fechaCarrito);
    $sentenciaSQL->execute();

    // Obtener el ID del carrito recién creado
    $carrito['ID_Carrito'] = $conexion->lastInsertId();

    if (isset($_POST['IdProducto']) && preg_match('/^[0-9]+$/', $_POST['IdProducto'])) {
        // Insertar productos en el nuevo carrito
        $sentenciaSQL = $conexion->prepare("INSERT INTO Carritos_Productos (Carritos_ID_Carrito, Productos_ID_Producto, Cantidad_Productos) VALUES (:IdCarrito, :IdProducto, :cantidad)");
        $sentenciaSQL->bindParam(":IdCarrito", $carrito['ID_Carrito']);
        $sentenciaSQL->bindParam(":IdProducto", $_POST['IdProducto']);
        $sentenciaSQL->bindParam(":cantidad", $_POST['cantidadProducto']);
        $sentenciaSQL->execute();
    }
}

// Obtener lista de productos en el carrito
$sentenciaSQL = $conexion->prepare("SELECT Productos.*, Carritos_Productos.Cantidad_Productos FROM Carritos_Productos INNER JOIN Productos ON Carritos_Productos.Productos_ID_Producto = Productos.ID_Producto WHERE Carritos_Productos.Carritos_ID_Carrito = :IdCarrito");
$sentenciaSQL->bindParam(":IdCarrito", $carrito['ID_Carrito']);
$sentenciaSQL->execute();
$listaCarritosProductos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>
