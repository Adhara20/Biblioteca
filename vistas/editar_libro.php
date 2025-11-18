<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Libro</title>
</head>

<?php include('../includes/header.php'); ?>

<body class="bg-gray-100 text-gray-900">

<?php include('../includes/menu.php'); ?>

<?php
include('../clases/libro.php');
$clase = new Libro();

$pkLibro = $_GET['pkLibro'] ?? null;

if (!$pkLibro) {
    echo "<p>No se especificó el libro.</p>";
    exit;
}

// Usas tu función "detalles" como pediste
$resultado = $clase->detalles($pkLibro);

if ($resultado && $resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
} else {
    echo "<p>No se encontró el libro.</p>";
    exit;
}

// Determinar imagen actual
$imgRuta = !empty($fila['portada']) 
    ? "../imagenes/portadas/" . $fila['portada']
    : "../imagenes/portadas/placeholder.png";
?>

<?php
include('../clases/autor.php');
include('../clases/editorial.php');
include('../clases/subcategoria.php');

$autor = new Autor();
$editorial = new Editorial();
$subcategoria = new Subcategoria();

$listaAutores = $autor->mostrar();
$listaEditoriales = $editorial->listaEditoriales();
$listaCategorias = $subcategoria->listaActivo();
?>

<!-- MENSAJE DE Exito -->
<?php include('../includes/notificacion.php') ?>


<!-- TÍTULO -->
<div class="w-full flex flex-col items-start px-8 mt-8">
  <div class="w-full max-w-4xl mx-auto">
      <h1 class="titulos">Editar Libro</h1>
      <hr class="linea-separadora mb-6">
  </div>
</div>

<!-- CONTENEDOR PRINCIPAL -->
<div class="w-full max-w-5xl bg-white shadow-lg rounded-2xl p-8 lg:p-12 border border-gray-300 mx-auto mb-10">

  <h2 class="text-2xl font-semibold text-center text-[#4F0087] mb-6">
      Formulario Libro
  </h2>

  <form action="../controladores/actualizar_libro.php" method="POST" enctype="multipart/form-data" 
        class="grid grid-cols-1 md:grid-cols-2 gap-4">

    <!-- PK -->
    <input type="hidden" name="pkLibro" value="<?= $fila['pkLibro'] ?>">

    <!-- PORTADA ACTUAL (para el controlador) -->
    <input type="hidden" name="portadaActual" value="<?= $fila['portada'] ?>">

    <!-- ISBN -->
    <div>
      <label class="block text-sm font-medium text-gray-700">ISBN</label>
      <input type="text" name="isbn" required
        value="<?= $fila['isbn'] ?>"
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087]">
    </div>

    <!-- TÍTULO -->
    <div>
      <label class="block text-sm font-medium text-gray-700">Título</label>
      <input type="text" name="titulo" required
        value="<?= $fila['titulo'] ?>"
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087] uppercase">
    </div>

    <!-- AUTOR -->
    <div>
      <label class="block text-sm font-medium text-gray-700">Autor</label>
      <select name="fkAutor" required
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087] bg-white">
        <option value="">Seleccione el autor</option>

        <?php foreach ($listaAutores as $a) { ?>
          <option value="<?= $a['pkAutor'] ?>"
            <?= $a['pkAutor'] == $fila['fkAutor'] ? 'selected' : '' ?>>
            <?= $a['nombreAutor'] ?>
          </option>
        <?php } ?>
      </select>
    </div>

    <!-- EDICIÓN -->
    <div>
      <label class="block text-sm font-medium text-gray-700">Edición</label>
      <input type="text" name="edicion"
        value="<?= $fila['edicion'] ?>"
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087] uppercase">
    </div>

    <!-- EDITORIAL -->
    <div>
      <label class="block text-sm font-medium text-gray-700">Editorial</label>
      <select name="fkEditorial" required
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087] bg-white">

        <option value="">Seleccione la editorial</option>

        <?php foreach ($listaEditoriales as $e) { ?>
          <option value="<?= $e['pkEditorial'] ?>"
            <?= $e['pkEditorial'] == $fila['fkEditorial'] ? 'selected' : '' ?>>
            <?= $e['nombreEditorial'] ?>
          </option>
        <?php } ?>
      </select>
    </div>

    <!-- PÁGINAS -->
    <div>
      <label class="block text-sm font-medium text-gray-700">Número de Páginas</label>
      <input type="number" name="numPaginas" required min="1"
        value="<?= $fila['numPaginas'] ?>"
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087]">
    </div>

    <!-- AÑO -->
    <div>
      <label class="block text-sm font-medium text-gray-700">Año de Publicación</label>
      <input type="number" name="anioPublicacion" required min="1000"
        value="<?= $fila['anioPublicacion'] ?>"
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087]">
    </div>

    <!-- IDIOMA -->
    <div>
      <label class="block text-sm font-medium text-gray-700">Idioma</label>
      <input type="text" name="idioma" required
        value="<?= $fila['idioma'] ?>"
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087] uppercase">
    </div>

    <!-- SUBCATEGORÍA -->
    <div>
      <label class="block text-sm font-medium text-gray-700">Subcategoría</label>
      <select name="fkSubCategoria" required
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087] bg-white">

        <option value="">Seleccione una subcategoría</option>

        <?php foreach ($listaCategorias as $c) { ?>
          <option value="<?= $c['pkSubCategoria'] ?>"
            <?= $c['pkSubCategoria'] == $fila['fkSubCategoria'] ? 'selected' : '' ?>>
            <?= $c['nombreSubCategoria'] ?>
          </option>
        <?php } ?>
      </select>
    </div>
  
    <!-- SINOPSIS -->
    <div class="md:col-span-2">
      <label class="block text-sm font-medium text-gray-700">Sinopsis</label>
      <textarea name="sinopsis" rows="4"
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087]"><?= $fila['sinopsis'] ?></textarea>
    </div>

    <!-- PORTADA: Mostrar actual + subir nueva -->
    <div>
      <label class="block text-sm font-medium text-gray-700">Portada actual</label>

      <img src="<?= $imgRuta ?>" class="w-40 h-56 object-cover border rounded-md shadow mt-2">

      <label class="block text-sm font-medium text-gray-700 mt-3">Subir nueva portada (opcional)</label>
      <input type="file" name="portada" class="w-full mt-1 p-2 border rounded-md bg-white">
    </div>

    <!-- BOTONES -->
    <div class="md:col-span-2 flex flex-col gap-3 md:flex-row md:justify-end mt-4">
      <a href="detalle_libro.php?pkLibro=<?= $fila['pkLibro'] ?>"
         class="w-full md:w-32 bg-[#B55780] text-white py-2 rounded-md font-semibold hover:bg-[#c46b93] transition text-center">
         Cancelar
      </a>

      <button type="submit"
        class="w-full md:w-32 bg-[#4F0087] text-white py-2 rounded-md font-semibold hover:bg-[#6A00B8] transition">
        Guardar Cambios
      </button>
    </div>

  </form>
</div>

<?php include('../includes/footer.php'); ?>
</body>
</html>
