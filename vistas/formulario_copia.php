<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owl Book - Formulario Copia</title>
</head>
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
  <div class="w-full max-w-5xl bg-white shadow-lg rounded-2xl p-8 lg:p-12 border border-gray-300 mx-auto mb-10">
    <h2 class="text-2xl font-semibold text-center text-[#4F0087] mb-6">
    Formulario Copia
    </h2>
    <form action="../controladores/insertar_copia.php" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <!-- ISBN -->
    <div>
      <label class="block text-sm font-medium text-gray-700">ISBN</label>
      <input type="text" name="isbn" required
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087]">
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700">Fecha de adquisición</label>
      <input type="date" name="fechaAdquisicion" value="<?= date('Y-m-d') ?>" readonly
         class="w-full mt-1 p-2 border rounded-md bg-gray-200 text-gray-600">
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700">Observaciones</label>
      <textarea name="observaciones" rows="4" placeholder="Observaciones"
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087]"></textarea>
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
</body>
</html>