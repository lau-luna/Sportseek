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
    <link rel="stylesheet" href="../../css/styles.css" type="text/css">
    <link rel="stylesheet" href="../../administrador.css" type="text/css">
    <link rel="stylesheet" href="../../css/styles.css" type="text/css">
    <link rel="stylesheet" href="../../css/loginUsuario.css" type="text/css">
    <link rel="stylesheet" href="../../css/registroUsuario.css" type="text/css">
    <link rel="icon" href="../../img/LogoTiendaIconVersion.png" type="image/x-icon">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script type="text/javascript" src="Scripts/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="Scripts/bootstrap.min.js"></script>

    <!-- Esto guard una variable con la url del sitio web principal, luego habría que cambiarle el nombre al sitio -->
    <?php $url = "http://" . $_SERVER['HTTP_HOST'] . "" ?>

    <nav class="navbar navbar-expand-lg navbar-light bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="#">Administrador del sitio web</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-item nav-link text-white" href="<?php echo $url . "/administrador/index.php"; ?>">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-item nav-link text-white" href="<?php echo $url . "/administrador/seccion/productos.php"; ?>">Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-item nav-link text-white" href="<?php echo $url . "/administrador/seccion/categorias.php"; ?>">Categorias</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-item nav-link text-white" href="<?php echo $url . "/administrador/seccion/listaPedidos.php"; ?>">Pedidos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-item nav-link text-white" href="<?php echo $url . "/administrador/seccion/listaFacturas.php"; ?>">Facturas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-item nav-link text-white" href="<?php echo $url; ?>">Ver sitio web</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-item nav-link text-white" href="<?php echo $url . "/administrador/seccion/cerrar.php"; ?>">Cerrar sesión</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <br>