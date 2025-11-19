<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Préstamos</title>

    <link rel="stylesheet" href="../css/listas.css">
    <link rel="stylesheet" href="../css/filtros.css">
</head>

<?php 
include('../includes/header.php');
?>

<body>

<?php 
include('../controladores/filtrar_prestamos.php');

$clase = new Prestamo();

// FILTROS
$buscar = $_GET['buscar'] ?? '';
$estatus = $_GET['estatus'] ?? '';
$estatusDevolucion = $_GET['estatusDevolucion'] ?? '';
$fechaRegistro = $_GET['fechaRegistro'] ?? '';

// Mostrar TODO si no hay filtros
if ($buscar === '' && $estatus === '' && $estatusDevolucion === '' && $fechaRegistro === '') {
    $resultado = $clase->verPrestamo();
} else {
    $resultado = $clase->filtrar($buscar, $estatus, $estatusDevolucion, $fechaRegistro);
}

include('../includes/menu.php');
?>

<div class="px-10 mb-4">
    <h1 class="titulos">Registro de Préstamos</h1>
    <hr class="linea-separadora-listas">
</div>


<!-- BOTÓN FILTROS MÓVIL -->
<div class="contenedor-btn-filtro block lg:hidden">
  <button id="btnFiltros" class="flex items-center gap-2 text-[#7C23BA] hover:text-[#4F0087] transition-colors duration-200">
    <svg viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
      <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2l-5 6v5l-4-2v-3L3 6V4z" clip-rule="evenodd" />
    </svg>
    <span>Filtros</span>
  </button>
</div>


<!-- FILTROS ESCRITORIO -->
<form method="GET" action="lista_prestamos.php" class="filtros hidden lg:flex flex-wrap items-center gap-x-4 gap-y-2">

    <input type="text" name="buscar" class="input-busqueda w-48"
           placeholder="Buscar por usuario o código..."
           value="<?= htmlspecialchars($buscar) ?>">

    <input type="date" name="fechaRegistro" class="input-busqueda"
           value="<?= htmlspecialchars($fechaRegistro) ?>">

    <select name="estatus" class="select-filtro">
        <option value="">Estatus</option>
        <option value="EnProceso" <?= $estatus === 'EnProceso' ? 'selected' : '' ?>>En Proceso</option>
        <option value="Completado" <?= $estatus === 'Completado' ? 'selected' : '' ?>>Completado</option>
        <option value="Cancelado" <?= $estatus === 'Cancelado' ? 'selected' : '' ?>>Cancelado</option>
    </select>

    <select name="estatusDevolucion" class="select-filtro">
        <option value="">Estatus Devolución</option>
        <option value="ATiempo" <?= $estatusDevolucion === 'ATiempo' ? 'selected' : '' ?>>A Tiempo</option>
        <option value="Vencido" <?= $estatusDevolucion === 'Vencido' ? 'selected' : '' ?>>Vencido</option>
    </select>

    <button type="submit" class="btn-filtro ml-auto shrink-0">Buscar</button>
</form>


<!-- PANEL LATERAL MÓVIL -->
<div id="panelFiltros" class="panel-filtros oculto">
  <div class="panel-filtros-contenido">
    <button type="button" id="cerrarPanel" class="cerrar-panel">&times;</button>
    <h2>Filtros</h2>

    <form method="GET" action="lista_prestamos.php" class="form-filtros-movil">

        <input type="text" name="buscar" class="input-busqueda"
               placeholder="Buscar por usuario o código..."
               value="<?= htmlspecialchars($buscar) ?>">

        <input type="date" name="fechaRegistro" class="input-busqueda"
               value="<?= htmlspecialchars($fechaRegistro) ?>">

        <select name="estatus" class="select-filtro">
            <option value="">Estatus</option>
            <option value="EnProceso" <?= $estatus === 'EnProceso' ? 'selected' : '' ?>>En Proceso</option>
            <option value="Completado" <?= $estatus === 'Completado' ? 'selected' : '' ?>>Completado</option>
            <option value="Cancelado" <?= $estatus === 'Cancelado' ? 'selected' : '' ?>>Cancelado</option>
        </select>

        <select name="estatusDevolucion" class="select-filtro">
            <option value="">Estatus Devolución</option>
            <option value="ATiempo" <?= $estatusDevolucion === 'ATiempo' ? 'selected' : '' ?>>A Tiempo</option>
            <option value="Vencido" <?= $estatusDevolucion === 'Vencido' ? 'selected' : '' ?>>Vencido</option>
        </select>

        <button type="submit" class="btn-filtro">Aplicar filtros</button>
    </form>
  </div>
</div>


<!-- LISTADO -->
<section class="grid-listas">

<?php if (!empty($resultado)): ?>
<?php foreach ($resultado as $fila): ?>

