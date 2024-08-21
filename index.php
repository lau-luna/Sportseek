<?php include("template/cabecera.php") ?>

<div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel" style="z-index: -999">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="./img/carrusel1.png" class=" w-100" style="z-index: -999; object-fit:cover;" alt="...">
    </div>
    <div class="carousel-item">
      <img src="./img/carrusel2.png" class="w-100" style="z-index: -999; object-fit:cover;" alt="...">
    </div>
    <div class="carousel-item">
      <img src="./img/carrusel3.png" class="w-100" style="z-index: -999; object-fit:cover;" alt="...">
    </div>
  </div>
</div>
<br>
<div class="productosCategorias">
  <h3>Populares</h3>
  <?php
  include("administrador/config/bd.php");

  // Obtener la categoría seleccionada del formulario
  $categoriaSeleccionada = isset($_GET['txtCategoria']) ? $_GET['txtCategoria'] : 'todas';
  // Obtener el filtro seleccionado del formulario
  $filtroSeleccionado = isset($_GET['txtFiltro']) ? $_GET['txtFiltro'] : 'ninguno';

  // Mostrar productos al azar para la categoría "Popular"
  if ($categoriaSeleccionada == 'todas') {
    $sentenciaSQL = $conexion->prepare("SELECT * FROM Productos ORDER BY RAND() LIMIT 20");
    $sentenciaSQL->execute();
    $listaProductos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
  } else {
    // Filtrar productos por categoría específica
    switch ($filtroSeleccionado) {
      case 'precioMasBajo':
        $sentenciaSQL = $conexion->prepare("SELECT * FROM Productos WHERE Categorias_ID_Categoria=:IdCategoria ORDER BY Precio_Producto ASC");
        break;
      case 'precioMasAlto':
        $sentenciaSQL = $conexion->prepare("SELECT * FROM Productos WHERE Categorias_ID_Categoria=:IdCategoria ORDER BY Precio_Producto DESC");
        break;
      case 'ninguno':
        $sentenciaSQL = $conexion->prepare("SELECT * FROM Productos WHERE Categorias_ID_Categoria=:IdCategoria ORDER BY ID_Producto DESC");
        break;
    }

    $sentenciaSQL->bindParam(":IdCategoria", $categoriaSeleccionada);
    $sentenciaSQL->execute();
    $listaProductos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
  }
  ?>
  <div class="">
    <div class="row">
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

  <br>
  <h3>Fútbol</h3>
  <?php
  // Mostrar productos solo de la categoría "Fútbol"
  $categoriaSeleccionada = '1'; // Asume que '1' es el ID de la categoría "Fútbol"

  switch ($filtroSeleccionado) {
    case 'precioMasBajo':
      $sentenciaSQL = $conexion->prepare("SELECT * FROM Productos WHERE Categorias_ID_Categoria=:IdCategoria ORDER BY Precio_Producto ASC");
      break;
    case 'precioMasAlto':
      $sentenciaSQL = $conexion->prepare("SELECT * FROM Productos WHERE Categorias_ID_Categoria=:IdCategoria ORDER BY Precio_Producto DESC");
      break;
    case 'ninguno':
      $sentenciaSQL = $conexion->prepare("SELECT * FROM Productos WHERE Categorias_ID_Categoria=:IdCategoria ORDER BY ID_Producto DESC");
      break;
  }

  $sentenciaSQL->bindParam(":IdCategoria", $categoriaSeleccionada);
  $sentenciaSQL->execute();
  $listaProductos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
  ?>
  <div class="col-md-10">
    <div class="row">
      <?php foreach ($listaProductos as $producto) {
        $formId = 'postForm' . htmlspecialchars($producto['ID_Producto']);
      ?>
        <div class="col-md-3 mb-4">
          <form id="<?php echo $formId; ?>" action="productoDetalle.php" method="GET">
            <input type="hidden" name="IdProducto" value="<?php echo htmlspecialchars($producto['ID_Producto']) ?>">
            <a href="#" onclick="document.getElementById('<?php echo $formId; ?>').submit();">
              <div class="card">
                <img class="card-img-top" src="./imgProductos/<?php echo htmlspecialchars($producto['Imagen_Producto']) ?>" alt="">
                <div class="card-body h-100">
                  <h5 class="card-title"><?php echo htmlspecialchars($producto['Nombre_Producto']) ?></h5>
                  <p class="text-info"><?php echo "$ " . htmlspecialchars($producto['Precio_Producto']) ?></p>
                  <?php if ($producto['Tiene_Stock_Producto'] == 0) { ?>
                    <p class="text-danger"><?php echo "Sin Stock" ?></p>
                  <?php } ?>
                </div>
              </div>
            </a>
          </form>
        </div>
      <?php } ?>
    </div>
  </div>

  <br>
  <h3>Pesca</h3>
  <?php
  // Mostrar productos solo de la categoría "Pesca"
  $categoriaSeleccionada = '2'; // Asume que '2' es el ID de la categoría "Pesca"

  switch ($filtroSeleccionado) {
    case 'precioMasBajo':
      $sentenciaSQL = $conexion->prepare("SELECT * FROM Productos WHERE Categorias_ID_Categoria=:IdCategoria ORDER BY Precio_Producto ASC");
      break;
    case 'precioMasAlto':
      $sentenciaSQL = $conexion->prepare("SELECT * FROM Productos WHERE Categorias_ID_Categoria=:IdCategoria ORDER BY Precio_Producto DESC");
      break;
    case 'ninguno':
      $sentenciaSQL = $conexion->prepare("SELECT * FROM Productos WHERE Categorias_ID_Categoria=:IdCategoria ORDER BY ID_Producto DESC");
      break;
  }

  $sentenciaSQL->bindParam(":IdCategoria", $categoriaSeleccionada);
  $sentenciaSQL->execute();
  $listaProductos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
  ?>
  <div class="col-md-10">
    <div class="row">
      <?php foreach ($listaProductos as $producto) {
        $formId = 'postForm' . htmlspecialchars($producto['ID_Producto']);
      ?>
        <div class="col-md-3 mb-4">
          <form id="<?php echo $formId; ?>" action="productoDetalle.php" method="GET">
            <input type="hidden" name="IdProducto" value="<?php echo htmlspecialchars($producto['ID_Producto']) ?>">
            <a href="#" onclick="document.getElementById('<?php echo $formId; ?>').submit();">
              <div class="card">
                <img class="card-img-top" src="./imgProductos/<?php echo htmlspecialchars($producto['Imagen_Producto']) ?>" alt="">
                <div class="card-body h-100">
                  <h5 class="card-title"><?php echo htmlspecialchars($producto['Nombre_Producto']) ?></h5>
                  <p class="text-info"><?php echo "$ " . htmlspecialchars($producto['Precio_Producto']) ?></p>
                  <?php if ($producto['Tiene_Stock_Producto'] == 0) { ?>
                    <p class="text-danger"><?php echo "Sin Stock" ?></p>
                  <?php } ?>
                </div>
              </div>
            </a>
          </form>
        </div>
      <?php } ?>
    </div>
  </div>

  <br>
  <h3>Rugby</h3>
  <?php
  // Mostrar productos solo de la categoría "Rugby"
  $categoriaSeleccionada = '3'; // Asume que '3' es el ID de la categoría "Rugby"

  switch ($filtroSeleccionado) {
    case 'precioMasBajo':
      $sentenciaSQL = $conexion->prepare("SELECT * FROM Productos WHERE Categorias_ID_Categoria=:IdCategoria ORDER BY Precio_Producto ASC");
      break;
    case 'precioMasAlto':
      $sentenciaSQL = $conexion->prepare("SELECT * FROM Productos WHERE Categorias_ID_Categoria=:IdCategoria ORDER BY Precio_Producto DESC");
      break;
    case 'ninguno':
      $sentenciaSQL = $conexion->prepare("SELECT * FROM Productos WHERE Categorias_ID_Categoria=:IdCategoria ORDER BY ID_Producto DESC");
      break;
  }

  $sentenciaSQL->bindParam(":IdCategoria", $categoriaSeleccionada);
  $sentenciaSQL->execute();
  $listaProductos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
  ?>
  <div class="col-md-10">
    <div class="row">
      <?php foreach ($listaProductos as $producto) {
        $formId = 'postForm' . htmlspecialchars($producto['ID_Producto']);
      ?>
        <div class="col-md-3 mb-4">
          <form id="<?php echo $formId; ?>" action="productoDetalle.php" method="GET">
            <input type="hidden" name="IdProducto" value="<?php echo htmlspecialchars($producto['ID_Producto']) ?>">
            <a href="#" onclick="document.getElementById('<?php echo $formId; ?>').submit();">
              <div class="card">
                <img class="card-img-top" src="./imgProductos/<?php echo htmlspecialchars($producto['Imagen_Producto']) ?>" alt="">
                <div class="card-body h-100">
                  <h5 class="card-title"><?php echo htmlspecialchars($producto['Nombre_Producto']) ?></h5>
                  <p class="text-info"><?php echo "$ " . htmlspecialchars($producto['Precio_Producto']) ?></p>
                  <?php if ($producto['Tiene_Stock_Producto'] == 0) { ?>
                    <p class="text-danger"><?php echo "Sin Stock" ?></p>
                  <?php } ?>
                </div>
              </div>
            </a>
          </form>
        </div>
      <?php } ?>
    </div>
  </div>
</div>

<?php include("template/pie.php") ?>