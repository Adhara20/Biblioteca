<?php include('../includes/header.php'); ?>
<body class="bg-gray-100 text-gray-900">

<?php include('../includes/menu.php'); ?>
<?php include('../includes/notificacion.php'); ?>
<?php
include('../clases/nacionalidad.php');
// Crear objeto de la clase Nacionalidad para mostrar las opciones del select
$clase = new Nacionalidad();
$resultado = $clase->listaNacionalidades();
?>

<div class="w-full max-w-xl bg-white shadow-lg rounded-2xl p-8 lg:p-10 border border-gray-300 mx-auto mt-10 mb-10">

  <h2 class="text-2xl font-semibold text-center text-[#4F0087] mb-6">
    Registrar Editorial
  </h2>

  <form action="../controladores/insertar_editorial.php" method="POST" class="grid grid-cols-1 gap-4">

    <!-- NOMBRE EDITORIAL -->
    <div>
      <label class="block text-sm font-medium text-gray-700">Nombre de la Editorial</label>
      <input type="text" name="nombreEditorial" placeholder="Ej. Penguin, Planeta, Anagrama…" required
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087] uppercase">
    </div>

    <!-- NACIONALIDAD -->
    <div>
      <label class="block text-sm font-medium text-gray-700">Nacionalidad</label>
      <select name="fkNacionalidad" required
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087] uppercase">
        <option value="">Seleccione una nacionalidad</option>
        <?php foreach ($resultado as $fila): ?>
          <option value="<?= $fila['pkNacionalidad'] ?>"><?= $fila['nombreNaci'] ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <!-- BOTONES -->
    <div class="flex flex-col gap-3 md:flex-row md:justify-end mt-4">
      <a href="lista_editoriales.php"
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

<?php include('../includes/footer.php'); ?>
</body>
