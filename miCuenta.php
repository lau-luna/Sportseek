<?php include('template/cabecera.php'); ?>

<?php
// Extraer de la bd una lista con todos los usuarios
$sentenciaSQL = $conexion->prepare("SELECT * FROM Usuarios WHERE ID_Usuario=:ID");
$sentenciaSQL->bindParam(':ID', $_SESSION['ID_Usuario']);
$sentenciaSQL->execute();
$usuario = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

$txtUsername = $usuario['Username_Usuario'];
$txtNombreUsuario = $usuario['Nombre_Usuario'];
$txtApellidosUsuario = $usuario['Apellidos_Usuario'];
$txtDni = $usuario['DNI_Usuario'];
$txtEmail = $usuario['Email_Usuario'];
$txtContrasenia = ''; // Dejar vacío para no mostrar la contraseña
$txtDireccion = $usuario['Direccion_Usuario'];
$txtTelefono = $usuario['Telefono_Usuario'];
$txtIdProvincia = (isset($_POST['txtProvincia'])) ? $_POST['txtProvincia'] : $usuario['Provincias_ID_Provincia'];
$txtLocalidad = (isset($_POST['txtLocalidad'])) ? $_POST['txtLocalidad'] : $usuario['Localidades_ID_Localidades'];

// Obtener la localidad y provincia asociada
$sentenciaSQL = $conexion->prepare("SELECT * FROM Localidades INNER JOIN Provincias ON Localidades.Provincias_ID_Provincia=Provincias.ID_Provincia WHERE Localidades.ID_Localidades=:IdLocalidad");
$sentenciaSQL->bindParam(":IdLocalidad", $txtLocalidad);
$sentenciaSQL->execute();
$localidadProvincia = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);

if ($_POST) {
    // Verificar si el correo electrónico ya está registrado
    $sentenciaSQL = $conexion->prepare("SELECT * FROM Usuarios WHERE Email_Usuario = :email AND ID_Usuario != :id_usuario");
    $sentenciaSQL->bindParam(':email', $_POST['txtEmail']);
    $sentenciaSQL->bindParam(':id_usuario', $_SESSION['ID_Usuario']);
    $sentenciaSQL->execute();
    $emailRegistrado = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);

    if ($emailRegistrado) {
        $mensaje = "Este correo ya está registrado.";
    } else {
        // Recibir los datos del formulario y guardarlos en variables
        $txtUsername = $_POST['txtUsername'];
        $txtNombreUsuario = $_POST['txtNombre'];
        $txtApellidosUsuario = $_POST['txtApellidos'];
        $txtDni = $_POST['txtDni'];
        $txtEmail = $_POST['txtEmail'];
        $txtContrasenia = $_POST['txtContrasenia'];
        $txtDireccion = $_POST['txtDireccion'];
        $txtTelefono = $_POST['txtTelefono'];
        $txtIdProvincia = $_POST['txtProvincia'];
        $txtLocalidad = $_POST['txtLocalidad'];

        // Verificar la localidad
        $sentenciaSQL = $conexion->prepare("SELECT * FROM Localidades WHERE Provincias_ID_Provincia = :IdProvincia AND Nombre_Localidad = :nombreLocalidad");
        $sentenciaSQL->bindParam(':IdProvincia', $txtIdProvincia);
        $sentenciaSQL->bindParam(':nombreLocalidad', $txtLocalidad);
        $sentenciaSQL->execute();
        $localidad = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);

        if ($localidad) {
            $txtIdLocalidad = $localidad['ID_Localidades'];
        } else {
            // Insertar nueva localidad
            $sentenciaSQL = $conexion->prepare("INSERT INTO Localidades (Nombre_Localidad, Provincias_ID_Provincia) VALUES (:NombreLocalidad, :IdProvincia)");
            $sentenciaSQL->bindParam(':NombreLocalidad', $txtLocalidad);
            $sentenciaSQL->bindParam(':IdProvincia', $txtIdProvincia);
            $sentenciaSQL->execute();
            $txtIdLocalidad = $conexion->lastInsertId();
        }

        // Actualizar datos del usuario
        $sentenciaSQL = $conexion->prepare("UPDATE Usuarios SET 
            Username_Usuario = :username, 
            Nombre_Usuario = :nombre_usuario, 
            Apellidos_Usuario = :apellidos_usuario, 
            DNI_Usuario = :dni, 
            Email_Usuario = :email, 
            Contrasenia_Usuario = :txtcontrasenia, 
            Direccion_Usuario = :direccion, 
            Telefono_Usuario = :telefono, 
            Localidades_ID_Localidades = :id_localidad 
            WHERE ID_Usuario = :id_usuario");

        $sentenciaSQL->execute([
            ':username' => $txtUsername,
            ':nombre_usuario' => $txtNombreUsuario,
            ':apellidos_usuario' => $txtApellidosUsuario,
            ':dni' => $txtDni,
            ':email' => $txtEmail,
            ':txtcontrasenia' => $txtContrasenia, // Mantener la contraseña vacía si no se va a cambiar
            ':direccion' => $txtDireccion,
            ':telefono' => $txtTelefono,
            ':id_localidad' => $txtIdLocalidad,
            ':id_usuario' => $_SESSION['ID_Usuario']
        ]);
    }
}
?>

