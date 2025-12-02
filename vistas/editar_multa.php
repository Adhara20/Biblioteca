<?php
require_once('../includes/auth.php');

// Solo Admin y Bibliotecario
requireRole(['A', 'B']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Multa</title>
</head>

<?php include('../includes/header.php'); ?>
<body class="bg-gray-100 text-gray-900">
<?php include('../includes/menu.php'); ?>

<?php
include('../clases/multa.php');
include('../clases/prestamo.php');

$clase = new Multa();
$prestamo = new Prestamo();

$pkMulta = $_GET['pkMulta'] ?? null;
if (!$pkMulta) {
    echo "<p>No se especificó la multa.</p>";
    exit;
}

$resultado = $clase->detalles($pkMulta);
if ($resultado && $resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
} else {
    echo "<p>No se encontró la multa.</p>";
    exit;
}
?>

<?php include('../includes/notificacion.php') ?>

<div class="w-full flex flex-col items-start px-8 mt-8">
  <div class="w-full max-w-4xl mx-auto">
      <h1 class="titulos">Editar Multa</h1>
      <hr class="linea-separadora mb-6">
  </div>
</div>

<div class="w-full max-w-5xl bg-white shadow-lg rounded-2xl p-8 lg:p-12 border border-gray-300 mx-auto mb-10">
  <h2 class="text-2xl font-semibold text-center text-[#4F0087] mb-6">
      Formulario Multa
  </h2>

  <form action="../controladores/actualizar_multa.php" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">

    <!-- PK -->
    <input type="hidden" name="pkMulta" value="<?= $fila['pkMulta'] ?>">

    <!-- Código Multa (solo lectura) -->
    <div>
      <label class="block text-sm font-medium text-gray-700">Código Multa</label>
      <input type="text" name="codigoMulta" value="<?= $fila['codigoMulta'] ?>" 
        readonly
        class="w-full mt-1 p-2 border rounded-md bg-gray-100 cursor-not-allowed">
    </div>

    <!-- Tipo Multa -->
    <div>
      <label class="block text-sm font-medium text-gray-700">Tipo de Multa</label>
      <select name="tipoMulta" required class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087] bg-white">
        <option value="Retraso" <?= $fila['tipoMulta']=='Retraso' ? 'selected' : '' ?>>Retraso</option>
        <option value="Daño" <?= $fila['tipoMulta']=='Daño' ? 'selected' : '' ?>>Daño</option>
        <option value="Perdido" <?= $fila['tipoMulta']=='Perdido' ? 'selected' : '' ?>>Perdido</option>
      </select>
    </div>

    <!-- Monto -->
    <div>
      <label class="block text-sm font-medium text-gray-700">Monto</label>
      <input type="number" step="0.01" min="0" max="9999.99" name="montoMulta" 
        value="<?= $fila['montoMulta'] ?>"
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087]">
    </div>

    <!-- Fecha Registro (solo lectura) -->
    <div>
      <label class="block text-sm font-medium text-gray-700">Fecha Registro</label>
      <input type="date" value="<?= $fila['fechaRegistro'] ?>" readonly
        class="w-full mt-1 p-2 border rounded-md bg-gray-100 cursor-not-allowed">
    </div>

    <!-- Préstamo (solo lectura) -->
    
    <input type="hidden" name="codigoPrestamo" value="<?= $fila['codigoPrestamo'] ?>">

    

    <div>
      <label class="block text-sm font-medium text-gray-700">Préstamo Asociado</label>
      <input type="text" value="<?= $fila['fkPrestamo'] ?> - <?= $fila['codigoPrestamo'] ?? '' ?>" 
        readonly
        class="w-full mt-1 p-2 border rounded-md bg-gray-100 cursor-not-allowed">
    </div>
  <!-- Credencial del UsuarioMultado -->
    <div >
      <label class="block text-sm font-medium text-gray-700">Usuario Asociado</label>
      <input type="text" value="<?= $fila['numCredencial'] ?? '' ?>" 
        readonly
        class="w-full mt-1 p-2 border rounded-md bg-gray-100 cursor-not-allowed">
    </div>

    <!-- Botones -->
    <div class="md:col-span-2 flex flex-col gap-3 md:flex-row md:justify-end mt-4">
      <a href="detalle_multa.php?pkMulta=<?= $fila['pkMulta'] ?>"
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
