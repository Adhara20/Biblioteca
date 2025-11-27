<?php 
include('../includes/header.php');
include('../clases/Multa.php');

$clase = new Multa();
$pk = $_GET['pkMulta'] ?? null;

if (!$pk) {
    echo "<p>No se especificó la multa.</p>";
    exit;
}

$resultado = $clase->detalles($pk);

if ($resultado && $resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
} else {
    echo "<p>No se encontró la multa.</p>";
    exit;
}

// Estatus y color
if ($fila['estatus'] === 'A') {
    $estatus = 'PENDIENTE';
    $colorEstatus = 'text-red-500 font-semibold [text-shadow:0_2px_4px_rgba(0,0,0,.3)]';
} else {
    $estatus = 'PAGADA';
    $colorEstatus = 'text-green-500 font-semibold [text-shadow:0_2px_4px_rgba(0,0,0,.3)]';
}
?>

<body class="bg-gray-100 text-gray-900">
<?php include('../includes/menu.php'); ?>

<div class="w-full flex flex-col items-start px-8 mt-8">
  <div class="w-full max-w-4xl mx-auto">
    <h1 class="titulos">Detalles de Multa</h1>
    <hr class="linea-separadora mb-6">
  </div>
</div>

<div class="w-full max-w-5xl bg-white shadow-lg rounded-2xl p-8 border border-gray-300 mb-12 mx-auto flex flex-col gap-8">

  <!-- Contenido de la tarjeta -->
  <div class="flex-1">
    <div class="mb-6 text-center md:text-left">
      <h2 class="text-2xl font-semibold text-[#4F0087]">Multa #<?= htmlspecialchars($fila['codigoMulta']) ?></h2>
      <p class="text-gray-600">Información General</p>
    </div>

    <div class="border-t border-gray-300 pt-4">
      <dl class="divide-y divide-gray-200">

        <div class="py-3 grid grid-cols-3 gap-4">
          <dt class="font-medium text-gray-700">Código:</dt>
          <dd class="col-span-2"><?= htmlspecialchars($fila['codigoMulta']) ?></dd>
        </div>

        <div class="py-3 grid grid-cols-3 gap-4">
          <dt class="font-medium text-gray-700">Usuario:</dt>
          <dd class="col-span-2"><?= htmlspecialchars($fila['numCredencial']) ?></dd>
        </div>

        <div class="py-3 grid grid-cols-3 gap-4">
          <dt class="font-medium text-gray-700">Tipo:</dt>
          <dd class="col-span-2"><?= htmlspecialchars($fila['tipoMulta']) ?></dd>
        </div>

        <div class="py-3 grid grid-cols-3 gap-4">
          <dt class="font-medium text-gray-700">Monto:</dt>
          <dd class="col-span-2">$<?= htmlspecialchars($fila['montoMulta']) ?></dd>
        </div>

        <div class="py-3 grid grid-cols-3 gap-4">
          <dt class="font-medium text-gray-700">Registrada:</dt>
          <dd class="col-span-2"><?= htmlspecialchars($fila['fechaRegistro']) ?></dd>
        </div>

        <div class="py-3 grid grid-cols-3 gap-4">
          <dt class="font-medium text-gray-700">Pagada el:</dt>
          <dd class="col-span-2"><?= htmlspecialchars($fila['fechaPago'] ?? '—') ?></dd>
        </div>

        <div class="py-3 grid grid-cols-3 gap-4">
          <dt class="font-medium text-gray-700">Préstamo:</dt>
          <dd class="col-span-2"><?= htmlspecialchars($fila['codigoPrestamo']) ?></dd>
        </div>

        <div class="py-3 grid grid-cols-3 gap-4">
          <dt class="font-medium text-gray-700">Estatus:</dt>
          <dd class="col-span-2 <?= $colorEstatus ?>"><?= $estatus ?></dd>
        </div>

      </dl>
    </div>
<?php if($fila['estatus']== 'A' && $rol!='L'  && $estatusLog=='A'): ?>
    <!-- Botones de acción -->
    <div class="flex justify-end gap-3 mt-8">
      <a href="editar_multa.php?pkMulta=<?= $fila['pkMulta'] ?>" 
         class="px-4 py-2.5 rounded-md text-white font-medium transition bg-[#5780B5] hover:bg-[#6b92c2] shadow-sm">
        Editar
      </a>
        <a href="../controladores/pagar_multa.php?pkMulta=<?= $fila['pkMulta'] ?>" 
           class="px-4 py-2.5 rounded-md text-white font-medium transition bg-[#4FAF8C] hover:bg-[#5BBE9A] shadow-sm">
          Marcar como Pagada
        </a>

        <a href="../controladores/cancelar_multa.php?pkMulta=<?= $fila['pkMulta'] ?>" 
          class="px-4 py-2.5 rounded-md text-white font-medium transition bg-[#B55780] hover:bg-[#c46b93] shadow-sm">
          Cancelar
        </a>
 
    </div>
    <?php endif; ?>
  </div>
</div>

<?php include('../includes/footer.php'); ?>
</body>
</html>

