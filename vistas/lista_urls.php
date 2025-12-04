<?php
require_once('../includes/auth.php');
requireRole(['A', 'B', 'L']);
?>
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
include('../controladores/filtrar_urls.php'); 
include('../includes/header.php');

$fklibro = $_GET['pkLibro'] ?? NULL;
$isbnLibro = $_GET['isbn'] ?? NULL;
?>

<body>
<?php include('../includes/menu.php'); ?>

<!-- Titulo y Botón -->
<div class="px-10 mb-6">
    <div class="flex items-center justify-between">
        <h1 class="titulos">Registro de URLs</h1>
      <?php if($rol != 'L' && $estatusLog == 'A'): ?>
        <div class="flex items-center">
          <?php if($isbnLibro): ?>
            <a href="formulario_url.php?pkLibro=<?= urlencode($fklibro) ?>&isbn=<?= urlencode($isbnLibro) ?>"
               class="rounded-md text-white font-medium transition bg-[#3BAA8D] hover:text-[#3BAA8D] hover:bg-[#abe4d5] border hover:border-[#3BAA8D] shadow-sm px-4 py-2 w-full sm:w-40 text-center">
               Agregar URL
            </a>
          <?php else: ?>
            <a href="formulario_url.php" 
               class="rounded-md text-white font-medium transition bg-[#3BAA8D] hover:text-[#3BAA8D] hover:bg-[#abe4d5] border hover:border-[#3BAA8D] shadow-sm px-4 py-2 w-full sm:w-40 text-center">
               Agregar URL
            </a>
          <?php endif; ?> 
        </div>
      <?php endif; ?> 
    </div>
    <hr class="linea-separadora-listas">
</div>

<!-- Mensajes -->
<?php include('../includes/notificacion.php'); ?>

<!-- BOTÓN FILTRO MOVIL -->
<div class="contenedor-btn-filtro block lg:hidden">
    <button id="btnFiltros" class="flex items-center gap-2 text-[#7C23BA] hover:text-[#4F0087] transition-colors duration-200">
        <svg viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2l-5 6v5l-4-2v-3L3 6V4z" clip-rule="evenodd" />
        </svg>
        <span>Filtros</span>
    </button>
</div>

<!-- FORMULARIO EN ESCRITORIO -->
<form method="GET" action="lista_urls.php" class="filtros hidden lg:flex flex-wrap items-center gap-4">
    
    <input type="hidden" name="pkLibro" value="<?= htmlspecialchars($fklibro) ?>">
    <input type="hidden" name="isbn" value="<?= htmlspecialchars($isbnLibro) ?>">

    <input type="text" name="buscar" class="input-busqueda uppercase"
           placeholder="Buscar por título..."
           value="<?= htmlspecialchars($_GET['buscar'] ?? '') ?>">

    <select name="estatus" class="select-filtro">
      <option value="">Estatus</option>
      <option value="A" <?= ($_GET['estatus'] ?? '') === 'A' ? 'selected' : '' ?>>Activo</option>
      <option value="I" <?= ($_GET['estatus'] ?? '') === 'I' ? 'selected' : '' ?>>Inactivo</option>
    </select>

    <button type="submit" class="btn-filtro shrink-0">Buscar</button>
</form>

<!-- PANEL DE FILTROS MOVIL -->
<div id="panelFiltros" class="panel-filtros oculto">
    <div class="panel-filtros-contenido">
        <button type="button" id="cerrarPanel" class="cerrar-panel">&times;</button>
        <h2>Filtros</h2>

        <form method="GET" action="lista_urls.php" class="form-filtros-movil">

            <input type="hidden" name="pkLibro" value="<?= htmlspecialchars($fklibro) ?>">
            <input type="hidden" name="isbn" value="<?= htmlspecialchars($isbnLibro) ?>">

            <input type="text" name="buscar" class="input-busqueda"
                   placeholder="Buscar por título..."
                   value="<?= htmlspecialchars($_GET['buscar'] ?? '') ?>">

            <select name="estatus" class="select-filtro">
              <option value="">Estatus</option>
              <option value="A" <?= ($_GET['estatus'] ?? '') === 'A' ? 'selected' : '' ?>>Activo</option>
              <option value="I" <?= ($_GET['estatus'] ?? '') === 'I' ? 'selected' : '' ?>>Inactivo</option>
            </select>

            <button type="submit" class="btn-filtro">Aplicar filtros</button>
        </form>
    </div>
