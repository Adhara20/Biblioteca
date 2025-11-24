<?php
include('../includes/header.php');
include('../clases/nacionalidad.php');

$clase = new Nacionalidad();

// Validar que llegue el PK
$pk = $_GET['pkNacionalidad'] ?? null;

if (!$pk) {
    echo "<p>No se especificó la nacionalidad.</p>";
    exit;
}

$resultado = $clase->detalles($pk);

if (!$resultado || $resultado->num_rows === 0) {
    echo "<p>No se encontró la nacionalidad.</p>";
    exit;
}

$fila = $resultado->fetch_assoc();
?>

<body class="bg-gray-100 text-gray-900">
<?php include('../includes/menu.php'); ?>

<div class="w-full max-w-4xl mx-auto mt-8 bg-white shadow-lg rounded-xl p-8 border border-gray-300">

  <h1 class="titulos">Editar Nacionalidad</h1>
  <hr class="linea-separadora mb-6">

  <form action="../controladores/actualizar_nacionalidad.php" method="POST">

    <!-- PK OCULTO -->
    <input type="hidden" name="pkNacionalidad" value="<?= $fila['pkNacionalidad'] ?>">

    <!-- NOMBRE -->
    <div class="mb-6">
      <label class="block font-semibold text-gray-700 mb-1">Nombre</label>
      <input 
        type="text" 
        name="nombre" 
        value="<?= htmlspecialchars($fila['nombreNaci']) ?>"
        class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring focus:ring-purple-200"
        required
      >
    </div>

    <!-- BOTONES -->
    <div class="flex justify-end gap-3">
      <a href="detalle_nacionalidad.php?pkNacionalidad=<?= $fila['pkNacionalidad'] ?>" 
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

