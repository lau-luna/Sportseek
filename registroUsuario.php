<?php include('template/cabecera.php'); ?>

<?php
if ($_POST) {

    // Extraer de la bd una lista con todos los usuarios
    $sentenciaSQL = $conexion->prepare("SELECT * FROM Usuarios WHERE Email_Usuario LIKE :email");
    $sentenciaSQL->bindParam(':email', $_POST['txtEmail']);
    $sentenciaSQL->execute();
    $listaUsuarios = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    $emailResgistrado = false;

    // Recorrer arreglo de usuarios
    foreach ($listaUsuarios as $usuario) {
        // Revisar si el usuario está registrado
        if (isset($usuario['Email_Usuario'])) {
            $mensaje = "Este correo ya está registrado.";
            $emailResgistrado = true;
        }
    }

    if (!$emailResgistrado) {
        //Recibir los datos del formulario y guardarlo en variables. Si no hay datos se guardan vacías
        $txtUsername = (isset($_POST['txtUsername'])) ? $_POST['txtUsername'] : "";
        $txtNombreUsuario = (isset($_POST['txtNombre'])) ? $_POST['txtNombre'] : "";
        $txtApellidosUsuario = (isset($_POST['txtApellidos'])) ? $_POST['txtApellidos'] : "";
        $txtDni = (isset($_POST['txtDni'])) ? $_POST['txtDni'] : "";
        $txtEmail = (isset($_POST['txtEmail'])) ? $_POST['txtEmail'] : "";
        $txtContrasenia = (isset($_POST['txtContrasenia'])) ? $_POST['txtContrasenia'] : "";
        $txtDireccion = (isset($_POST['txtDireccion'])) ? $_POST['txtDireccion'] : "";
        $txtTelefono = (isset($_POST['txtTelefono'])) ? $_POST['txtTelefono'] : "";
        $txtIdProvincia = (isset($_POST['txtProvincia'])) ? $_POST['txtProvincia'] : "";
        $txtLocalidad = (isset($_POST['txtLocalidad'])) ? $_POST['txtLocalidad'] : "";


        // Extraer sos
        $sentenciaSQL = $conexion->prepare("SELECT * FROM Localidades WHERE Provincias_ID_Provincia=:IdProvincia AND Nombre_Localidad LIKE :nombreLocalidad ");
        $sentenciaSQL->bindParam(':IdProvincia', $txtIdProvincia);
        $sentenciaSQL->bindParam(':nombreLocalidad', $txtLocalidad);
        $sentenciaSQL->execute();
        $listaLocalidades = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

        $seEncontroLocalidad = false;

        foreach ($listaLocalidades as $localidad) {
            if (isset($localidad['Nombre_Localidad'])) {
                $txtIdLocalidad = $localidad['ID_Localidades'];
                $seEncontroLocalidad = true;
            }
        }

        if (!$seEncontroLocalidad) {
            $sentenciaSQL = $conexion->prepare("INSERT INTO Localidades (Nombre_Localidad, Provincias_ID_Provincia) VALUES (:NombreLocalidad, :IdProvincia); ");
            $sentenciaSQL->bindParam(':NombreLocalidad', $txtLocalidad);
            $sentenciaSQL->bindParam(':IdProvincia', $txtIdProvincia);
            $sentenciaSQL->execute();

            $sentenciaSQL = $conexion->prepare("SELECT ID_Localidades FROM Localidades WHERE Nombre_Localidad=:NombreLocalidad");
            $sentenciaSQL->bindParam(':NombreLocalidad', $txtLocalidad);
            $sentenciaSQL->execute();
            $localidad = $sentenciaSQL->fetch(PDO::FETCH_LAZY);
            $txtIdLocalidad =  $localidad['ID_Localidades'];
        }


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
        <h3 class="fw-normal " style="letter-spacing: 1px;">Nueva Cuenta</h3>
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
                    <hr>
                    
                        <label class="form-label" style="font-size:small;">Nombre</label>
                        <input type="text" name="txtNombre" required class="form-control form-control-md" />
                    
                        <label class="form-label" style="font-size:small;">Apellidos</label>
                        <input type="text" name="txtApellidos" required class="form-control form-control-md" />

                    <div id="div-dni-telefono" style="padding-top: 2.5vh;">
                            <div class="DNI">
                            <label class="form-label" style="font-size:small; padding-right: 1vh;" >DNI</label>
                            <input type="text" name="txtDni" required class="form-control" />
                            </div>
                            <div class="Telefono">
                            <label class="form-label" style="font-size:small; padding-right: 1vh;">Telefono</label>
                            <input type="text" name="txtTelefono" required class="form-control" />
                            </div>
                        
                            
                        
                    </div>
                        <label class="form-label" style="font-size:small;">Dirección</label>
                        <input type="text" name="txtDireccion" required class="form-control form-control-md" style="margin-bottom: 2.5vh;"/>
                    <div id="div-provincia-localidad">
                        <div class="Provincia">
                        <label class="form-label" style="font-size:small; padding-right: 1vh;">Provincia</label>
                            <select name="txtProvincia" id="provincia" class="form-control" required>
                                <?php
                                $sentenciaSQL = $conexion->prepare("SELECT * FROM Provincias");
                                $sentenciaSQL->execute();
                                $listaProvincias = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($listaProvincias as $provincia) {
                                ?>
                                    <option value="<?php echo $provincia['ID_Provincia'] ?>"><?php echo $provincia['Nombre_Provincia'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="Localidad">
                        <label class="form-label" style="font-size:small; padding-right: 1vh;">Localidad</label>
                        <input type="text" name="txtLocalidad" required class="form-control" />
                        </div>
                            
                        
                    </div>

                </div>
                <div id="informacion-inicio-sesion">
                    <h3 class="fw-normal " style="font-size:small;">Informacion de Inicio de Sesion</h3>
                    <hr>
                    <label class="form-label" style="font-size:small;">Nombre de Usuario</label>
                    <br>
                    <input type="text" name="txtUsername" required class="form-control form-control-md" />



                    <label class="form-label" style="font-size:small;">Correo electrónico</label>
                    <input type="email" name="txtEmail" required class="form-control form-control-md" />

                    <div data-mdb-input-init class="form-outline mb-2">
                <label class="form-label" style="font-size:small;" for="form2Example28">Contraseña</label>
                <div class="containerr">
                    <input type="password" name="contrasenia" id="contrasenia" class="form-control form-control-md" />

                    <i class="bx bx-show-alt"></i>
                    </div>
                </div>


                    <div id="btn-registro">
                        <button data-mdb-button-init data-mdb-ripple-init class="btn btn-info btn-md btn-block" type="submit">Ingresar</button>
                    </div>

                    <p>Ya tiene una cuenta? <a href="./loginUsuario.php" class="link-info">Inicie sesión aquí</a></p>
                </div>



            </div>

        </form>
    </div>
</section>
<script src="./js/ContraOcultar.js"></script>




<?php include('template/pie.php'); ?>