</div>

<section class="grid-listas">
<?php if (!empty($resultado)): ?>
  <?php foreach ($resultado as $fila): 
    $url = htmlspecialchars($fila['url']);
    $tituloLibro = $fila['titulo'] 
    ? htmlspecialchars($fila['titulo'], ENT_QUOTES, 'UTF-8') : 'Sin libro';


    $estatus = (isset($fila['estatus']) && $fila['estatus'] === 'I') ? 'INACTIVO' : 'ACTIVO';
    $colorEstatus = $estatus === 'ACTIVO'
        ? 'text-green-500 font-semibold [text-shadow:0_2px_4px_rgba(0,0,0,.3)]'
        : 'text-red-500 font-semibold [text-shadow:0_2px_4px_rgba(0,0,0,.3)]';
  ?>
  <div class="relative bg-white rounded-xl shadow p-4 flex flex-col gap-2 hover:shadow-md transition group w-full max-w-[520px] border-[3px] overflow-visible">

    <!-- botones -->
    <?php if ($rol != 'L' && $estatusLog == 'A'): ?>
      <button class="absolute right-4 top-1/2 -translate-y-1/2 p-2 rounded hover:bg-gray-200 z-20 btn-kebab"
              onclick="event.stopPropagation(); toggleKebab(this)">
          <img src="/Biblioteca/imagenes/btn Iconos/btnAcciones.png" class="size-6">
      </button>

      <div class="menu-kebab hidden absolute right-4 top-14 bg-white shadow-lg rounded-lg border w-40 z-30">

        <?php if (!isset($fila['estatus']) || $fila['estatus'] === 'A'): ?>
        <a href="../controladores/desactivar_url.php?pkUrl=<?= $fila['pkUrl'] ?>"
           class="flex items-center gap-2 w-full text-left px-4 py-2 hover:bg-gray-100 hover:text-red-400"
           onclick="event.stopPropagation();">
            <img src="/Biblioteca/imagenes/btn Iconos/btbBaja.png" class="size-4">
            <span class="text-sm leading-6">Desactivar</span>
        </a>
        <?php else: ?>
        <a href="../controladores/activar_url.php?pkUrl=<?= $fila['pkUrl'] ?>"
           class="flex items-center gap-2 w-full text-left px-4 py-2 hover:bg-gray-100 hover:text-green-400"
           onclick="event.stopPropagation();">
            <img src="/Biblioteca/imagenes/btn Iconos/btnAlta.png" class="size-4">
            <span class="text-sm leading-6">Activar</span>
        </a>
        <?php endif; ?>

      </div>
    <?php endif; ?>

    <!-- TARJETA -->
    <div class="flex flex-col gap-1 flex-1 pr-12">
        <h2 class="text-lg font-bold text-purple-900"><?= $tituloLibro ?></h2>
        <a href="<?= $url ?>" class="text-blue-500 break-words"><?= $url ?></a>
        <p class="text-sm <?= $colorEstatus ?>"><?= $estatus ?></p>
    </div>

  </div>
  <?php endforeach; ?>
<?php else: ?>
  <p class="no-resultados">No se encontraron URLs.</p>
<?php endif; ?>
</section>

<script>
function toggleKebab(btn) {
    document.querySelectorAll(".menu-kebab").forEach(menu => {
        if (menu !== btn.nextElementSibling) menu.classList.add("hidden");
    });
    btn.nextElementSibling.classList.toggle("hidden");
}

document.addEventListener("click", function(e) {
    if (!e.target.closest(".btn-kebab") && !e.target.closest(".menu-kebab")) {
        document.querySelectorAll(".menu-kebab").forEach(menu => menu.classList.add("hidden"));
    }
});
</script>

<?php include('../includes/footer.php'); ?>
</body>
</html>
