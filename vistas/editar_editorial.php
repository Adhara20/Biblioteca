<?php
require_once('../includes/auth.php');

// Solo Admin y Bibliotecario
requireRole(['A', 'B']);
?>

<?php
include('../includes/header.php');
include('../clases/editorial.php');
include('../clases/nacionalidad.php');

$editorial = new Editorial();
$nacionalidad = new Nacionalidad();

$pk = $_GET['pkEditorial'] ?? null;

if (!$pk) {
    echo "<p>No se especificó la editorial.</p>";
    exit;
}

$resultado = $editorial->detalles($pk);

if (!$resultado || $resultado->num_rows === 0) {
    echo "<p>No se encontró la editorial.</p>";
    exit;
}

$fila = $resultado->fetch_assoc();
$listaN = $nacionalidad->listaNacionalidades();
?>

<body class="bg-gray-100 text-gray-900">
<?php include('../includes/menu.php'); ?>

<div class="w-full max-w-4xl mx-auto mt-8 bg-white shadow-lg rounded-xl p-8 border border-gray-300">

  <h1 class="titulos">Editar Editorial</h1>
  <hr class="linea-separadora mb-6">

  <form action="../controladores/actualizar_editorial.php" method="POST">
    
    <input type="hidden" name="pkEditorial" value="<?= $fila['pkEditorial'] ?>">

    <div class="mb-6">
      <label class="block font-semibold text-gray-700 mb-1">Nombre</label>
      <input 
        type="text" 
        name="nombreEditorial" 
        value="<?= htmlspecialchars($fila['nombreEditorial']) ?>"
        class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring focus:ring-purple-200"
        required>
    </div>

    <div class="mb-6">
      <label class="block font-semibold text-gray-700 mb-1">Nacionalidad</label>
      <select name="fkNacionalidad" class="w-full border border-gray-300 px-4 py-2 rounded-lg">
        <?php foreach ($listaN as $n): ?>
          <option value="<?= $n['pkNacionalidad'] ?>" 
            <?= $n['pkNacionalidad'] == $fila['fkNacionalidad'] ? 'selected' : '' ?>>
            <?= $n['nombreNaci'] ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="flex justify-end gap-3">
      <a href="detalle_editorial.php?pkEditorial=<?= $fila['pkEditorial'] ?>" 
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
