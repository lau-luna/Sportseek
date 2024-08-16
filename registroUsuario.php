<?php include('template/cabecera.php'); ?>

<?php
if ($_POST) {

    // Extraer de la bd una lista con todos los usuarios
    $sentenciaSQL = $conexion->prepare("SELECT * FROM Usuarios");
    $sentenciaSQL->execute();
    $listaUsuarios = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    // Recorrer arreglo de usuarios
    foreach ($listaUsuarios as $usuario) {
        // Revisar si el usuario está registrado
        if ($_POST['txtEmail'] == $usuario['Email_Usuario']) {

            $mensaje = "Este correo ya está registrado.";
        }
        //Recibir los datos del formulario y guardarlo en variables. Si no hay datos se guardan vacías
        $txtUsername = (isset($_POST['txtUsername'])) ? $_POST['txtUsername'] : "";
        $txtNombreUsuario = (isset($_POST['txtNombre'])) ? $_POST['txtNombre'] : "";
        $txtApellidosUsuario = (isset($_POST['txtApellidos'])) ? $_POST['txtApellidos'] : "";
        $txtDni = (isset($_POST['txtDni'])) ? $_POST['txtDni'] : "";
        $txtEmail = (isset($_POST['txtEmail'])) ? $_POST['txtEmail'] : "";
        $txtContrasenia = (isset($_POST['txtContrasenia'])) ? $_POST['txtContrasenia'] : "";
        $txtDireccion = (isset($_POST['txtDireccion'])) ? $_POST['txtDireccion'] : "";
        $txtTelefono = (isset($_POST['txtTelefono'])) ? $_POST['txtTelefono'] : "";
        $txtIdLocalidad = (isset($_POST['txtLocalidad'])) ? $_POST['txtLocalidad'] : "";

        

        // Insertar datos a tabla Usuarios
        $sentenciaSQL = $conexion->prepare("INSERT INTO Usuarios (Username_Usuario, Nombre_Usuario, Apellidos_Usuario, 
        DNI_Usuario, Email_Usuario, Contrasenia_Usuario, Direccion_Usuario, Telefono_Usuario, Tipos_de_Usuario_ID_Tipos_de_Usuario, Localidades_ID_Localidades) 
        VALUES (:username, :nombre_usuario, :apellidos_usuario, :dni, :email, :contrasenia, :direccion, :telefono, :tipo_usuario, :id_localidad);");
        // Ejecutar la consulta con los valores proporcionados
        $sentenciaSQL->execute([
            ':username' => $txtUsername,
            ':nombre_usuario' => $txtNombreUsuario,
            ':apellidos_usuario' => $txtApellidosUsuario,
            ':dni' => $txtDni,
            ':email' => $txtEmail,
            ':contrasenia' => $txtContrasenia,
            ':direccion' => $txtDireccion,
            ':telefono' => $txtTelefono,
            ':tipo_usuario' => 2,
            ':id_localidad' => $txtIdLocalidad
        ]);


        header('Location:loginUsuario.php');
    }
}

?>

<section class="seccion-registro-usuario">
    <div class="registroUsuario">
        <h3 class="fw-normal " style="letter-spacing: 1px;">Iniciar Sesión</h3>
        <hr class="mb-2">
        <form method="POST">
            <?php if (isset($mensaje)) { ?>
                <div class="alert alert-danger" role="alert">
                    ⚠️ <?php echo  $mensaje ?>
                </div>
            <?php } ?>
            <div class="d-flex">
                <div id="informacion-personal">
                    <h3 class="fw-normal " style="font-size:small">Informacion Personal</h3>
                    <hr class="mb-2">
                    <div data-mdb-input-init class="form-outline mb-2">
                        <label class="form-label" style="font-size:small;" for="form2Example18">Nombre</label>
                        <input type="text" name="txtNombre" id="form2Example18" class="form-control form-control-md" />
                    </div>

                    <div data-mdb-input-init class="form-outline mb-2">
                        <label class="form-label" style="font-size:small;" for="form2Example28">Apellidos</label>
                        <input type="text" name="txtApellidos" id="form2Example28" class="form-control form-control-md" />
                    </div>

                    <div data-mdb-input-init class="form-outline mb-2">
                        <label class="form-label" style="font-size:small;" for="form2Example28">DNI</label>
                        <input type="text" name="txtDni" id="form2Example28" class="form-control form-control-md" />
                    </div>

                    <div data-mdb-input-init class="form-outline mb-2">
                        <label class="form-label" style="font-size:small;" for="form2Example28">Dirección</label>
                        <input type="text" name="txtDireccion" id="form2Example28" class="form-control form-control-md" />
                    </div>

                    <div data-mdb-input-init class="form-outline mb-2">
                        <label class="form-label" style="font-size:small;" for="form2Example28">Telefono</label>
                        <input type="text" name="txtTelefono" id="form2Example28" class="form-control form-control-md" />
                    </div>

                    <div data-mdb-input-init class="form-outline mb-2">
                        <label class="form-label" style="font-size:small;" for="form2Example28">Localidad</label>

                        <select name="txtLocalidad">
                            <?php // Extraer de la bd una lista con todos los usuarios
                            $sentenciaSQL = $conexion->prepare("SELECT * FROM Localidades");
                            $sentenciaSQL->execute();
                            $listaLocalidades = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($listaLocalidades as $localidad) {
                            ?>
                                <option value="<?php echo $localidad['ID_Localidades'] ?>"><?php echo $localidad['Nombre_Localidad'] ?></option>

                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div id="informacion-inicio-sesion">
                    <h3 class="fw-normal " style="font-size:small;">Informacion de Inicio de Sesion</h3>
                    <hr class="mb-2">
                    <div data-mdb-input-init class="form-outline mb-2">
                        <label class="form-label" style="font-size:small;" for="form2Example18">Nombre de Usuario</label>
                        <input type="text" name="txtUsername" id="form2Example18" class="form-control form-control-md" />
                    </div>

                    <div data-mdb-input-init class="form-outline mb-2">
                        <label class="form-label" style="font-size:small;" for="form2Example18">Correo electrónico</label>
                        <input type="email" name="txtEmail" id="form2Example18" class="form-control form-control-md" />
                    </div>

                    <div data-mdb-input-init class="form-outline mb-2">
                        <label class="form-label" style="font-size:small;" for="form2Example28">Contraseña</label>
                        <input type="password" name="txtContrasenia" id="form2Example28" class="form-control form-control-md" />
                    </div>
                </div>
            </div>





            <div id="btn-registro">
                <button data-mdb-button-init data-mdb-ripple-init class="btn btn-info btn-md btn-block" type="submit">Ingresar</button>
            </div>

            <p class="small mb-3 pb-lg-2"><a class="text-muted" href="#!">Olvidé mi contraseña</a></p>
            <p>Ya tiene una cuenta? <a href="./loginUsuario.php" class="link-info">Inicie sesión aquí</a></p>
        </form>
    </div>
</section>


<?php include('template/pie.php'); ?>