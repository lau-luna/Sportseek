<?php 
session_start();

if($_POST) {
    if(($_POST['usuario']=="tiendaDeportes")&&($_POST['contrasenia']=="sistema")){

        $_SESSION['usuario']="ok";
        $_SESSION['nombreUsuario']="Tienda Deportes";

        header('Location:inicio.php');
    } else {
        $mensaje="Error: El nombre de usuario o contraseña es incorrecto";
    }
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
                        
                        <?php if(isset($mensaje)) { ?>
                            <div class="alert alert-danger" role="alert">
                                ⚠️ <?php echo  $mensaje ?>
                            </div>
                        <?php } ?>

                        <form method="POST">
                        <div class = "form-group">
                        
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