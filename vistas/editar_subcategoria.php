<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar SubCategoria</title>
</head>

<?php include('../includes/header.php'); ?>

<body class="bg-gray-100 text-gray-900">

<?php include('../includes/menu.php'); ?>

<?php
include('../clases/subcategoria.php');
$clase = new Subcategoria();

$pkSubCategoria = $_GET['pkSubCategoria'] ?? null;

if (!$pkSubCategoria) {
    echo "<p>No se especificó la subcategoria.</p>";
    exit;
}

// Usas tu función "detalles" como pediste
$resultado = $clase->detalles($pkSubCategoria);

if ($resultado && $resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
} else {
    echo "<p>No se encontró la subcategoria</p>";
    exit;
}

// Determinar imagen actual
$imgRuta = !empty($fila['iconoSubCategoria']) 
    ? "../imagenes/subcategorias/" . $fila['iconoSubCategoria']
    : "../imagenes/subcategorias/placeholder.png";
?>

<?php
include('../clases/categoria.php');

$categoria = new Categoria();

$listaCategorias = $categoria->mostrar();

?>

<!-- MENSAJE DE Exito -->
<?php include('../includes/notificacion.php') ?>


<!-- TÍTULO -->
<div class="w-full flex flex-col items-start px-8 mt-8">
  <div class="w-full max-w-4xl mx-auto">
      <h1 class="titulos">Editar SubCategoria</h1>
      <hr class="linea-separadora mb-6">
  </div>
</div>

<!-- CONTENEDOR PRINCIPAL -->
<div class="w-full max-w-5xl bg-white shadow-lg rounded-2xl p-8 lg:p-12 border border-gray-300 mx-auto mb-10">

  <h2 class="text-2xl font-semibold text-center text-[#4F0087] mb-6">
      Formulario SubCategoria
  </h2>

  <form action="../controladores/actualizar_subcategoria.php" method="POST" enctype="multipart/form-data" 
        class="grid grid-cols-1 md:grid-cols-2 gap-4">

    <!-- PK -->
    <input type="hidden" name="pkSubCategoria" value="<?= $fila['pkSubCategoria'] ?>">

    <!-- PORTADA ACTUAL (para el controlador) -->
    <input type="hidden" name="iconoSubCategoriaActual" value="<?= $fila['iconoSubCategoria'] ?>">

    <!-- TÍTULO -->
    <div>
      <label class="block text-sm font-medium text-gray-700">Nombre</label>
      <input type="text" name="nombreSubCategoria" required
        value="<?= $fila['nombreSubCategoria'] ?>"
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087] uppercase">
    </div>

        <div>
      <label class="block text-sm font-medium text-gray-700">Abreviarura</label>
      <input type="text" name="abreviatura" minlength="3" maxlength="3" required 
        value="<?= $fila['abreviatura'] ?>"
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087] uppercase">
    </div>

        <!-- AUTOR -->
    <div>
      <label class="block text-sm font-medium text-gray-700">Categoria</label>
      <select name="fkCategoria" required
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087] bg-white">
        <option value="">Seleccione una categoria</option>

        <?php foreach ($listaCategorias as $a) { ?>
          <option value="<?= $a['pkCategoria'] ?>"
            <?= $a['pkCategoria'] == $fila['fkCategoria'] ? 'selected' : '' ?>>
            <?= $a['nombreCategoria'] ?>
          </option>
        <?php } ?>
      </select>
    </div>
  
    <!-- PORTADA: Mostrar actual + subir nueva -->
    <div>
      <label class="block text-sm font-medium text-gray-700">Icono actual</label>

      <img src="<?= $imgRuta ?>" class="w-40 h-56 object-cover border rounded-md shadow mt-2">

      <label class="block text-sm font-medium text-gray-700 mt-3">Subir nuevo icono (opcional)</label>
      <input type="file" name="iconoSubCategoria" class="w-full mt-1 p-2 border rounded-md bg-white">
    </div>

    <!-- BOTONES -->
    <div class="md:col-span-2 flex flex-col gap-3 md:flex-row md:justify-end mt-4">
      <a href="detalle_categoria.php?pkSubCategoria=<?= $fila['pkSubCategoria'] ?>"
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
