<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Catálogo de Libros</title>
  <link rel="stylesheet" href="../css/libros.css">
</head>

<?php
include('../clases/libro.php');
$clase = new Libro();
$resultado = $clase->listaLibrosActivos();
include('../includes/header.php');
?>

<body>
  <?php include('../includes/menu.php'); ?>

  <div class="px-10 mb-6">
    <h1 class="titulos">Catálogo de Libros</h1>
    <hr class="linea-separadora-listas">
  </div>

 <section class="grid-libros">
  <?php foreach ($resultado as $fila): 
    $titulo = htmlspecialchars($fila['titulo']);
    $isbn = htmlspecialchars($fila['isbn']);
    $autor = htmlspecialchars($fila['nombreAutor']);
    $edicion = htmlspecialchars($fila['edicion']);
    $anio = htmlspecialchars($fila['añoPublicacion'] ?? $fila['anioPublicacion'] ?? '');
    $editorial = htmlspecialchars($fila['nombreEditorial']);
    $categoria = htmlspecialchars($fila['nombreCategoria']);
    $subcategoria = htmlspecialchars($fila['nombreSubCategoria']);
    $img = htmlspecialchars($fila['portada'] ?? '');
    $edicionLabel = trim($edicion) !== '' ? "{$edicion} Edición" : '';
    if ($anio !== '') {
      $edicionLabel = $edicionLabel !== '' ? "{$edicionLabel}, {$anio}" : "{$anio}";
    }
  ?>
  <a href="detalle_libro.php?pkLibro=<?= $fila['pkLibro'] ?>" class="tarjeta-mini">
    <img  src="<?= !empty($img) ? '../imagenes/portadas/' . $img : '../imagenes/portadas/placeholder.png'; ?>"  alt="Portada de <?= $titulo ?>"  class="tarjeta-mini-img">

    <div class="tarjeta-mini-info">
      <h2 class="tarjeta-mini-titulo"><?= $titulo ?></h2>
      <p class="tarjeta-mini-autor"><?= $autor ?></p>
      <p><strong>ISBN:</strong> <?= $isbn ?></p>
      <p><strong>Editorial:</strong> <?= $editorial ?></p>
      <p><strong>Categoría:</strong> <?= $categoria ?></p>
      <p class="tarjeta-mini-extra"><?= $edicionLabel ?></p>
    </div>
  </a>
  <?php endforeach; ?>
</section>

  <?php include('../includes/footer.php'); ?>
</body>
</html>
