<!-- incluir Header y Menu-->
<?php 
include('../includes/header.php');
?>
<body class="bg-gray-100 text-gray-900">
  <?php include('../includes/menu.php'); ?>

  <!-- 🔹 PHP: obtener datos del libro -->
  <?php
  include('../clases/libro.php');
  $clase = new Libro();
  $pkLibro = $_GET['pkLibro'] ?? null;

  if (!$pkLibro) {
      echo "<p>No se especificó el libro.</p>";
      exit;
  }

  $resultado = $clase->detalles($pkLibro);

  if ($resultado && $resultado->num_rows > 0) {
      $fila = $resultado->fetch_assoc();
  } else {
      echo "<p>No se encontró el libro.</p>";
      exit;
  }

  // Imagen (usa placeholder si no hay)
  $imgRuta = !empty($fila['portada'])
      ? "../imagenes/portadas/{$fila['portada']}"
      : "../imagenes/portadas/placeholder.png";
  ?>

  <!-- 🔹 Título principal -->
  <div class="w-full flex flex-col items-start px-8 mt-8">
    <div class="w-full max-w-4xl mx-auto">
      <h1 class="titulos">Detalles del Libro</h1>
      <hr class="linea-separadora mb-6">
    </div>
  </div>

  <!-- 🔹 Contenedor principal -->
   <!-- <div class="w-full max-w-5xl bg-white shadow-lg rounded-2xl p-8 border border-gray-300 mb-12 mx-auto flex flex-col md:flex-row gap-8"> -->
  <div class="w-full max-w-5xl bg-white shadow-lg rounded-2xl p-8 border border-gray-300 mb-12 mx-auto flex flex-col md:flex-row-reverse gap-8">


    <!--  Portada del libro -->
    <div class="flex-shrink-0 w-full md:w-1/3 flex justify-center items-start">
      <img 
        src="<?= $imgRuta ?>" 
        alt="Portada de <?= htmlspecialchars($fila['portada']) ?>" 
        class="rounded-xl shadow-md border border-gray-200 object-cover w-64 h-96 bg-gray-50"
      >
    </div>

    <!--  Datos del libro -->
    <div class="flex-1">
      <div class="mb-6 text-center md:text-left">
        <h2 class="text-2xl font-semibold text-[#4F0087]"><?= $fila['titulo'] ?></h2>
        <p class="text-gray-600">Información General</p>
      </div>

      <div class="border-t border-gray-300 pt-4">
        <dl class="divide-y divide-gray-200">

          <div class="py-3 grid grid-cols-3 gap-4">
            <dt class="font-medium text-gray-700">ISBN:</dt>
            <dd class="col-span-2 text-gray-800"><?= $fila['isbn'] ?></dd>
          </div>

          <div class="py-3 grid grid-cols-3 gap-4">
            <dt class="font-medium text-gray-700">Autor:</dt>
            <dd class="col-span-2 text-gray-800"><?= $fila['nombreAutor'] ?></dd>
          </div>

          <div class="py-3 grid grid-cols-3 gap-4">
            <dt class="font-medium text-gray-700">Editorial:</dt>
            <dd class="col-span-2 text-gray-800"><?= $fila['nombreEditorial'] ?></dd>
          </div>

          <div class="py-3 grid grid-cols-3 gap-4">
            <dt class="font-medium text-gray-700">Edición:</dt>
            <dd class="col-span-2 text-gray-800"><?= $fila['edicion'] ?></dd>
          </div>

          <div class="py-3 grid grid-cols-3 gap-4">
            <dt class="font-medium text-gray-700">Año de Publicación:</dt>
            <dd class="col-span-2 text-gray-800"><?= $fila['añoPublicacion'] ?></dd>
          </div>

          <div class="py-3 grid grid-cols-3 gap-4">
            <dt class="font-medium text-gray-700">Número de Páginas:</dt>
            <dd class="col-span-2 text-gray-800"><?= $fila['numPaginas'] ?></dd>
          </div>

          <div class="py-3 grid grid-cols-3 gap-4">
            <dt class="font-medium text-gray-700">Idioma:</dt>
            <dd class="col-span-2 text-gray-800"><?= $fila['idioma'] ?></dd>
          </div>

          <div class="py-3 grid grid-cols-3 gap-4">
            <dt class="font-medium text-gray-700">Categoría:</dt>
            <dd class="col-span-2 text-gray-800"><?= $fila['nombreCategoria'] ?></dd>
          </div>

          <div class="py-3 grid grid-cols-3 gap-4">
            <dt class="font-medium text-gray-700">Subcategoría:</dt>
            <dd class="col-span-2 text-gray-800"><?= $fila['nombreSubCategoria'] ?></dd>
          </div>

          <div class="py-3 grid grid-cols-3 gap-4">
            <dt class="font-medium text-gray-700">Fecha de Registro:</dt>
            <dd class="col-span-2 text-gray-800"><?= $fila['fechaRegistro'] ?></dd>
          </div>

          <div class="py-3 grid grid-cols-3 gap-4">
            <dt class="font-medium text-gray-700">Sinopsis:</dt>
            <dd class="col-span-2 text-gray-700 text-justify"><?= $fila['sinopsis'] ?></dd>
          </div>

        </dl>
      </div>

      <!-- 🔘 Botones de acción -->
      <div class="flex justify-end gap-3 mt-8">
        <a href="#" class="px-4 py-2.5 rounded-md text-white font-medium transition bg-[#5780B5] hover:bg-[#6b92c2] shadow-sm">
          Editar
        </a>
        <a href="#" class="px-4 py-2.5 rounded-md text-white font-medium transition bg-[#B55780] hover:bg-[#c46b93] shadow-sm">
          Dar de baja
        </a>
      </div>
    </div>
  </div>

  <?php include('../includes/footer.php'); ?>
</body>
</html>