<?php 
$codigoPrestamo = htmlspecialchars($fila['codigoPrestamo']);
$fechaRegistro = htmlspecialchars($fila['fechaRegistro']);
$fechaLimite = htmlspecialchars($fila['fechaLimite']);
$fechaEntrega = htmlspecialchars($fila['fechaEntrega'] ?? '---');
$folioContrato = htmlspecialchars($fila['folioContrato']);
$fkCopiaF = htmlspecialchars($fila['isbnCopia']);
$fkUsuarioSolicita = htmlspecialchars($fila['numSolicitante']);
$fkUsuarioAutoriza = htmlspecialchars($fila['numAutorizante']);
$estatus = htmlspecialchars($fila['estatus']);
$estatusDevolucion = htmlspecialchars($fila['estatusDevolucion']);
?>

<div class="relative overflow-visible bg-white rounded-xl shadow p-4 flex items-center gap-4 hover:shadow-md transition group w-full max-w-[520px]">

    <!-- Botón Kebab -->
    <button 
        class="absolute right-4 top-1/2 -translate-y-1/2 p-2 rounded hover:bg-gray-200 z-20 btn-kebab"
        onclick="event.stopPropagation(); toggleKebab(this)">
        <img src="../imagenes/btn Iconos/btnAcciones.png" class="size-6">
    </button>

    <!-- Menú -->
    <div class="menu-kebab hidden absolute right-4 top-14 bg-white shadow-lg rounded-lg border w-40 z-30">

        <a href="detalle_prestamo.php?pkPrestamo=<?= $fila['pkPrestamo'] ?>"
            class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100 hover:text-purple-400">
            <img src="/Biblioteca/imagenes/btn Iconos/btnVer.png" class="size-4">
            <span class="text-sm">Ver Detalles</span>
        </a>

        <a href="editar_prestamo.php?pkPrestamo=<?= $fila['pkPrestamo'] ?>"
            class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100 hover:text-purple-400">
            <img src="/Biblioteca/imagenes/btn Iconos/btnEditar.png" class="size-4">
            <span class="text-sm">Editar</span>
        </a>

        <?php if ($estatus === "EnProceso"): ?>
            <a href="../controladores/estatus_prestamo.php?pkPrestamo=<?= $fila['pkPrestamo'] ?>&accion=cancelar"
                class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100 hover:text-red-400">
                <img src="/Biblioteca/imagenes/btn Iconos/btbBaja.png" class="size-4">
                <span class="text-sm">Cancelar</span>
            </a>

            <a href="../controladores/estatus_prestamo.php?pkPrestamo=<?= $fila['pkPrestamo'] ?>&accion=cancelar"
                class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100 hover:text-green-400">
                <img src="/Biblioteca/imagenes/btn Iconos/btnAlta.png" class="size-4">
                <span class="text-sm">Completar</span>
            </a>
        <?php endif; ?>
    </div>

    <!-- TARJETA -->
    <a href="detalle_prestamo.php?pkPrestamo=<?=$fila['pkPrestamo']?>" 
    class="flex items-center gap-4 w-full">

        <div class="flex flex-col gap-1 flex-1 mr-8">
            <h2 class="text-lg font-bold text-purple-900">Préstamo: <?= $codigoPrestamo ?></h2>

            <p class="text-sm"><strong>ISBN copia:</strong> <?= $fkCopiaF ?></p>
            <p class="text-sm"><strong>Solicitante:</strong> <?= $fkUsuarioSolicita ?></p>
            <p class="text-sm"><strong>Autorizante:</strong> <?= $fkUsuarioAutoriza ?></p>

            <p class="text-sm"><strong>Fecha Registro:</strong> <?= $fechaRegistro ?></p>
            <p class="text-sm"><strong>Fecha Límite:</strong> <?= $fechaLimite ?></p>

            <p class="text-sm"><strong>Estatus:</strong> <?= $estatus ?></p>
            <p class="text-sm"><strong>Devolución:</strong> <?= $estatusDevolucion ?></p>
        </div>
    </a>

</div>

<?php endforeach; ?>

<?php else: ?>
<p class="no-resultados">No se encontraron préstamos con esos filtros.</p>
<?php endif; ?>

</section>


<!-- Script Kebab + Panel -->
<script>
  // panel filtros (movil)
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
    if (e.target === panelFiltros) {
      panelFiltros.classList.remove('mostrar');
      panelFiltros.classList.add('oculto');
    }
  });

// En Script nomas agregan de aqui para abajo
  // kebab
  function toggleKebab(btn) {
      // cerrar todos menos el actual
      document.querySelectorAll(".menu-kebab").forEach(menu => {
          if (menu !== btn.nextElementSibling) menu.classList.add("hidden");
      });
      btn.nextElementSibling.classList.toggle("hidden");
  }

  // cerrar kebab si da click fuera
  document.addEventListener("click", function(e) {
      const isKebabButton = e.target.closest(".btn-kebab");
      const isMenu = e.target.closest(".menu-kebab");
      if (!isKebabButton && !isMenu) {
          document.querySelectorAll(".menu-kebab").forEach(menu => menu.classList.add("hidden"));
      }
  });
  // Hasta aca
  </script>


<?php include('../includes/footer.php'); ?>
</body>
</html>