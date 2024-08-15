<?php

include('config/bd.php');


session_start();



if ($_POST) {
    //
    $sentenciaSQL = $conexion->prepare("SELECT * FROM Usuarios");
    $sentenciaSQL->execute();
    $listaUsuarios = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    foreach ($listaUsuarios as $usuario) {
        if ($_POST['usuario'] == $usuario['Nombre_Usuario']) {
            if (($_POST['contrasenia'] == $usuario['Contrasenia_Usuario'])) {

                $sentenciaSQL= $conexion->prepare("SELECT * FROM Tipos_de_Usuario WHERE ID_Usuario=:id");
                $sentenciaSQL->bindParam(':id',$usuario['ID_Usuario']);
                $sentenciaSQL->execute();
                $tipoUsuario=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

                echo $tipoUsuario['Tipo_de_Usuario'];

                $_SESSION['usuario'] = "ok";
                $_SESSION['nombreUsuario'] = "Tienda Deportes";
        
                header('Location:inicio.php');
            } else {
                $mensaje = "Error: El nombre de usuario o contraseña es incorrecto";
            }
        } else {
            $mensaje = "No se encontró el usuario.";
        }
    }





    /*
    
    */
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
</head>

<body>
    <div class="container">
        <br> <br> <br> <br> <br> <br>
        <div class="row" id="container-login">

            <div class="col-md-4">

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            Login
                        </div>
                        <div class="card-body">

                            <?php if (isset($mensaje)) { ?>
                                <div class="alert alert-danger" role="alert">
                                    ⚠️ <?php echo  $mensaje ?>
                                </div>
                            <?php } ?>

                            <form method="POST">
                                <div class="form-group">

                                    <label for="exampleInputEmail1">Usuario</label>

                                    <input type="text" name="usuario" class="form-control" id="exampleInputEmail1" placeholder="Escribe tu usuario">

                                </div>
                                <br>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Contraseña:</label>
                                    <input type="password" name="contrasenia" class="form-control" id="exampleInputPassword1" placeholder="Escribe tu contraseña">
                                </div>
                                <br>
                                <button type="submit" class="btn btn-primary">Iniciar sesion</button>
                            </form>


                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</body>

</html>