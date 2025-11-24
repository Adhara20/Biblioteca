<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Autor</title>
</head>

<?php include('../includes/header.php'); ?>

<body class="bg-gray-100 text-gray-900">

<?php include('../includes/menu.php'); ?>

<?php
include('../clases/autor.php');
$clase = new Autor();

$pkAutor = $_GET['pkAutor'] ?? null;

if (!$pkAutor) {
    echo "<p>No se especificó la subcategoria.</p>";
    exit;
}

// Usas tu función "detalles" como pediste
$resultado = $clase->detalles($pkAutor);

if ($resultado && $resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
} else {
    echo "<p>No se encontró el Autor</p>";
    exit;
}

// Determinar imagen actual
// $imgRuta = !empty($fila['iconoSubCategoria']) 
//     ? "../imagenes/subcategorias/" . $fila['iconoSubCategoria']
//     : "../imagenes/subcategorias/placeholder.png";
?>

<?php
include('../clases/Nacionalidad.php');

$nacionalidad = new Nacionalidad();

$listaNacionalidades = $nacionalidad->listaNacionalidades();

?>

<!-- MENSAJE DE Exito -->
<?php include('../includes/notificacion.php') ?>


<!-- TÍTULO -->
<div class="w-full flex flex-col items-start px-8 mt-8">
  <div class="w-full max-w-4xl mx-auto">
      <h1 class="titulos">Editar Autor</h1>
      <hr class="linea-separadora mb-6">
  </div>
</div>

<!-- CONTENEDOR PRINCIPAL -->
<div class="w-full max-w-5xl bg-white shadow-lg rounded-2xl p-8 lg:p-12 border border-gray-300 mx-auto mb-10">

  <h2 class="text-2xl font-semibold text-center text-[#4F0087] mb-6">
      Formulario Autor
  </h2>

  <form action="../controladores/actualizar_autor.php" method="POST" enctype="multipart/form-data" 
        class="grid grid-cols-1 md:grid-cols-2 gap-4">

    <!-- PK -->
    <input type="hidden" name="pkAutor" value="<?= $fila['pkAutor'] ?>">

    <div>
      <label class="block text-sm font-medium text-gray-700">Nombre</label>
      <input type="text" name="nombreAutor" required
        value="<?= $fila['nombreAutor'] ?>"
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087] uppercase">
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700">Nacionalidad</label>
      <select name="fkNacionalidad" required
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087] bg-white">
        <option value="">Seleccione una nacionalidad</option>

        <?php foreach ($listaNacionalidades as $a) { ?>
          <option value="<?= $a['pkNacionalidad'] ?>"
            <?= $a['pkNacionalidad'] == $fila['fkNacionalidad'] ? 'selected' : '' ?>>
            <?= $a['nombreNaci'] ?>
          </option>
        <?php } ?>
      </select>
    </div>
  
    <!-- BOTONES -->
    <div class="md:col-span-2 flex flex-col gap-3 md:flex-row md:justify-end mt-4">
      <a href="detalle_autor.php?pkAutor=<?= $fila['pkAutor'] ?>"
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
