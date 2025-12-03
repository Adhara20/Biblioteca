
<?php
require_once('../includes/auth.php');

// Solo Admin y Bibliotecario
requireRole(['A', 'B']);
?>
<?php include('../includes/header.php'); ?>
<body class="bg-gray-100 text-gray-900">

<?php include('../includes/menu.php'); ?>

<?php 
include('../clases/libro.php');
include('../clases/autor.php');
include('../clases/editorial.php');
include('../clases/subcategoria.php');
include('../clases/idioma.php');

$autor = new Autor();
$editorial = new Editorial();
$subcategoria = new Subcategoria();
$idioma = new Idioma();

$listaAutores = $autor->mostrar();
$listaEditoriales = $editorial->listaEditoriales();
$listaCategorias = $subcategoria->mostrar();
$listaIdiomas = $idioma->mostrar();
?>

<!-- MENSAJE DE ERROR -->
<?php include('../includes/notificacion.php'); ?>

<div class="w-full max-w-5xl bg-white shadow-lg rounded-2xl p-8 lg:p-12 border border-gray-300 mx-auto mb-10">
  <h2 class="text-2xl font-semibold text-center text-[#4F0087] mb-6">
    Formulario Libro
  </h2>
  <form action="../controladores/insertar_libro.php" method="POST" enctype="multipart/form-data" 
        class="grid grid-cols-1 md:grid-cols-2 gap-4">

    <!-- ISBN -->
    <div>
      <label class="block text-sm font-medium text-gray-700">ISBN<span class="text-red-500 text-2xl">*</span></label>
      <input type="text" name="isbn" placeholder="ISBN" required
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087]"
        value="<?= $_SESSION['form_libro']['isbn'] ?? '' ?>">
    </div>

    <!-- TITULO -->
    <div>
      <label class="block text-sm font-medium text-gray-700">Título<span class="text-red-500 text-2xl">*</span></label>
      <input type="text" name="titulo" placeholder="Título del libro" required
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087] uppercase"
        value="<?= $_SESSION['form_libro']['titulo'] ?? '' ?>">
    </div>

    <!-- AUTOR -->
    <div>
      <label class="block text-sm font-medium text-gray-700">Autor<span class="text-red-500 text-2xl">*</span></label>
      <select name="fkAutor" required
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087] bg-white">
        <option value="">Seleccione el autor</option>

        <?php foreach ($listaAutores as $fila): ?>
            <option value="<?= $fila['pkAutor'] ?>"
              <?= (isset($_SESSION['form_libro']['fkAutor']) && $_SESSION['form_libro']['fkAutor'] == $fila['pkAutor']) ? 'selected' : '' ?>>
              <?= $fila['nombreAutor'] ?>
            </option>
        <?php endforeach; ?>

      </select>
    </div>

    <!-- EDICION -->
    <div>
      <label class="block text-sm font-medium text-gray-700">Edición<span class="text-red-500 text-2xl">*</span></label>
      <input type="text" name="edicion" placeholder="Ej. 3ra Edición, Deluxe..."
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087] uppercase"
        value="<?= $_SESSION['form_libro']['edicion'] ?? '' ?>">
    </div>

    <!-- EDITORIAL -->
    <div>
      <label class="block text-sm font-medium text-gray-700">Editorial<span class="text-red-500 text-2xl">*</span></label>
      <select name="fkEditorial" required
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087] bg-white">

        <option value="">Seleccione la editorial</option>

        <?php foreach ($listaEditoriales as $fila): ?>
            <option value="<?= $fila['pkEditorial'] ?>"
              <?= (isset($_SESSION['form_libro']['fkEditorial']) && $_SESSION['form_libro']['fkEditorial'] == $fila['pkEditorial']) ? 'selected' : '' ?>>
              <?= $fila['nombreEditorial'] ?>
            </option>
        <?php endforeach; ?>

      </select>
    </div>

    <!-- PORTADA -->
    <div>
      <label class="block text-sm font-medium text-gray-700">Portada<span class="text-red-500 text-2xl">*</span></label>
      <input type="file" name="portada"
        class="w-full mt-1 p-2 border rounded-md bg-white focus:outline-[#4F0087]">
    </div>

    <!-- NUM PAGINAS -->
    <div>
      <label class="block text-sm font-medium text-gray-700">Número de Páginas<span class="text-red-500 text-2xl">*</span></label>
      <input type="number" name="numPaginas" required
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087]" min="1"
        value="<?= $_SESSION['form_libro']['numPaginas'] ?? '' ?>">
    </div>

    <!-- AÑO PUBLICACION -->
    <div>
      <label class="block text-sm font-medium text-gray-700">Año de Publicación<span class="text-red-500 text-2xl">*</span></label>
      <input type="number" name="anioPublicacion" required
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087]" min="1000"
        value="<?= $_SESSION['form_libro']['anioPublicacion'] ?? '' ?>">
    </div>

    <!-- IDIOMA -->
    <div>
      <label class="block text-sm font-medium text-gray-700">Idioma<span class="text-red-500 text-2xl">*</span></label>
      <select name="fkIdioma" required
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087] bg-white">
        <option value="">Seleccione el Idioma</option>
        <?php foreach ($listaIdiomas as $fila): ?>
            <option value="<?= $fila['pkIdioma'] ?>"
              <?= (isset($_SESSION['form_libro']['fkIdioma']) && $_SESSION['form_libro']['fkIdioma'] == $fila['pkIdioma']) ? 'selected' : '' ?>>
              <?= $fila['idioma'] ?>
            </option>
        <?php endforeach; ?>
      </select>
    </div>

    <!-- SUBCATEGORIA -->
    <div>
      <label class="block text-sm font-medium text-gray-700">Subcategoría<span class="text-red-500 text-2xl">*</span></label>
      <select name="fkSubCategoria" required
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087] bg-white">

        <option value="">Seleccione una subcategoría</option>

        <?php foreach ($listaCategorias as $fila): ?>
            <option value="<?= $fila['pkSubCategoria'] ?>"
              <?= (isset($_SESSION['form_libro']['fkSubCategoria']) && $_SESSION['form_libro']['fkSubCategoria'] == $fila['pkSubCategoria']) ? 'selected' : '' ?>>
              <?= $fila['nombreSubCategoria'] ?>
            </option>
        <?php endforeach; ?>

      </select>
    </div>

    <!-- SINOPSIS -->
    <div class="md:col-span-2">
      <label class="block text-sm font-medium text-gray-700">Sinopsis</label>
      <textarea name="sinopsis" rows="4" placeholder="Breve descripción del libro"
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087]"><?= $_SESSION['form_libro']['sinopsis'] ?? '' ?></textarea>
    </div>

    <!-- BOTONES -->
    <!-- <div class="md:col-span-2 flex flex-col gap-3 md:flex-row md:justify-end mt-4">
      <button class="w-full md:w-32 bg-[#B55780] text-white py-2 rounded-md font-semibold hover:bg-[#c46b93] transition">
        Cancelar
      </button> -->
        <div class="flex flex-col gap-3 md:flex-row md:justify-end mt-4">
      <a href="lista_libros.php"
        class="w-full md:w-32 bg-[#B55780] text-white text-center py-2 rounded-md font-semibold hover:bg-[#c46b93] transition">
        Cancelar
        </a>
      <button type="submit"
        class="w-full md:w-32 bg-[#4F0087] text-white py-2 rounded-md font-semibold hover:bg-[#6A00B8] transition">
        Guardar
      </button>
    </div>

  </form>
</div>


  </form>
</div>

<?php include('../includes/footer.php'); ?>
</body>
