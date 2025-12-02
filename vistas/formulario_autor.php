<?php
require_once('../includes/auth.php');

// Solo Admin y Bibliotecario
requireRole(['A', 'B']);
?>

<?php include('../includes/header.php'); ?>
<body class="bg-gray-100 text-gray-900">
<?php include('../includes/menu.php'); ?>
<?php include('../includes/notificacion.php'); ?>
    <!-- Recivir el mensaje de error o de que se registro desde inserta -->
    <?php if (isset($_GET['error'])){ ?>
        <div style="color: red; font-weight: bold;">
            <?= htmlspecialchars($_GET['error']) ?>
        </div>
    <?php }?>
    <?php
include('../clases/nacionalidad.php');
$clase = new Nacionalidad();
$resultado = $clase->listaNacionalidades();
?>
<?php include('../includes/notificacion.php'); ?>
<div class="w-full max-w-5xl bg-white shadow-lg rounded-2xl p-8 lg:p-12 border border-gray-300 mx-auto mb-10">
  <h2 class="text-2xl font-semibold text-center text-[#4F0087] mb-6">
    Formulario Autor
  </h2>
<?php include('../includes/notificacion.php'); ?>

  <form action="../controladores/insertar_autor.php" method="POST" enctype="multipart/form-data" 
        class="grid grid-cols-1 md:grid-cols-2 gap-4">

        
    <div>
      <label class="block text-sm font-medium text-gray-700">Nombre Autor:</label>
      <input type="text" name="nombreAutor" placeholder="Nombre autor" required
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087] uppercase"
        value="<?= $_SESSION['form_autor']['nombreAutor'] ?? '' ?>">
    </div>

        <div>
      <label class="block text-sm font-medium text-gray-700">Foto Autor:</label>
      <input type="file" name="iconoAutor"
        class="w-full mt-1 p-2 border rounded-md bg-white focus:outline-[#4F0087]">
    </div>

           <div>
      <label class="block text-sm font-medium text-gray-700">Nacionalidad:</label>
      <select name="fkNacionalidad" required
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087] bg-white">
        <option value="">Seleccione una nacionalidad</option>

        <?php foreach ($resultado as $fila): ?>
            <option value="<?= $fila['pkNacionalidad'] ?>"
              <?= (isset($_SESSION['form_autor']['fkNacionalidad']) && $_SESSION['form_autor']['fkNacionalidad'] == $fila['pkNacionalidad']) ? 'selected' : '' ?>>
              <?= $fila['nombreNaci'] ?>
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