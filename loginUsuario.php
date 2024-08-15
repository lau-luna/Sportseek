<?php include('template/cabecera.php'); ?>

<section class="col-sm-12 seccion-login">
    <div class="col-sm-6 text-black">


        <div class="d-flex align-items-center h-custom-2 px-5 ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5">

            <form>

                <h3 class="fw-normal mb-0 pb-0 " style="letter-spacing: 1px;">Iniciar Sesión</h3>
                <hr class="mb-2">
                <p class="mb-4 text-muted" style="font-size:smaller;">Si tiene una cuenta, inicie sesión con su dirección de correo electrónico.</p>

                <div data-mdb-input-init class="form-outline mb-2">
                    <input type="email" id="form2Example18" class="form-control form-control-md" />
                    <label class="form-label" style="font-size:small;"  for="form2Example18">Correo electrónico</label>
                </div>

                <div data-mdb-input-init class="form-outline mb-2">
                    <input type="password" id="form2Example28" class="form-control form-control-md" />
                    <label class="form-label" style="font-size:small;" for="form2Example28">Contraseña</label>
                </div>

                <div class="pt-1 mb-2">
                    <button data-mdb-button-init data-mdb-ripple-init class="btn btn-info btn-md btn-block" type="button">Ingresar ></button>
                </div>

                <p class="small mb-3 pb-lg-2"><a class="text-muted" href="#!">Olvidé mi contraseña</a></p>
                <p>No tiene una cuenta? <a href="#!" class="link-info">Regístrese aquí</a></p>

            </form>

        </div>

    </div>
    <div class="col-sm-6 px-0 d-none d-sm-block">
        <img src="./img/lionel-messi.2183aef8.jpg"
            alt="Login image" class="w-100 vh-75" style="object-fit: fill; object-position: left;">
    </div>

</section>


<?php include('template/pie.php'); ?>