<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owl Book - Formulario Prestamo</title>
</head>
<?php include('../includes/header.php'); ?>
<body class="bg-gray-100 text-gray-900">
    <?php include('../includes/menu.php'); ?>
<?php include('../includes/notificacion.php'); ?>
<div class="w-full max-w-5xl bg-white shadow-lg rounded-2xl p-8 lg:p-12 border border-gray-300 mx-auto mb-10">
    <h2 class="text-2xl font-semibold text-center text-[#4F0087] mb-6">
    Formulario Prestamo
    </h2>
    <form action="../controladores/insertar_prestamo.php" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-4">
    
    <!-- Fecha Limite -->
    <div>
      <label class="block text-sm font-medium text-gray-700">Fecha Limite</label>
      <input type="date" name="fechaLimite" required
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087]">
    </div>
    <!-- Folio Contracto -->
     <div>
      <label class="block text-sm font-medium text-gray-700">Folio Contracto</label>
      <input type="text" name="folioContrato" required
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087]">
    </div>
    <!-- Contracto -->
     <div>
      <label class="block text-sm font-medium text-gray-700">Contracto</label>
      <input type="file" name="archivoContrato" required
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087]">
    </div>
    <!-- Folio Copia -->
     <div>
      <label class="block text-sm font-medium text-gray-700">Folio Copia</label>
      <input type="text" name="folio" required
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087]">
    </div>
    <!-- Usuario Solicitante -->
     <div>
      <label class="block text-sm font-medium text-gray-700">Usuario Solicitante</label>
      <input type="text" name="numCredS" required
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087]">
    </div>
    <!-- Este es automatico-->
     <div>
      <label class="block text-sm font-medium text-gray-700">Usuario Autorizante</label>
      <input type="text" name="numCredA"
        value="<?php echo isset($_SESSION['numCredencial']) ? htmlspecialchars($_SESSION['numCredencial']) : ''; ?>"
           class="w-full mt-1 p-2 border rounded-md bg-gray-200 text-gray-600"
           readonly>
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
<?php include('../includes/footer.php'); ?>
</body>
</html>
