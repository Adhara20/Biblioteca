<?php
require_once('../includes/auth.php');

// Solo Admin y Bibliotecario
requireRole(['A', 'B']);
?>

<?php include('../includes/header.php'); ?>
<body class="bg-gray-100 text-gray-900">

<?php include('../includes/menu.php'); ?>
<?php include('../includes/notificacion.php'); ?>
<?php include('../clases/nacionalidad.php'); ?>
<?php
// Si usas sesiones para mantener datos después de un error, aquí podríamos leerlas.
// (Opcional) 
?>

<div class="w-full max-w-xl bg-white shadow-lg rounded-2xl p-8 lg:p-10 border border-gray-300 mx-auto mt-10 mb-10">

  <h2 class="text-2xl font-semibold text-center text-[#4F0087] mb-6">
    Registrar Nacionalidad
  </h2>

  <form action="../controladores/insertar_nacionalidad.php" method="POST" 
        class="grid grid-cols-1 gap-4">

    <!-- NOMBRE NACIONALIDAD -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Nombre de la Nacionalidad<span class="text-red-500 text-2xl">*</span></label>
        <input type="text" name="nombreNaci" placeholder="Ej. Mexicana, Argentina, Española…" required
          class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087] uppercase">
    </div>

    <!-- BOTONES -->
    <div class="flex flex-col gap-3 md:flex-row md:justify-end mt-4">
      <a href="lista_nacionalidades.php"
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
