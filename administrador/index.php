<?php include('template/cabecera.php') ?>

            <div class="col-md-12">
                <div class="jumbotron">
                    <h1 class="display-3">Bienvenido, <?php echo $_SESSION['nombreUsuario'] ?></h1>
                    <p class="lead">Este es el apartado de administración del sitio web.</p>
                    <hr class="my-2">
                    <p>Ayuda en el manual de usuario</p>
                    <p class="lead">
                        <a class="btn btn-primary btn-lg" href="https://docs.google.com/document/d/1JBjGBq4Kms9aHjZihXW_bNV5beE2SI_75tImMxC1bb8/edit?usp=sharing" role="button">Manual de usuario</a>
                    </p>
                </div>
            </div>

<?php include('template/pie.php') ?>