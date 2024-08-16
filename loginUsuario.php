<?php include('template/cabecera.php');

if ($_POST) {
    // Extraer de la bd una lista con todos los usuarios
    $sentenciaSQL = $conexion->prepare("SELECT * FROM Usuarios");
    $sentenciaSQL->execute();
    $listaUsuarios = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    // Recorrer arreglo de usuarios
    foreach ($listaUsuarios as $usuario) {
        // Revisar si el usuario está registrado
        if ($_POST['email'] == $usuario['Email_Usuario']) {

            // Revisar si la contraseña es correcta
            if (($_POST['contrasenia'] == $usuario['Contrasenia_Usuario'])) {

                // Revisar si tiene cuenta de Cliente
                $sentenciaSQL = $conexion->prepare("SELECT Usuarios.Username_Usuario, Tipos_de_Usuario.Tipo_de_Usuario
                    FROM Usuarios
                    INNER JOIN Tipos_de_Usuario ON Usuarios.Tipos_de_Usuario_ID_Tipos_de_Usuario = Tipos_de_Usuario.ID_Tipos_de_Usuario WHERE Usuarios.ID_Usuario=:ID;");
                $sentenciaSQL->bindParam(':ID', $usuario['ID_Usuario']);
                $sentenciaSQL->execute();
                $lista2 = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

                if ($lista2['Tipo_de_Usuario'] == "Cliente") {

                    $_SESSION['usuario'] = "ok";
                    $_SESSION['nombreUsuario'] = $usuario['Nombre_Usuario'];
                    $_SESSION['Apellido_Usuario'] = $usuario['Apellido_Usuario'];
                    $_SESSION['ID_Usuario'] = $usuario['ID_Usuario'];

                    header('Location:index.php');
                } else {
                    $mensaje = "Su cuenta no es de tipo Cliente.";
                }
            } else {
                $mensaje = "El nombre de usuario o contraseña es incorrecto.";
            }
        } else {
            $mensaje = "No se encontró el usuario.";
        }
    }
}


?>


<section class="seccion-login">
    <div>
        <div class="d-flex align-items-center">

            <form method="POST" id="iniciarSesionForm">
                <h3 class="fw-normal " style="letter-spacing: 1px;">Iniciar Sesión</h3>
                <hr class="mb-2">
                <p class="mb-4 text-muted" style="font-size:smaller;">Si tiene una cuenta, inicie sesión con su dirección de correo electrónico.</p>

                <?php if (isset($mensaje)) { ?>
                    <div class="alert alert-danger" role="alert">
                        ⚠️ <?php echo  $mensaje ?>
                    </div>
                <?php } ?>

                <div data-mdb-input-init class="form-outline mb-2">
                    <input type="email" name="email" id="form2Example18" class="form-control form-control-md" />
                    <label class="form-label" style="font-size:small;" for="form2Example18">Correo electrónico</label>
                </div>

                <div data-mdb-input-init class="form-outline mb-2">
                    <input type="password" name="contrasenia" id="form2Example28" class="form-control form-control-md" />
                    <label class="form-label" style="font-size:small;" for="form2Example28">Contraseña</label>
                </div>

                <div class="pt-1 mb-2">
                    <button data-mdb-button-init data-mdb-ripple-init class="btn btn-info btn-md btn-block" type="submit">Ingresar</button>
                </div>

                <p class="small mb-3 pb-lg-2"><a class="text-muted" href="#!">Olvidé mi contraseña</a></p>
                <p>No tiene una cuenta? <a href="./registroUsuario.php" class="link-info">Regístrese aquí</a></p>
            </form>
        </div>

    </div>
</section>
<div class="imgIniciarSesion">
        <img src="./img/lionel-messi.2183aef8.jpg"
            alt="Login image" style="object-fit: cover; object-position: left;">
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <?php include("template/pie.php") ?>