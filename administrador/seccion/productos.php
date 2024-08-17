<?php include('../template/cabecera.php') ?>

<?php
//Recibir los datos del formulario y guardarlo en variables. Si no hay datos se guardan vacías
$txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : "";
$txtNombre = (isset($_POST['txtNombre'])) ? $_POST['txtNombre'] : "";
$txtImagen = (isset($_FILES['txtImagen']['name'])) ? $_FILES['txtImagen']['name'] : "";
$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";

include("../config/bd.php");

switch ($accion) {
    case "Agregar":
        // INSERT INTO `productos` (`ID`, `Nombre_Producto`, `Imagen_Producto`) VALUES (NULL, 'Zapatillas deportivas', 'imagen.jpg');
        // Insertar datos a tabla Productos
        $sentenciaSQL= $conexion->prepare("INSERT INTO Productos (Nombre_Producto, Imagen_Producto) VALUES (:nombre, :imagen);");
        $sentenciaSQL->bindParam(':nombre',$txtNombre);
       
        $fecha = new DateTime();
        $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imafen.jpg";

        $tmpImagen=$_FILES["txtImagen"]["tmp_name"];

        if($tmpImagen!=""){
            move_uploaded_file($tmpImagen,"../../imgProductos/".$nombreArchivo);
        }

        $sentenciaSQL->bindParam(':imagen',$nombreArchivo);
        $sentenciaSQL->execute();

        header('Location:productos.php');
        break;
    case "Modificar":
        $sentenciaSQL= $conexion->prepare("UPDATE Productos SET Nombre_Producto=:nombre WHERE id=:id");
        $sentenciaSQL->bindParam(':nombre',$txtNombre);
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();

        if($txtImagen!=""){
           

            // Subir nueva imagen
            $fecha = new DateTime();
            $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";
            
            $tmpImagen=$_FILES["txtImagen"]["tmp_name"];
            move_uploaded_file($tmpImagen,"../../imgProductos/".$nombreArchivo);

             // Borrar Imagen anterior
             $sentenciaSQL= $conexion->prepare("SELECT Imagen_Producto FROM Productos WHERE id=:id");
             $sentenciaSQL->bindParam(':id',$txtID);
             $sentenciaSQL->execute();
             $producto=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
 
             if( isset($producto['Imagen_Producto']) && ($producto['Imagen_Producto']!="imagen.jpg")){
                 if(file_exists("../../imgProductos/".$producto['Imagen_Producto'])){
                     unlink("../../imgProductos/".$producto['Imagen_Producto']);
                 }
             }

            $sentenciaSQL= $conexion->prepare("UPDATE Productos SET Imagen_Producto=:imagen WHERE id=:id");
            $sentenciaSQL->bindParam(':imagen',$nombreArchivo);
            $sentenciaSQL->bindParam(':id',$txtID);
            $sentenciaSQL->execute();
        }
        
        header('Location:productos.php');
        break;
    case "Cancelar":
        header('Location:productos.php');
        break;
    case 'Seleccionar':
        $sentenciaSQL= $conexion->prepare("SELECT * FROM Productos WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();
        $producto=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

        $txtNombre = $producto['Nombre_Producto'];
        $txtImagen = $producto['Imagen_Producto'];
        break;
    case 'Borrar':
        // Borrar Imagen
        $sentenciaSQL= $conexion->prepare("SELECT Imagen_producto FROM productos WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();
        $producto=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

        if( isset($producto['Imagen_producto']) && ($producto['Imagen_producto']!="imagen.jpg")){
            if(file_exists("../../imgProductos/".$producto['Imagen_producto'])){
                unlink("../../imgProductos/".$producto['Imagen_producto']);
            }
        }

        // Borrar resto de datos
        $sentenciaSQL= $conexion->prepare("DELETE FROM Productos WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();

        header('Location:productos.php');
        break;

}

$sentenciaSQL= $conexion->prepare("SELECT * FROM Productos");
$sentenciaSQL->execute();
$listaProductos=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            Datos del producto
        </div>
        <div class="card-body">

            <form method="POST" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="txtID">ID:</label>
                    <input type="text" required readonly value="<?php echo $txtID; ?>" class="form-control" name="txtID" id="txtID" placeholder="ID">
                </div>

                <div class="form-group">
                    <label for="txtNombre">Nombre:</label>
                    <input type="text" required value="<?php echo $txtNombre; ?>" class="form-control" name="txtNombre" id="txtNombre" placeholder="Nombre">
                </div>

                <div class="form-group">
                    <label for="txtImagen">Imagen:</label>

                    <?php if($txtImagen!="") { ?>
                        <img class="img-thumbnail rounded" src="../../imgProductos/<?php echo $producto['Imagen_Producto']; ?>" width="50" >
                    <?php } ?>

                    <input type="file" class="form-control" name="txtImagen" id="txtImagen" placeholder="Imagen">
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

<br>

<div class="col-md-12">
    <table class="table table-bordered">
        <thead>
            <tr style="font-size: small;">
                <th style="width: 3%;" id="th-ID">ID</th>
                <th style="width: 14%;" id="th-nombre">Nombre</th>
                <th style="width: 8%;" id="th-precio">Precio</th>
                <th style="width: 8%;" id="th-imagen">Imagen</th>
                <th style="width: 18%;" id="th-descripcion">Descripción</th>
                <th style="width: 10%;" id="th-fecha">Fecha Registro</th>
                <th style="width: 6%;" id="th-stock">Stock</th>
                <th id="th-especificiaciones">Especificaciones</th>
                <th id="th-categoria">Categoria</th>
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

<?php include('../template/pie.php') ?>