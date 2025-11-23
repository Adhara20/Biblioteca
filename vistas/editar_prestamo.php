<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Prestamo</title>
</head>

<?php include('../includes/header.php'); ?>

<body class="bg-gray-100 text-gray-900">

<?php include('../includes/menu.php'); ?>

<?php
include('../clases/prestamo.php');
$clase = new Prestamo();

$pkPrestamo = $_GET['pkPrestamo'] ?? null;

if (!$pkPrestamo) {
    echo "<p>No se especificó el prestamo.</p>";
    exit;
}

// Usas tu función "detalles" como pediste
$resultado = $clase->detalles($pkPrestamo);

if ($resultado && $resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
} else {
    echo "<p>No se encontró el prestamo.</p>";
    exit;
}

?>

<!-- MENSAJE DE Exito -->
<?php include('../includes/notificacion.php') ?>


<!-- TÍTULO -->
<div class="w-full flex flex-col items-start px-8 mt-8">
  <div class="w-full max-w-4xl mx-auto">
      <h1 class="titulos">Editar Prestamo</h1>
      <hr class="linea-separadora mb-6">
  </div>
</div>

<!-- CONTENEDOR PRINCIPAL -->
<div class="w-full max-w-5xl bg-white shadow-lg rounded-2xl p-8 lg:p-12 border border-gray-300 mx-auto mb-10">

  <h2 class="text-2xl font-semibold text-center text-[#4F0087] mb-6">
      Formulario Prestamo
  </h2>

  <form action="../controladores/actualizar_prestamo.php" method="POST" enctype="multipart/form-data" 
        class="grid grid-cols-1 md:grid-cols-2 gap-4">

    <!-- PK -->
    <input type="hidden" name="pkPrestamo" value="<?= $fila['pkPrestamo'] ?>">

    <!-- Fecha Limite -->
    <div>
      <label class="block text-sm font-medium text-gray-700">Fecha Limite</label>
      <input type="date" name="fechaLimite" required value="<?= $fila['fechaLimite'] ?>"
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087]">
    </div>
    <!-- Folio Contracto -->
     <div>
      <label class="block text-sm font-medium text-gray-700">Folio Contracto</label>
      <input type="text" name="folioContrato" required value="<?= $fila['folioContrato'] ?>"
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087]">
    </div>
    <!-- Contracto -->
     <div>
      <label class="block text-sm font-medium text-gray-700">Contracto</label>
      <input type="file" name="archivoContrato" required value="<?= $fila['archivoContrato'] ?>"
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087]">
    </div>
    <!-- Folio Copia -->
     <div>
      <label class="block text-sm font-medium text-gray-700">Folio Copia</label>
      <input type="text" name="folio" required value="<?= $fila['folioCopia'] ?>"
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087]">
    </div>
    <!-- Usuario Solicitante -->
     <div>
      <label class="block text-sm font-medium text-gray-700">Usuario Solicitante</label>
      <input type="text" name="numCredS" required value="<?= $fila['numSolicitante'] ?>"
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
      <a href="detalle_prestamo.php?pkPrestamo=<?= $fila['pkPrestamo'] ?>"
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
