<?php include('../template/cabecera.php') ?>

<?php
//Recibir los datos del formulario y guardarlo en variables. Si no hay datos se guardan vacías
$txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : "";
$txtNombre = (isset($_POST['txtNombre'])) ? $_POST['txtNombre'] : "";
$txtDescripcion = (isset($_POST['txtDescripcion'])) ? $_POST['txtDescripcion'] : "";
$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";

include("../config/bd.php");

switch ($accion) {
    case "Agregar":
        // Insertar datos a tabla Categorias
        $sentenciaSQL= $conexion->prepare("INSERT INTO Categorias (Nombre_Categoria, Descripcion_Categoria) VALUES (:nombre, :descripcion);");
        $sentenciaSQL->bindParam(':nombre',$txtNombre);
        $sentenciaSQL->bindParam(':descripcion',$txtDescripcion);
        $sentenciaSQL->execute();

        header('Location:categorias.php');
        break;
    case "Modificar":
        $sentenciaSQL= $conexion->prepare("UPDATE Categorias SET Nombre_Categoria=:nombre, Descripcion_Categoria=:descripcion WHERE id=:id");
        $sentenciaSQL->bindParam(':nombre',$txtNombre);
        $sentenciaSQL->bindParam(':descripcion',$txtDescripcion);
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();
        
        header('Location:categorias.php');
        break;
    case "Cancelar":
        header('Location:categorias.php');
        break;
    case 'Seleccionar':
        $sentenciaSQL= $conexion->prepare("SELECT * FROM Productos WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();
        $categoria=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

        $txtNombre = $categoria['Nombre_Categoria'];
        $txtDescripcion = $categoria['Descripcion_Categoria'];
        break;
    case 'Borrar':
        // Borrar resto de datos
        $sentenciaSQL= $conexion->prepare("DELETE FROM Productos WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();

        header('Location:categorias.php');
        break;

}

$sentenciaSQL= $conexion->prepare("SELECT * FROM Productos");
$sentenciaSQL->execute();
$listaProductos=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="container">
    <div class="row">
    <div class="col-md-5">
    <div class="card">
        <div class="card-header">
            Datos de la Categoría
        </div>
        <div class="card-body">

            <form method="POST" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="txtID">ID:</label>
                    <input type="text" required readonly value="<?php echo $txtID; ?>" class="form-control" name="txtID" id="txtID" placeholder="ID">
                </div>

                <div class="form-group">
                    <label for="txtNombre">Nombre:</label>
                    <input type="text" required value="<?php echo $txtNombre; ?>" class="form-control" name="txtNombre" id="txtNombre" placeholder="Nombre de la categoría">
                </div>

                <div class="form-group">
                    <label for="txtImagen">Descripcion:</label>

                    <input type="text" required value="<?php echo $txtDescripcion; ?>" class="form-control" name="txtNombre" id="txtNombre" placeholder="Describe la categoría">
                </div>


                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" name="accion" <?php echo ($accion=="Seleccionar")?"disabled":""; ?> value="Agregar" class="btn btn-success">Agregar</button>
                    <button type="submit" name="accion" <?php echo ($accion!="Seleccionar")?"disabled":""; ?> value="Modificar" class="btn btn-warning">Modificar</button>
                    <button type="submit" name="accion" <?php echo ($accion!="Seleccionar")?"disabled":""; ?> value="Cancelar" class="btn btn-info">Cancelar</button>
                </div>

            </form>

        </div>
    </div>




</div>


<div class="col-md-7">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th id="th-ID">ID</th>
                <th id="th-nombre">Nombre</th>
                <th id="th-nombre">Descripción</th>
                <th id="th-acciones">Acciones</th>

            </tr>
        </thead>
        <tbody>
            <?php foreach($listaProductos as $producto) { ?>
            <tr>
                <td><?php echo $producto['ID']; ?></td>
                <td><?php echo $producto['Nombre_Producto']; ?></td>
                <td id="td-imagen">
                    <img class="img-thumbnail rounded" src="../../imgProductos/<?php echo $producto['Imagen_Producto']; ?>" width="50" >
                </td>
                
                <td>
                <form method="POST">
                    <input type="hidden" name="txtID" id="txtID" value="<?php echo $producto['ID_Producto']; ?>">
                
                    <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary">

                    <input type="submit" name="accion" value="Borrar" class="btn btn-danger">

                </form>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
    </div>
</div>




<?php include('../template/pie.php') ?>