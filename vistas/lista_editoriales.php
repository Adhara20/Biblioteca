<?php
require_once('../includes/auth.php');

// Solo Admin y Bibliotecario
requireRole(['A', 'B']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editoriales</title>
    <link rel="stylesheet" href="../css/listas.css">
    <link rel="stylesheet" href="../css/filtros.css">
</head>

<?php
include('../clases/editorial.php');

$edi = new Editorial();

// Recuperar filtros
$buscar = $_GET['buscar'] ?? '';
$estatus = $_GET['estatus'] ?? '';

// Filtrar si hay filtros
if (!empty($buscar) || !empty($estatus)) {
    $resultado = $edi->filtrar($buscar, $estatus);
} else {
    $resultado = $edi->listaEditoriales();
}

include('../includes/header.php');
?>

<body>
<?php include('../includes/menu.php'); ?>

<!-- Titulo y botón Agregar -->
<div class="px-10 mb-6">
  <div class="flex items-center justify-between">
    <div>
      <h1 class="titulos">Editoriales</h1>
    </div>
    <div class="flex items-center">
    <?php if($rol != 'L' && $estatusLog =='A'): ?>
      <a href="formulario_editorial.php" class="rounded-md text-white font-medium transition bg-[#3BAA8D] hover:bg-[#abe4d5] hover:text-[#3BAA8D] border hover:border-[#3BAA8D]  shadow-sm px-4 py-2 w-full sm:w-40 text-center">
        Agregar Editorial
      </a>
      <?php endif; ?>
    </div>
  </div>
  <hr class="linea-separadora-listas">
</div>

<?php include('../includes/notificacion.php'); ?>

<!-- Botón móvil -->
<div class="contenedor-btn-filtro block lg:hidden">
  <button id="btnFiltros" class="flex items-center gap-2 text-[#7C23BA] hover:text-[#4F0087] transition-colors duration-200">
    <svg viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
      <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2l-5 6v5l-4-2v-3L3 6V4z" clip-rule="evenodd" />
    </svg>
    <span>Filtros</span>
  </button>
</div>

<!-- Filtros PC -->
<form method="GET" action="lista_editoriales.php" class="filtros hidden lg:flex flex-wrap items-center gap-4">
  <input type="text" name="buscar" class="input-busqueda uppercase" placeholder="Buscar editorial..." value="<?= htmlspecialchars($buscar) ?>">
  <select name="estatus" class="select-filtro">
      <option value="">Estatus</option>
      <option value="A" <?= ($estatus === 'A') ? 'selected' : '' ?>>Activo</option>
      <option value="I" <?= ($estatus === 'I') ? 'selected' : '' ?>>Inactivo</option>
  </select>
  <button type="submit" class="btn-filtro">Buscar</button>
</form>

<!-- Filtros móviles -->
<div id="panelFiltros" class="panel-filtros oculto">
  <div class="panel-filtros-contenido">
    <button type="button" id="cerrarPanel" class="cerrar-panel">&times;</button>
    <h2>Filtros</h2>
    <form method="GET" action="lista_editoriales.php" class="form-filtros-movil">
      <input type="text" name="buscar" class="input-busqueda" placeholder="Buscar editorial..." value="<?= htmlspecialchars($buscar) ?>">
      <select name="estatus" class="select-filtro">
        <option value="">Estatus</option>
        <option value="A" <?= ($estatus === 'A') ? 'selected' : '' ?>>Activo</option>
        <option value="I" <?= ($estatus === 'I') ? 'selected' : '' ?>>Inactivo</option>
      </select>
      <button type="submit" class="btn-filtro">Aplicar filtros</button>
    </form>
  </div>
</div>

<!-- Lista de editoriales -->
<section class="grid-listas">
<?php if (!empty($resultado)): ?>
  <?php foreach ($resultado as $fila):
      $nombreEditorial = htmlspecialchars($fila['nombreEditorial']);
      $nombreNaci = htmlspecialchars($fila['nacionalidad']);
      $estatusTexto = ($fila['estatus'] === 'A') ? 'ACTIVO' : 'INACTIVO';
      $colorEstatus = ($fila['estatus'] === 'A') ? 'text-green-500 font-semibold [text-shadow:0_2px_4px_rgba(0,0,0,.3)]' : 'text-red-500 font-semibold [text-shadow:0_2px_4px_rgba(0,0,0,.3)]';
  ?>
  <div class="relative overflow-visible bg-white rounded-xl shadow p-4 flex items-center gap-4 hover:shadow-md transition group w-full max-w-[520px] border-[3px] border-[<?= $colorEstatus ?>]">

    <!-- Botón Kebab -->
    <button class="absolute right-4 top-1/2 -translate-y-1/2 p-2 rounded hover:bg-gray-200 z-20 btn-kebab"
            onclick="event.stopPropagation(); toggleKebab(this)">
      <img src="/Biblioteca/imagenes/btn Iconos/btnAcciones.png" class="size-6" alt="Acciones">
    </button>

    <!-- Menú Kebab -->
    <div class="menu-kebab hidden absolute right-4 top-14 bg-white shadow-lg rounded-lg border w-40 z-30">
      <a href="detalle_editorial.php?pkEditorial=<?= $fila['pkEditorial'] ?>" class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100 hover:text-purple-400" onclick="event.stopPropagation();">
        <img src="/Biblioteca/imagenes/btn Iconos/btnVer.png" class="size-4">
        <span class="text-sm/6">Ver Detalles</span>
      </a>
    <?php if($rol != 'L' && $estatusLog =='A'): ?>
      <a href="editar_editorial.php?pkEditorial=<?= $fila['pkEditorial'] ?>" class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100 hover:text-purple-400" onclick="event.stopPropagation();">
        <img src="/Biblioteca/imagenes/btn Iconos/btnEditar.png" class="size-4">
        <span class="text-sm/6">Editar</span>
      </a>
      <?php if($fila['estatus'] === 'A'): ?>
        <a href="../controladores/desactivar_editorial.php?pkEditorial=<?= $fila['pkEditorial'] ?>" class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100 hover:text-red-400" onclick="event.stopPropagation();">
          <img src="/Biblioteca/imagenes/btn Iconos/btbBaja.png" class="size-4">
          <span class="text-sm/6">Desactivar</span>
        </a>
      <?php else: ?>
        <a href="../controladores/activar_editorial.php?pkEditorial=<?= $fila['pkEditorial'] ?>" class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100 hover:text-green-400" onclick="event.stopPropagation();">
          <img src="/Biblioteca/imagenes/btn Iconos/btnAlta.png" class="size-4">
          <span class="text-sm/6">Activar</span>
        </a>
      <?php endif; ?>
    <?php endif; ?>
    </div>

    <!-- Contenido de tarjeta -->
    <a href="detalle_editorial.php?pkEditorial=<?= $fila['pkEditorial'] ?>" class="flex items-center gap-4 w-full">
      <div class="flex flex-col gap-1 flex-1 mr-8">
        <h2 class="text-lg font-bold text-purple-900"><?= $nombreEditorial ?></h2>
        <p class="text-sm text-gray-600"><strong>Nacionalidad:</strong> <?= $nombreNaci ?></p>
        <p class="text-sm <?= $colorEstatus ?>"><?= $estatusTexto ?></p>
      </div>
    </a>

  </div>
  <?php endforeach; ?>
<?php else: ?>
  <p class="no-resultados">No se encontraron editoriales con esos filtros.</p>
<?php endif; ?>
</section>

<script>
const btnFiltros = document.getElementById('btnFiltros');
const panelFiltros = document.getElementById('panelFiltros');
const cerrarPanel = document.getElementById('cerrarPanel');

btnFiltros?.addEventListener('click', () => {
  panelFiltros.classList.add('mostrar');
  panelFiltros.classList.remove('oculto');
});

cerrarPanel?.addEventListener('click', () => {
  panelFiltros.classList.remove('mostrar');
  panelFiltros.classList.add('oculto');
});

panelFiltros?.addEventListener('click', (e) => {
  if(e.target === panelFiltros){
    panelFiltros.classList.remove('mostrar');
    panelFiltros.classList.add('oculto');
  }
});

// Kebab menu
function toggleKebab(btn){
  document.querySelectorAll(".menu-kebab").forEach(menu => {
    if(menu !== btn.nextElementSibling) menu.classList.add("hidden");
  });
  btn.nextElementSibling.classList.toggle("hidden");
}

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
