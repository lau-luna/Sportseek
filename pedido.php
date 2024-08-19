<?php include("template/cabecera.php"); ?>

<!--Conexión a base de datos -->
<?php include("administrador/config/bd.php"); ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="./css/factura.css" rel="stylesheet">

    <div class="container mt-5">
        <div class="invoice-box">
            <div class="row">
                <div class="col-md-6">
                    <img src="./img/LogoTiendaHeader.png" alt="Logo de la empresa" class="logo">
                    <p>
                        dirección de la empresa<br>
                        ciudad
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p>
                        N° Pedido: zaraza<br>
                        Fecha: 09/12/2018<br>
                    </p>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-6">
                    <h5>Datos:</h5>
                    <p>
                        id_usuario <br>
                        aca va el nombre<br>
                        direccion<br>
                        ciudad
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <h5>Estado:</h5>
                    <p>Pagado/No pagado/Lal</p>
                </div>
            </div>

            <table class="table table-bordered mt-4">
                <thead class="table-light">
                    <tr>
                        <th>Producto</th>
                        <th class="text-end">Precio</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>nombre de producto 1</td>
                        <td class="text-end">$912.18</td>
                    </tr>
                    <tr>
                        <td>nombre de producto 2</td>
                        <td class="text-end">$3.01</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="total-row">
                        <td>Total</td>
                        <td class="text-end">$915.19</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>




<?php include("template/pie.php"); ?>