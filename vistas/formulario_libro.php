<?php include('../includes/header.php'); ?>
<body class="bg-gray-100 text-gray-900">

<?php include('../includes/menu.php'); ?>

<?php 
include('../clases/libro.php');
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
      <label class="block text-sm font-medium text-gray-700">ISBN</label>
      <input type="text" name="isbn" placeholder="ISBN" required
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087]"
        value="<?= $_SESSION['form_libro']['isbn'] ?? '' ?>">
    </div>

    <!-- TITULO -->
    <div>
      <label class="block text-sm font-medium text-gray-700">Título</label>
      <input type="text" name="titulo" placeholder="Título del libro" required
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087] uppercase"
        value="<?= $_SESSION['form_libro']['titulo'] ?? '' ?>">
    </div>

    <!-- AUTOR -->
    <div>
      <label class="block text-sm font-medium text-gray-700">Autor</label>
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
      <label class="block text-sm font-medium text-gray-700">Edición</label>
      <input type="text" name="edicion" placeholder="Ej. 3ra Edición"
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087] uppercase"
        value="<?= $_SESSION['form_libro']['edicion'] ?? '' ?>">
    </div>

    <!-- EDITORIAL -->
    <div>
      <label class="block text-sm font-medium text-gray-700">Editorial</label>
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
      <label class="block text-sm font-medium text-gray-700">Portada</label>
      <input type="file" name="portada"
        class="w-full mt-1 p-2 border rounded-md bg-white focus:outline-[#4F0087]">
    </div>

    <!-- NUM PAGINAS -->
    <div>
      <label class="block text-sm font-medium text-gray-700">Número de Páginas</label>
      <input type="number" name="numPaginas" required
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087]" min="1"
        value="<?= $_SESSION['form_libro']['numPaginas'] ?? '' ?>">
    </div>

    <!-- AÑO PUBLICACION -->
    <div>
      <label class="block text-sm font-medium text-gray-700">Año de Publicación</label>
      <input type="number" name="anioPublicacion" required
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087]" min="1000"
        value="<?= $_SESSION['form_libro']['anioPublicacion'] ?? '' ?>">
    </div>

    <!-- IDIOMA -->
    <div>
      <label class="block text-sm font-medium text-gray-700">Idioma</label>
      <input type="text" name="idioma" placeholder="Español, Inglés…" required
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087] uppercase"
        value="<?= $_SESSION['form_libro']['idioma'] ?? '' ?>">
    </div>

    <!-- SUBCATEGORIA -->
    <div>
      <label class="block text-sm font-medium text-gray-700">Subcategoría</label>
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
    <div class="md:col-span-2 flex flex-col gap-3 md:flex-row md:justify-end mt-4">
      <button class="w-full md:w-32 bg-[#B55780] text-white py-2 rounded-md font-semibold hover:bg-[#c46b93] transition">
        Cancelar
      </button>
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
