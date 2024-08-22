<?php include('../template/cabecera.php') ?>

<?php

//Recibir los datos del formulario y guardarlo en variables. Si no hay datos se guardan vacías
$txtID = (isset($_POST['txtID']) && preg_match('/^[0-9]+$/', $_POST['txtID'])) ? $_POST['txtID'] : "";
$txtNombre = (isset($_POST['txtNombre']) && preg_match('/^[a-zA-ZnÑáéíóúÁÉÍÓÚ ]+$/',  $_POST['txtNombre'])) ? $_POST['txtNombre'] : "";
$txtDescripcion = (isset($_POST['txtDescripcion']) && preg_match('/^[a-zA-ZnÑáéíóúÁÉÍÓÚ,.0-9 ]+$/',  $_POST['txtDescripcion'])) ? $_POST['txtDescripcion'] : "";
$accion = (isset($_POST['accion']) && preg_match('/^[a-zA-Z]+$/',  $_POST['accion'])) ? $_POST['accion'] : "";

if ($_POST) {
    if (!preg_match('/^[0-9]+$/', $_POST['txtID']) || preg_match('/^[a-zA-ZnÑáéíóúÁÉÍÓÚ ]+$/',  $_POST['txtNombre']) || preg_match('/^[a-zA-ZnÑáéíóúÁÉÍÓÚ,.0-9 ]+$/',  $_POST['txtDescripcion']) || preg_match('/^[a-zA-Z]+$/',  $_POST['accion'])) {
        $mensaje =  "Error en los caracteres de los datos";
    }
}

include("../config/bd.php");

switch ($accion) {
    case "Agregar":
        // Insertar datos a tabla Categorias
        $sentenciaSQL = $conexion->prepare("INSERT INTO Categorias (Nombre_Categoria, Descripcion_Categoria) VALUES (:nombre, :descripcion);");
        $sentenciaSQL->bindParam(':nombre', $txtNombre);
        $sentenciaSQL->bindParam(':descripcion', $txtDescripcion);
        $sentenciaSQL->execute();

        header('Location:categorias.php');
        break;
    case "Modificar":
        $sentenciaSQL = $conexion->prepare("UPDATE Categorias SET Nombre_Categoria=:nombre, Descripcion_Categoria=:descripcion WHERE ID_Categoria=:id");
        $sentenciaSQL->bindParam(':nombre', $txtNombre);
        $sentenciaSQL->bindParam(':descripcion', $txtDescripcion);
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();

        header('Location:categorias.php');
        break;
    case "Cancelar":
        header('Location:categorias.php');
        break;
    case 'Seleccionar':
        $sentenciaSQL = $conexion->prepare("SELECT * FROM Categorias WHERE ID_Categoria=:id");
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();
        $categoria = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

        $txtNombre = $categoria['Nombre_Categoria'];
        $txtDescripcion = $categoria['Descripcion_Categoria'];
        break;
    case 'Borrar':
        // Borrar resto de datos
        $sentenciaSQL = $conexion->prepare("DELETE FROM Categorias WHERE ID_Categoria=:id");
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();

        header('Location:categorias.php');
        break;
}

$sentenciaSQL = $conexion->prepare("SELECT * FROM Categorias");
$sentenciaSQL->execute();
$listaCategorias = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="container">
    <div class="row">
        <div class="col-md-5" id="carga">
            <div class="card">
                <div class="card-header">
                    Datos de la Categoría
                </div>
                <div class="card-body">

                    <form method="POST" enctype="multipart/form-data">
                        <?php if (isset($mensaje)) { ?>
                            <div class="alert alert-danger" role="alert">
                                ⚠️ <?php echo htmlspecialchars($mensaje) ?>
                            </div>
                        <?php } ?>
                        <div class="form-group">
                            <label for="txtID">ID:</label>
                            <input type="text" required readonly value="<?php echo htmlspecialchars($txtID); ?>" class="form-control" name="txtID" id="txtID" placeholder="ID">
                        </div>

                        <div class="form-group">
                            <label for="txtNombre">Nombre:</label>
                            <input type="text" required value="<?php echo htmlspecialchars($txtNombre); ?>" class="form-control" name="txtNombre" id="txtNombre" placeholder="Nombre de la categoría">
                        </div>

                        <div class="form-group" id="div-descripcion">
                            <div class="form-group" id="div-descripcion">
                                <label for="txtDescripcion">Descripción:</label>
                                <textarea maxlength="5000" required class="form-control" name="txtDescripcion" id="txtDescripcion" placeholder="Describe la categoría" rows="5" style="resize: none;"><?php echo $txtDescripcion; ?></textarea>
                            </div>
                        </div>


                        <div class="btn-group" role="group" aria-label="">
                            <button type="submit" name="accion" <?php echo ($accion == "Seleccionar") ? "disabled" : ""; ?> value="Agregar" class="btn btn-success">Agregar</button>
                            <button type="submit" name="accion" <?php echo ($accion != "Seleccionar") ? "disabled" : ""; ?> value="Modificar" class="btn btn-warning">Modificar</button>
                            <button type="submit" name="accion" <?php echo ($accion != "Seleccionar") ? "disabled" : ""; ?> value="Cancelar" class="btn btn-info">Cancelar</button>
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
                    <?php foreach ($listaCategorias as $categoria) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($categoria['ID_Categoria']); ?></td>
                            <td><?php echo htmlspecialchars($categoria['Nombre_Categoria']); ?></td>
                            <td><?php echo htmlspecialchars($categoria['Descripcion_Categoria']); ?></td>

                            <td>
                                <form method="POST">
                                    <input type="hidden" name="txtID" id="txtID" value="<?php echo htmlspecialchars($categoria['ID_Categoria']); ?>">

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