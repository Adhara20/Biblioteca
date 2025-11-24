<?php 
include('../includes/header.php');
include('../clases/nacionalidad.php');

$clase = new Nacionalidad();
$pk = $_GET['pkNacionalidad'] ?? null;

if (!$pk) {
    echo "<p>No se especificó la nacionalidad.</p>";
    exit;
}

$resultado = $clase->detalles($pk);

if ($resultado && $resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
} else {
    echo "<p>No se encontró la nacionalidad.</p>";
    exit;
}

// Definir estatus y color
if ($fila['estatus'] === 'A') {
    $estatus = 'ACTIVO';
    $colorEstatus = 'text-green-500 font-semibold [text-shadow:0_2px_4px_rgba(0,0,0,.3)]';
} else {
    $estatus = 'INACTIVO';
    $colorEstatus = 'text-red-500 font-semibold [text-shadow:0_2px_4px_rgba(0,0,0,.3)]';
}
?>

<body class="bg-gray-100 text-gray-900">
<?php include('../includes/menu.php'); ?>

<div class="w-full flex flex-col items-start px-8 mt-8">
  <div class="w-full max-w-4xl mx-auto">
    <h1 class="titulos">Detalles de Nacionalidad</h1>
    <hr class="linea-separadora mb-6">
  </div>
</div>

<div class="w-full max-w-5xl bg-white shadow-lg rounded-2xl p-8 border border-gray-300 mb-12 mx-auto flex flex-col md:flex-row gap-8">

  <!-- Contenido de la tarjeta -->
  <div class="flex-1">
    <div class="mb-6 text-center md:text-left">
      <h2 class="text-2xl font-semibold text-[#4F0087]"><?= htmlspecialchars($fila['nombreNaci']) ?></h2>
      <p class="text-gray-600">Información General</p>
    </div>

    <div class="border-t border-gray-300 pt-4">
      <dl class="divide-y divide-gray-200">

        <div class="py-3 grid grid-cols-3 gap-4">
          <dt class="font-medium text-gray-700">Clave:</dt>
          <dd class="col-span-2 text-gray-800"><?= $fila['pkNacionalidad'] ?></dd>
        </div>

        <div class="py-3 grid grid-cols-3 gap-4">
          <dt class="font-medium text-gray-700">Nombre:</dt>
          <dd class="col-span-2 text-gray-800"><?= htmlspecialchars($fila['nombreNaci']) ?></dd>
        </div>

        <!-- Estatus con color -->
        <div class="py-3 grid grid-cols-3 gap-4">
          <dt class="font-medium text-gray-700">Estatus:</dt>
          <dd class="col-span-2 <?= $colorEstatus ?>"><?= $estatus ?></dd>
        </div>

      </dl>
    </div>

    <!-- Botones de acción -->
    <div class="flex justify-end gap-3 mt-8">
      <a href="editar_nacionalidad.php?pkNacionalidad=<?= $fila['pkNacionalidad'] ?>" 
         class="px-4 py-2.5 rounded-md text-white font-medium transition bg-[#5780B5] hover:bg-[#6b92c2] shadow-sm">
        Editar
      </a>

      <?php if ($fila['estatus'] === 'A'): ?>
        <a href="../controladores/desactivar_nacionalidad.php?pkNacionalidad=<?= $fila['pkNacionalidad'] ?>" 
           class="px-4 py-2.5 rounded-md text-white font-medium transition bg-[#B55780] hover:bg-[#c46b93] shadow-sm">
          Dar de baja
        </a>
      <?php else: ?>
        <a href="../controladores/activar_nacionalidad.php?pkNacionalidad=<?= $fila['pkNacionalidad'] ?>" 
           class="px-4 py-2.5 rounded-md text-white font-medium transition bg-[#4FAF8C] hover:bg-[#5BBE9A] shadow-sm">
          Activar
        </a>
      <?php endif; ?>
    </div>
  </div>
</div>
 
<?php include('../includes/footer.php'); ?>
</body>
</html>
