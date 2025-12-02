<?php
require_once('../includes/auth.php');

// Solo Admin y Bibliotecario
requireRole(['A', 'B']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Copia</title>
</head>

<?php include('../includes/header.php'); ?>

<body class="bg-gray-100 text-gray-900">

<?php include('../includes/menu.php'); ?>

<?php
include('../clases/copia.php');
$clase = new Copia();

$pkCopiaF = $_GET['pkCopiaF'] ?? null;

if (!$pkCopiaF) {
    echo "<p>No se especificó la copia.</p>";
    exit;
}

// Usas tu función "detalles" como pediste
$resultado = $clase->detalles($pkCopiaF);

if ($resultado && $resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
} else {
    echo "<p>No se encontró la copia.</p>";
    exit;
}

// Determinar imagen actual
$imgRuta = !empty($fila['portada']) 
    ? "../imagenes/portadas/" . $fila['portada']
    : "../imagenes/portadas/placeholder.png";
?>



<!-- MENSAJE DE Exito -->
<?php include('../includes/notificacion.php') ?>


<!-- TÍTULO -->
<div class="w-full flex flex-col items-start px-8 mt-8">
  <div class="w-full max-w-4xl mx-auto">
      <h1 class="titulos">Editar Copia</h1>
      <hr class="linea-separadora mb-6">
  </div>
</div>

<!-- CONTENEDOR PRINCIPAL -->
<div class="w-full max-w-5xl bg-white shadow-lg rounded-2xl p-8 lg:p-12 border border-gray-300 mx-auto mb-10">

  <h2 class="text-2xl font-semibold text-center text-[#4F0087] mb-6">
      Formulario Copia
  </h2>

  <form action="../controladores/actualizar_copia.php" method="POST" enctype="multipart/form-data" 
        class="grid grid-cols-1 md:grid-cols-2 gap-4">

    <!-- PK -->
    <input type="hidden" name="pkCopiaF" value="<?= $fila['pkCopiaF'] ?>">

    <!-- PORTADA ACTUAL (para el controlador) -->
    <input type="hidden" name="portadaActual" value="<?= $fila['portada'] ?>">

    <!-- ISBN -->
    <div>
      <label class="block text-sm font-medium text-gray-700">ISBN</label>
      <input type="text" name="isbn" required
        value="<?= $fila['isbn'] ?>"
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087]">
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700">Observaciones</label>
      <textarea name="observaciones" rows="4" placeholder="Observaciones"
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087]"><?= $fila['observaciones'] ?></textarea>
    </div>

    <!-- BOTONES -->
    <div class="md:col-span-2 flex flex-col gap-3 md:flex-row md:justify-end mt-4">
      <a href="detalle_copia.php?pkCopiaF=<?= $fila['pkCopiaF'] ?>"
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
