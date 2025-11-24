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
include('../clases/Multa.php');
include('../clases/Prestamo.php');

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

// Listar préstamos activos
$prestamos = $prestamo->verPrestamo(); // todos los prestamos disponibles
?>

<!-- Mensaje de éxito/error -->
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

    <!-- Código Multa -->
    <div>
      <label class="block text-sm font-medium text-gray-700">Código Multa</label>
      <input type="text" name="codigoMulta" required
        value="<?= $fila['codigoMulta'] ?>"
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087]">
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
      <input type="number" step="0.01" name="montoMulta" value="<?= $fila['montoMulta'] ?>"
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087]">
    </div>

    <!-- Fecha Registro -->
    <div>
      <label class="block text-sm font-medium text-gray-700">Fecha Registro</label>
      <input type="date" name="fechaRegistro" value="<?= $fila['fechaRegistro'] ?>"
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087]">
    </div>

    <!-- Fecha Pago -->
    <div>
      <label class="block text-sm font-medium text-gray-700">Fecha Pago</label>
      <input type="date" name="fechaPago" value="<?= $fila['fechaPago'] ?>"
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087]">
    </div>

    <!-- Préstamo -->
    <div class="md:col-span-2">
      <label class="block text-sm font-medium text-gray-700">Préstamo</label>
      <select name="fkPrestamo" required class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087] bg-white">
        <option value="">Seleccione un préstamo</option>
        <?php foreach ($prestamos as $p): ?>
          <option value="<?= $p['pkPrestamo'] ?>" <?= $p['pkPrestamo']==$fila['fkPrestamo'] ? 'selected' : '' ?>>
            <?= $p['codigoPrestamo'] ?> (<?= $p['numSolicitante'] ?>)
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <!-- Estatus -->
    <div class="md:col-span-2">
      <label class="block text-sm font-medium text-gray-700">Estatus</label>
      <select name="estatus" class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087] bg-white">
        <option value="A" <?= $fila['estatus']=='A' ? 'selected' : '' ?>>Activo</option>
        <option value="P" <?= $fila['estatus']=='P' ? 'selected' : '' ?>>Pendiente</option>
      </select>
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
