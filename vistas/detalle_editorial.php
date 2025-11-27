<?php 
include('../includes/header.php');
include('../clases/editorial.php');

$clase = new Editorial();
$pk = $_GET['pkEditorial'] ?? null;

if (!$pk) {
    echo "<p>No se especificó la editorial.</p>";
    exit;
}

$resultado = $clase->detalles($pk);

if ($resultado && $resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
} else {
    echo "<p>No se encontró la editorial.</p>";
    exit;
}

// --- Imagen de la editorial (opcional) ---
$imgRuta = !empty($fila['logo']) 
    ? "../imagenes/editoriales/{$fila['logo']}" 
    : "../imagenes/portadas/placeholder.png";

// --- Estatus con color ---
if($fila['estatus'] == 'A'){
    $estatus ='ACTIVO';
    $colorEstatus= 'text-green-500 font-semibold [text-shadow:0_2px_4px_rgba(0,0,0,.3)]';
}else{
    $estatus ='INACTIVO';
    $colorEstatus= 'text-red-400 font-semibold [text-shadow:0_2px_4px_rgba(0,0,0,.3)]';
}
?>

<body class="bg-gray-100 text-gray-900">
<?php include('../includes/menu.php'); ?>

<!-- Título -->
<div class="w-full flex flex-col items-start px-8 mt-8">
  <div class="w-full max-w-4xl mx-auto">
    <h1 class="titulos">Detalles de Editorial</h1>
    <hr class="linea-separadora mb-6">
  </div>
</div>

<!-- Contenedor principal -->
<div class="w-full max-w-5xl bg-white shadow-lg rounded-2xl p-8 border border-gray-300 mb-12 mx-auto flex flex-col md:flex-row-reverse gap-8">

  <!-- Logo / Imagen editorial -->
  <div class="flex-shrink-0 w-full md:w-1/3 flex justify-center items-start">
    <img 
      src="<?= $imgRuta ?>" 
      alt="Logo de <?= htmlspecialchars($fila['nombreEditorial']) ?>" 
      class="rounded-xl shadow-md border border-gray-200 object-cover w-64 h-64 bg-gray-50"
    >
  </div>

  <!-- Datos de la editorial -->
  <div class="flex-1">
    <div class="mb-6 text-center md:text-left">
      <h2 class="text-2xl font-semibold text-[#4F0087]"><?= $fila['nombreEditorial'] ?></h2>
      <p class="text-gray-600">Información General</p>
    </div>

    <div class="border-t border-gray-300 pt-4">
      <dl class="divide-y divide-gray-200">

        <div class="py-3 grid grid-cols-3 gap-4">
          <dt class="font-medium text-gray-700">Clave:</dt>
          <dd class="col-span-2 text-gray-800"><?= $fila['pkEditorial'] ?></dd>
        </div>

        <div class="py-3 grid grid-cols-3 gap-4">
          <dt class="font-medium text-gray-700">Nombre:</dt>
          <dd class="col-span-2 text-gray-800"><?= $fila['nombreEditorial'] ?></dd>
        </div>

        <div class="py-3 grid grid-cols-3 gap-4">
          <dt class="font-medium text-gray-700">Nacionalidad:</dt>
          <dd class="col-span-2 text-gray-800"><?= $fila['nacionalidad'] ?></dd>
        </div>

        <div class="py-3 grid grid-cols-3 gap-4">
          <dt class="font-medium text-gray-700">Estatus:</dt>
          <dd class="col-span-2 <?= $colorEstatus ?>"><?= $estatus ?></dd>
        </div>

      </dl>
    </div>

    <!-- Botones de acción -->
    <?php if($rol == 'A' && $estatusLog == 'A'){ ?>
      <div class="flex justify-end gap-3 mt-8">
        
        <a href="editar_editorial.php?pkEditorial=<?= $fila['pkEditorial'] ?>" 
        class="px-4 py-2.5 rounded-md font-medium transition border border-[#5780B5] text-[#5780B5] bg-blue-200 
          hover:bg-[#5780B5] hover:text-blue-200  shadow-sm">
          Editar
        </a>

      <?php
          if($fila['estatus'] == 'A'){
        ?>      
                                                                                              <!-- class="px-4 py-2.5 rounded-md font-medium transition border border-[#5780B5] text-[#5780B5] bg-blue-200 
                                                                                              hover:bg-[#5780B5] hover:text-blue-200  shadow-sm"> -->
          <a href="../controladores/desactivar_editorial.php?pkEditorial=<?= $fila['pkEditorial'] ?>" class="px-4 py-2.5 rounded-md text-white font-medium transition bg-[#B55780] hover:bg-[#e5b6ca] hover:text-[#B55780] border hover:border-[#B55780] shadow-sm">
            Desactivar
          </a>
        <?php
          }else{
        ?>
       <a href="../controladores/activar_editorial.php?pkEditorial=<?= $fila['pkEditorial'] ?>" class=" px-4 py-2.5 rounded-md text-white font-medium transition
          bg-[#34B980] hover:bg-[#c0eed9] hover:text-[#34B980] border hover:border-[#34B980] shadow-sm">
            Activar
          </a>
        <?php } ?>
      </div>
      <?php } ?>

  </div>
</div>

<?php include('../includes/footer.php'); ?>
</body>
</html>
