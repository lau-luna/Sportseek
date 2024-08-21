<?php include("template/cabecera.php"); ?>

<div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel" style="z-index: -999; margin-top: 0.5%">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="./img/carrusel1.png" class="d-block w-100" style="z-index: -999; object-fit:cover;" alt="...">
    </div>
    <div class="carousel-item">
      <img src="./img/carrusel2.png" class="d-block w-100" style="z-index: -999; object-fit:cover;" alt="...">
    </div>
    <div class="carousel-item">
      <img src="./img/carrusel3.png" class="d-block w-100" style="z-index: -999; object-fit:cover;" alt="...">
    </div>
  </div>
</div>

<br>
<div class="productosCategorias">
  <h3>Los más nuevos</h3>
  <hr>
  <?php
  include("administrador/config/bd.php");

  $sentenciaSQL = $conexion->prepare("SELECT * FROM Productos ORDER BY ID_Producto DESC LIMIT 10");
  $sentenciaSQL->execute();
  $listaProductos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

  ?>
  <div class="">
    <div class="row d-flex">
      <?php foreach ($listaProductos as $producto) {
        $formId = 'postForm' . htmlspecialchars($producto['ID_Producto']);
      ?>
        <div class="">
          <form id="<?php echo $formId; ?>" action="productoDetalle.php" method="GET">
            <input type="hidden" name="IdProducto" value="<?php echo htmlspecialchars($producto['ID_Producto']) ?>">
            <a href="#" onclick="document.getElementById('<?php echo $formId; ?>').submit();">
              <div class="cardLista">
                <div class="cardProdInicio">
                  <img class="card-img-topProd img-square" src="./imgProductos/<?php echo htmlspecialchars($producto['Imagen_Producto']) ?>" alt="">
                  <div class="card-bodyProd">
                    <h5 class="card-titleProd"><?php echo htmlspecialchars($producto['Nombre_Producto']) ?></h5>
                    <p class="text-infoProd"><?php echo "$ " . htmlspecialchars($producto['Precio_Producto']) ?></p>
                    <?php if ($producto['Tiene_Stock_Producto'] == 0) { ?>
                      <p class="text-danger stock-labelProd"><?php echo "Sin Stock" ?></p>
                    <?php } ?>
                  </div>
                </div>
              </div>

            </a>
          </form>
        </div>
      <?php } ?>
    </div>
  </div>

  <?php $arrayCategorias = ['Futbol', 'Caza y Pesca', 'Rugby'];
  foreach ($arrayCategorias as $categoria) { ?>
    <br>
    <h3> <?php echo htmlspecialchars($categoria)?> </h3>
    <hr>
    <?php
    $sentenciaSQL = $conexion->prepare("SELECT * FROM Productos INNER JOIN Categorias ON Productos.Categorias_ID_Categoria=Categorias.ID_Categoria WHERE Categorias.Nombre_Categoria=:categoria ORDER BY Productos.ID_Producto DESC LIMIT 10");
    $sentenciaSQL->bindParam(":categoria", $categoria);
    $sentenciaSQL->execute();
    $listaProductos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC); ?>
    <div class="">
      <div class="row d-flex">
        <?php foreach ($listaProductos as $producto) {
          $formId = 'postForm' . htmlspecialchars($producto['ID_Producto']);
        ?>
          <div class="">
            <form id="<?php echo $formId; ?>" action="productoDetalle.php" method="GET">
              <input type="hidden" name="IdProducto" value="<?php echo htmlspecialchars($producto['ID_Producto']) ?>">
              <a href="#" onclick="document.getElementById('<?php echo $formId; ?>').submit();">
                <div class="cardLista">
                  <div class="cardProdInicio">
                    <img class="card-img-topProd img-square" src="./imgProductos/<?php echo htmlspecialchars($producto['Imagen_Producto']) ?>" alt="">
                    <div class="card-bodyProd">
                      <h5 class="card-titleProd"><?php echo htmlspecialchars($producto['Nombre_Producto']) ?></h5>
                      <p class="text-infoProd"><?php echo "$ " . htmlspecialchars($producto['Precio_Producto']) ?></p>
                      <?php if ($producto['Tiene_Stock_Producto'] == 0) { ?>
                        <p class="text-danger stock-labelProd"><?php echo "Sin Stock" ?></p>
                      <?php } ?>
                    </div>
                  </div>
                </div>

              </a>
            </form>
          </div>
        <?php } ?>
      </div>
    </div>
  <?php } ?>

  <?php include("template/pie.php"); ?>