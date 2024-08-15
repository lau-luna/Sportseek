<!DOCTYPE html>
<html lang="es">

<head>
    <title>Tienda de deportes</title>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Styles -->
    <link rel="stylesheet" href="./css/styles.css" type="text/css">
    <link rel="stylesheet" href="./css/loginUsuario.css" type="text/css">

</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <div style="position: fixed; width: 100%; z-index: 999;">
    <header class="d-flex" style="background-color: white;">
            <a class="nav-link" href="index.php">
                <img src="./img/solodeportes.png" alt="Deportes" width="125">
                <span class="sr-only"></span>
            </a>

            <form class="form-inline " id="formulario-busqueda-productos">
                <input class="form-control" type="text" placeholder="¿Qué estás buscando?">
                <button class="btn btn-primary" type="submit">🔎</button>
            </form>

            <!-- Contenedor que empuja los botones hacia la derecha -->
            <div class="ml-auto d-flex" id="contenedor-botones-registro-carrito">
                <a class="form-inline my-2 my-lg-0" href="loginUsuario.php">
                    <button class="btn btn-outline-secondary my-2 my-sm-0" type="submit">INGRESÁ O REGISTRATE ></button>
                </a>

                <a class="form-inline my-2 my-lg-0" href="index.php">
                    <button class="btn btn-outline-info my-2 my-sm-0" type="submit">🛒 MI CARRITO</button>
                </a>
            </div>

        </header>

        <nav class="navbar navbar-expand-lg navbar-light bg-primary">

            <div class="collapse navbar-collapse" id="collapsibleNavId">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">

                    <li class="nav-item">
                        <a class="nav-link text-white" href="./productos.php">PRODUCTOS</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white" href="contacto.php">CONTACTO</a>
                    </li>

                </ul>


            </div>
        </nav>
    </div>



    <div class="container">
        <br> <br> <br>
        <div class="row" style="margin-top: 6%;">