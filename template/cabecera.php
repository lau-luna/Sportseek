<?php

include('./administrador/config/bd.php');

if (isset($_SERVER['sesionIniciada']) && !$_SERVER['sesionIniciada']) {
} else {
    $_SERVER['sesionIniciada'] = true;
    session_start();
}

// Establecer la zona horaria de Argentina
date_default_timezone_set('America/Argentina/Buenos_Aires');

ini_set('memory_limit', '500M');
ini_set('max_execution_time', '60');
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <title>Sportseek</title>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <!-- Bootstrap CSS -->

    <!-- BoxIcons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Styles -->
    <link rel="stylesheet" href="./bootstrap/bootstrap.css" type="text/css">


    <link rel="stylesheet" href="./css/styles.css" type="text/css">
    <link rel="stylesheet" href="./css/loginUsuario.css" type="text/css">
    <link rel="stylesheet" href="./css/registroUsuario.css" type="text/css">
    <link rel="stylesheet" href="css/productoLista.css" type="text/css">
    <link rel="icon" href="./img/LogoTiendaIconVersion.png" type="image/x-icon">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

</head>

<?


?>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script type="text/javascript" src="Scripts/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="Scripts/bootstrap.min.js"></script>


    <div style="position: fixed; width: 100%; z-index: 999;">
        <header class="d-flex" style="background-color: white;">
            <a class="nav-link" href="index.php">
                <img src="./img/LogoTiendaHeader.png" alt="Deportes" width="150">
                <span class="sr-only"></span>
            </a>

            <form method="GET" action="productos.php" class="form-inline" id="formulario-busqueda-productos">
                <input class="form-control" name="busqueda" type="text" placeholder="¿Qué estás buscando?">
                <button class="btn btn-primary" type="submit" style="display: flex; align-items: center; justify-content: center; padding: 0.39rem;">
                    <img src="./img/logoBuscador.png" style="height: 1.5rem; width: auto;" />
                </button>
            </form>

            <!-- Contenedor que empuja los botones hacia la derecha -->
            <div class="ml-auto d-flex" id="contenedor-botones-registro-carrito">
                <!-- Mostar sólo si no se inció la sessión-->
                <?php if (!isset($_SESSION['usuario'])) { ?>
                    <a class="form-inline my-2 my-lg-0" href="loginUsuario.php">
                        <button class="btn btn-outline-secondary my-2 my-sm-0" type="submit">INGRESÁ O REGISTRATE</button>
                    </a>
                <?php } ?>

                <!-- Mostar sólo se se inció la sessión-->
                <?php if (isset($_SESSION['usuario'])) { ?>
                    <a class="form-inline my-2 my-lg-0" href="./carrito.php">
                        <button class="btn btn-outline-info my-2 my-sm-0" type="submit">
                            <img src="./img/CarritoIcon.png" alt="Carrito" class="btn-img" style="height: 4vh; vertical-align: middle; margin-right: 5px;">
                            MI CARRITO
                        </button>
                    </a>
                <?php } ?>

                <!-- Mostar sólo se se inció la sessión-->
                <?php if (isset($_SESSION['usuario'])) { ?>
                    <!-- Example single danger button -->
                    <div class="form-inline my-2 my-lg-0">
                        <button type="button" class="btn btn-outline-success dropdown-toggle" data-bs-toggle='dropdown' aria-haspopup="true" aria-expanded="false">
                            <img src="./img/CuentaIcon.png" alt="Cuenta" class="btn-img" style="height: 4vh; vertical-align: middle; margin-right: 5px;">
                            MI CUENTA
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="miCuenta.php">Ver mis datos</a>
                            <?php if ($_SESSION['Tipo_Usuario'] == 'Administrador') { ?>
                                <a class="dropdown-item" href="administrador/inicio.php">Administrar sitio</a>
                            <?php } ?>
                            <a class="dropdown-item" href="listaPedidos.php">Pedidos</a>
                            <a class="dropdown-item" href="listaFacturas.php">Facturas</a>

                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="./config/procesar.php?accion=cerrarsesion">Cerrar Sesión</a>
                        </div>
                    </div>
                <?php } ?>

            </div>

        </header>

        <nav class="navbar navbar-expand-lg navbar-light bg-primary justify-content-center d-flex">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse d-flex justify-content-center" id="navbarNavDropdown">
                <ul class="navbar-nav d-flex justify-content-center">
                    <li class="nav-item active">
                        <a class="nav-link text-white text-center" href="./index.php">Inicio <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white text-center" href="./productos.php">Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white text-center" href="contacto.php">Contacto</a>
                    </li>
                </ul>
            </div>
        </nav>

    </div>

    <div class="contenedor">

        <br> <br> <br> <br> <br>