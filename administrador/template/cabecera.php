<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location:../index.php');
} else {
    if ($_SESSION['usuario'] == "ok") {
        $nombreUsuario = $_SESSION["nombreUsuario"];
    }
}
?>

<!doctype html>
<html lang="es">

<head>
    <title>Administrador Sportseek</title>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Styles -->
    <link rel="stylesheet" href="./css/styles.css" type="text/css">
</head>

<body>

    <!-- Esto guard una variable con la url del sitio web principal, luego habría que cambiarle el nombre al sitio -->
    <?php $url = "http://" . $_SERVER['HTTP_HOST'] . "/olimpiada" ?>

    <nav class="navbar navbar-expand navbar-light bg-primary">
        <div class="nav navbar-nav">
            <a class="nav-item nav-link text-white" href="#">Administrador del sitio web <span class="sr-only"></span></a>
            <a class="nav-item nav-link text-white" href="<?php echo $url . "/administrador/inicio.php"; ?>">Inicio</a>
            <a class="nav-item nav-link text-white" href="<?php echo $url . "/administrador/seccion/productos.php"; ?>">Productos</a>
            <a class="nav-item nav-link text-white" href="<?php echo $url . "/administrador/seccion/categorias.php"; ?>">Categorias</a>
            <a class="nav-item nav-link text-white" href="<?php echo $url . "/administrador/seccion/cerrar.php"; ?>">Cerrar sesión</a>
            <a class="nav-item nav-link text-white" href="<?php echo $url; ?>">Ver sitio web</a>
        </div>
    </nav>

    <br>