<form action="" method="post">
    <div class="container rounded bg-white mb-5">
        <div class="row">
            <div class="col-md-3 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                    <img class="rounded-circle mt-5" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg" alt="Foto de perfil">
                    <span class="font-weight-bold"> <?php echo htmlspecialchars($usuario['Username_Usuario']); ?> </span>
                    <span class="text-black-50"> <?php echo htmlspecialchars($usuario['Email_Usuario']); ?> </span>
                    <?php if ($usuario['Tipos_de_Usuario_ID_Tipos_de_Usuario'] == 1) { ?>
                        <div class="alert alert-info mt-2"> <?php echo htmlspecialchars("Administrador"); ?> </div>
                    <?php } ?>
                </div>
            </div>

            <div class="col-md-5 border-right">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between mb-3">
                        <h4 class="text-right">Datos personales</h4>
                        <hr style="margin-top: 0.5%; margin-bottom: 1%;">
                    </div>
                    <hr>
                    <div data-mdb-input-init class="form-outline mb-2">
                        <label class="form-label" style="font-size:small;">Nombre</label>
                        <input style="width: 100%;" type="text" value="<?php echo htmlspecialchars($txtNombreUsuario); ?>" name="txtNombre" required class="form-control form-control-md" />
                    </div>

                    <div data-mdb-input-init class="form-outline mb-2">
                        <label class="form-label" style="font-size:small;">Apellidos</label>
                        <input style="width: 100%;" type="text" value="<?php echo htmlspecialchars($txtApellidosUsuario); ?>" name="txtApellidos" required class="form-control form-control-md" />
                    </div>

                    <div id="div-dni-telefono">
                        <div data-mdb-input-init class="DNI mb-2">
                            <label class="form-label" style="font-size:small;">DNI</label>
                            <input type="text" value="<?php echo htmlspecialchars($txtDni); ?>" name="txtDni" required class="form-control" />
                        </div>

                        <div data-mdb-input-init class="Telefono mb-2">
                            <label class="form-label" style="font-size:small;">Telefono</label>
                            <input type="text" value="<?php echo htmlspecialchars($txtTelefono); ?>" name="txtTelefono" required class="form-control" />
                        </div>
                    </div>

                    <div data-mdb-input-init class="form-outline mb-2">
                        <label class="form-label" style="font-size:small;">Dirección</label>
                        <input style="width: 100%;" type="text" value="<?php echo htmlspecialchars($txtDireccion); ?>" name="txtDireccion" required class="form-control form-control-md" />
                    </div>

                    

                    <div class="form-group mb-2">
                        <label class="form-label" style="font-size:small;">Provincia</label>
                        <select name="txtProvincia" class="form-control">
                            <option value="">Seleccionar Provincia</option>
                            <?php
                            $consultaProvincias = $conexion->prepare("SELECT * FROM Provincias");
                            $consultaProvincias->execute();
                            $provincias = $consultaProvincias->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($provincias as $provincia) {
                            ?>
                                <option value="<?php echo $provincia['ID_Provincia']; ?>" <?php echo ($txtIdProvincia == $provincia['ID_Provincia']) ? 'selected' : ''; ?>>
                                    <?php echo $provincia['Nombre_Provincia']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div data-mdb-input-init class="Localidad mb-2">
                        <label class="form-label" style="font-size:small;">Localidad</label>
                        <input type="text" value="<?php echo htmlspecialchars($txtLocalidad); ?>" name="txtLocalidad" required class="form-control" />
                    </div>
                </div>

                

                
            </div>

            <div class="col-md-4">
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-between mb-3">
                            <h4 class="text-right">Datos de la cuenta</h4>
                        </div>
                        <hr style="margin-top: 0.5%;">

                        <div data-mdb-input-init class="form-outline mb-2">
                        <label class="form-label" style="font-size:small;">Nombre de Usuario</label>
                        <input style="width: 100%;" type="text" value="<?php echo htmlspecialchars($txtUsername); ?>" name="txtUsername" required class="form-control form-control-md" />
                    </div>

                    <div data-mdb-input-init class="form-outline mb-2">
                        <label class="form-label" style="font-size:small;">Correo electrónico</label>
                        <input style="width: 100%;" type="email" value="<?php echo htmlspecialchars($txtEmail); ?>" name="txtEmail" required class="form-control form-control-md" />
                    </div>

                    <div data-mdb-input-init class="form-outline mb-2">
                        <label class="form-label" style="font-size:small;">Contraseña (dejar vacío si no deseas cambiarla)</label>
                        <input type="password" value="<?php echo htmlspecialchars($txtContrasenia); ?>" name="txtContrasenia" class="form-control" />
                    </div>

                        <div id="btn-registro">
                            <button data-mdb-button-init data-mdb-ripple-init class="btn btn-info btn-md btn-block" type="submit">Guardar cambios</button>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</form>

<?php include('template/pie.php'); ?>