<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lista de Usuarios</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

<?php
include('../clases/usuario.php');
$clase = new Usuario();
$resultadoA = $clase->listaActivos();
$resultadoI = $clase->listaInactivos();
?>

<div class="max-w-6xl mx-auto mt-10 px-4">
  <!-- Activos -->
  <h1 class="text-2xl font-bold text-[#4F0087] mb-4 text-center">Usuarios Activos</h1>

  <?php if (isset($_GET['success'])) { ?>
    <div class="bg-green-100 text-green-800 p-3 rounded-md mb-4 font-semibold">
      <?= htmlspecialchars($_GET['success']) ?>
    </div>
  <?php } ?>

  <ul role="list" class="divide-y divide-gray-200 bg-white rounded-xl shadow-sm">
    <?php foreach ($resultadoA as $fila) {
      $rolTraducido = match($fila["rol"]) {
        'A' => 'Administrador',
        'B' => 'Bibliotecario',
        'L' => 'Lector',
        default => 'Desconocido'
      };
    ?>
      <li class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-4 hover:bg-gray-50 transition">
        <div class="flex-1">
          <p class="text-lg font-semibold text-[#4F0087]"><?= htmlspecialchars($fila["nombreCompleto"]) ?></p>
          <p class="text-sm text-gray-600"><?= htmlspecialchars($fila["curp"]) ?></p>
          <p class="text-xs text-gray-500">Núm. Credencial: <?= htmlspecialchars($fila["numCredencial"]) ?></p>
        </div>
        <div class="text-sm text-right">
          <p class="font-medium"><?= $rolTraducido ?></p>
          <p class="text-gray-500">Edad: <?= $clase->obtenerEdad($fila["fechaNac"]) ?></p>
          <p class="text-xs text-gray-400">Nacido el <?= htmlspecialchars($fila["fechaNac"]) ?></p>
        </div>
        <div class="mt-2 sm:mt-0">
          <button class="text-sm bg-[#4F0087] text-white px-3 py-1 rounded-md hover:bg-[#3a0065]">Editar</button>
        </div>
      </li>
    <?php } ?>
  </ul>
</div>

<!-- Inactivos -->
<div class="max-w-6xl mx-auto mt-10 px-4">
  <h1 class="text-2xl font-bold text-gray-700 mb-4 text-center">Usuarios Inactivos</h1>
  <ul role="list" class="divide-y divide-gray-200 bg-gray-100 rounded-xl shadow-sm">
    <?php foreach ($resultadoI as $fila) {
      $rolTraducido = match($fila["rol"]) {
        'A' => 'Administrador',
        'B' => 'Bibliotecario',
        'L' => 'Lector',
        default => 'Desconocido'
      };
    ?>
      <li class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-4 hover:bg-gray-200 transition">
        <div class="flex-1">
          <p class="text-lg font-semibold text-gray-700"><?= htmlspecialchars($fila["nombreCompleto"]) ?></p>
          <p class="text-sm text-gray-500"><?= htmlspecialchars($fila["curp"]) ?></p>
          <p class="text-xs text-gray-400">Núm. Credencial: <?= htmlspecialchars($fila["numCredencial"]) ?></p>
        </div>
        <div class="text-sm text-right">
          <p class="font-medium"><?= $rolTraducido ?></p>
          <p class="text-gray-500">Edad: <?= $clase->obtenerEdad($fila["fechaNac"]) ?></p>
        </div>
        <div class="mt-2 sm:mt-0">
          <button class="text-sm bg-gray-500 text-white px-3 py-1 rounded-md hover:bg-gray-600">Reactivar</button>
        </div>
      </li>
    <?php } ?>
  </ul>
</div>

</body>
</html>
