<?php
require_once('../includes/auth.php');

// Solo Admin y Bibliotecario
requireRole(['A', 'B']);
?>

<?php include('../includes/header.php'); ?>

<body class="bg-gray-100 text-gray-900">
<?php include('../includes/menu.php'); ?>
    <!-- Recivir el mensaje de error o de que se registro desde inserta -->
    <?php if (isset($_GET['error'])){ ?>
        <div style="color: red; font-weight: bold;">
            <?= htmlspecialchars($_GET['error']) ?>
        </div>
    <?php }?>
        <?php
    include('../clases/categoria.php');
    $categoria = new Categoria();
    $resultado = $categoria->mostrar(); // Trae todas las categorías
    ?>
<div class="w-full max-w-5xl bg-white shadow-lg rounded-2xl p-8 lg:p-12 border border-gray-300 mx-auto mb-10">
  <h2 class="text-2xl font-semibold text-center text-[#4F0087] mb-6">
    Formulario Subcategoría
  </h2>
<?php include('../includes/notificacion.php'); ?>
  <form action="../controladores/insertar_subcategoria.php" method="POST" enctype="multipart/form-data" 
        class="grid grid-cols-1 md:grid-cols-2 gap-4">

    <div>
      <label class="block text-sm font-medium text-gray-700">Nombre subcategoría: <span class="text-red-500 text-2xl">*</span></label>
      <!-- <label class="block text-sm font-medium text-gray-700">Nombre subcategoría:</label> -->
      <input type="text" name="nombreSubCategoria" placeholder="Nombre subcategoria" required
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087] uppercase"
        value="<?= $_SESSION['form_subcategoria']['nombreSubCategoria'] ?? '' ?>">
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700">Icono de la subcategoría: <span class="text-red-500 text-2xl">*</span></label>
      <!-- <label class="block text-sm font-medium text-gray-700">Icono de la subcategoría:</label> -->
      <input type="file" name="iconoSubCategoria"
        class="w-full mt-1 p-2 border rounded-md bg-white focus:outline-[#4F0087]">
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700">Abreviarura: <span class="text-red-500 text-2xl">*</span></label>
      <!-- <label class="block text-sm font-medium text-gray-700">Abreviarura:</label> -->
      <input type="text" name="abreviatura" placeholder="Abreviatura de la subcategoria" minlength="3" maxlength="3" required
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087] uppercase"
        value="<?= $_SESSION['form_subcategoria']['abreviatura'] ?? '' ?>">
    </div>

        <div>
      <label class="block text-sm font-medium text-gray-700">Categoría: <span class="text-red-500 text-2xl">*</span></label>
      <!-- <label class="block text-sm font-medium text-gray-700">Categoría:</label> -->
      <select name="fkCategoria" required
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087] bg-white">
        <option value="">Seleccione una categoria</option>

        <?php foreach ($resultado as $fila): ?>
            <option value="<?= $fila['pkCategoria'] ?>"
              <?= (isset($_SESSION['form_subcategoria']['fkCategoria']) && $_SESSION['form_subcategoria']['fkCategoria'] == $fila['pkCategoria']) ? 'selected' : '' ?>>
              <?= $fila['nombreCategoria'] ?>
            </option>
        <?php endforeach; ?>

      </select>

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
<?php include('../includes/footer.php'); ?>

</body>