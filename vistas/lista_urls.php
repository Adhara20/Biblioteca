<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>URLs</title>
    <link rel="stylesheet" href="../css/listas.css">
    <link rel="stylesheet" href="../css/filtros.css">
</head>

<?php
include('../clases/url.php');

$urlObj = new URL();

// Recuperar filtros enviados por GET
$buscar = $_GET['buscar'] ?? '';
$estatusFiltro = $_GET['estatus'] ?? '';

// Obtener resultados según filtros
$resultado = $urlObj->listaURLs();

include('../includes/header.php');
?>

<body>
<?php include('../includes/menu.php'); ?>

<!-- Titulo y Botón -->
<div class="px-10 mb-6">
    <div class="flex items-center justify-between">
        <h1 class="titulos">Registro de URLs</h1>

        <div class="flex items-center">
            <a href="formulario_url.php" 
               class="rounded-md text-white font-medium transition bg-[#3BAA8D] hover:bg-[#abe4d5] hover:text-[#3BAA8D] border hover:border-[#3BAA8D]  shadow-sm px-4 py-2 w-full sm:w-40 text-center">
               Agregar URL
            </a>
        </div>
    </div>
    <hr class="linea-separadora-listas">
</div>

<!-- Mensajes -->
<?php include('../includes/notificacion.php'); ?>

<section class="grid-listas">
<?php if (!empty($resultado)): ?>
  <?php foreach ($resultado as $fila): 
    $url = htmlspecialchars($fila['url']);
    $tituloLibro = !empty($fila['nombreLibro']) ? htmlspecialchars($fila['nombreLibro']) : 'Sin libro';

    // Estatus y color
    $estatus = 'ACTIVO';
    $colorEstatus = 'text-green-500 font-semibold [text-shadow:0_2px_4px_rgba(0,0,0,.3)]';
    if (isset($fila['estatus']) && $fila['estatus'] !== 'A') {
        $estatus = 'INACTIVO';
        $colorEstatus = 'text-red-500 font-semibold [text-shadow:0_2px_4px_rgba(0,0,0,.3)]';
    }
  ?>
  <div class="relative overflow-visible bg-white rounded-xl shadow p-4 flex flex-col gap-2 hover:shadow-md transition group w-full max-w-[520px] border-[3px] border-[<?= $colorEstatus ?>]">

    <!-- Botón tres puntos -->
    <?php if (!isset($fila['estatus']) || $fila['estatus'] === 'A'): ?>
    <button class="absolute right-4 top-1/2 -translate-y-1/2 p-2 rounded hover:bg-gray-200 z-20 btn-kebab"
        onclick="event.stopPropagation(); toggleKebab(this)" aria-label="Abrir acciones">
        <img src="/Biblioteca/imagenes/btn Iconos/btnAcciones.png" class="size-6" alt="Acciones">
    </button>

    <div class="menu-kebab hidden absolute right-4 top-14 bg-white shadow-lg rounded-lg border w-40 z-30">
        <a href="../controladores/desactivar_url.php?pkURL=<?= $fila['pkURL'] ?>" class="flex items-center gap-2 w-full text-left px-4 py-2 hover:bg-gray-100 hover:text-red-400" onclick="event.stopPropagation();">
            <img src="/Biblioteca/imagenes/btn Iconos/btbBaja.png" class="size-4">
            <span class="text-sm/6">Desactivar</span>
        </a>
    </div>
    <?php endif; ?>

    <!-- Contenido de la tarjeta -->
    <div class="flex flex-col gap-1 flex-1">
        <h2 class="text-lg font-bold text-purple-900"><?= $url ?></h2>
        <p class="text-sm text-gray-600"><strong>Libro:</strong> <?= $tituloLibro ?></p>
        <p class="text-sm <?= $colorEstatus ?>"><?= $estatus ?></p>
    </div>

  </div>
  <?php endforeach; ?>
<?php else: ?>
  <p class="no-resultados">No se encontraron URLs.</p>
<?php endif; ?>
</section>

<!-- Script kebab -->
<script>
function toggleKebab(btn){
    document.querySelectorAll(".menu-kebab").forEach(menu => {
        if(menu !== btn.nextElementSibling) menu.classList.add("hidden");
    });
    btn.nextElementSibling.classList.toggle("hidden");
}

// cerrar kebab si da click fuera
document.addEventListener("click", function(e){
    const isKebabButton = e.target.closest(".btn-kebab");
    const isMenu = e.target.closest(".menu-kebab");
    if(!isKebabButton && !isMenu){
        document.querySelectorAll(".menu-kebab").forEach(menu => menu.classList.add("hidden"));
    }
});
</script>

<?php include('../includes/footer.php'); ?>
</body>
</html>
