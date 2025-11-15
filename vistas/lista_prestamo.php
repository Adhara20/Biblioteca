<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/prestamos.css">
    <link rel="stylesheet" href="../css/filtros.css">
</head>
<?php 
  include('../includes/header.php');
?>

<body>
  <?php 
    include('../controladores/filtrar_prestamos.php');
$clase = new Prestamo();

// Leer filtros
$buscar = $_GET['buscar'] ?? '';
$estatus = $_GET['estatus'] ?? '';
$estatusDevolucion = $_GET['estatusDevolucion'] ?? '';

// Si NO hay filtros → mostrar todo
if ($buscar === '' && $estatus === '' && $estatusDevolucion === '' && $fechaRegistro === '') {
    $resultado = $clase->verPrestamo();
} else {
    // Si hay filtros → filtrar
    $resultado = $clase->filtrar($buscar, $estatus, $estatusDevolucion, $fechaRegistro);
}

include('../includes/menu.php');
  ?>

  <div class="px-10 mb-4">
    <h1 class="titulos">Registro de Préstamos</h1>
    <hr class="linea-separadora-listas">
  </div>

      <!-- Botón visible solo en móvil -->
<div class="contenedor-btn-filtro block lg:hidden">
  <button id="btnFiltros" class="flex items-center gap-2 text-[#7C23BA] hover:text-[#4F0087] transition-colors duration-200">
    <svg viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
      <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2l-5 6v5l-4-2v-3L3 6V4z" clip-rule="evenodd" />
    </svg>
    <span>Filtros</span>
  </button>
</div>

  <!-- Filtros en pantallas grandes -->
  <form method="GET" action="lista_prestamo.php" class="filtros hidden lg:flex flex-wrap items-center gap-x-4 gap-y-2">
    <input type="text" name="buscar" class="input-busqueda w-48"
           placeholder="Buscar por Usuario, Codigo..."
           value="<?= htmlspecialchars($_GET['buscar'] ?? '') ?>">

      <input type="date" name="fechaRegistro" class="input-busqueda"
      value="<?= htmlspecialchars($_GET['fechaRegistro'] ?? '') ?>" placeholder="2000-08-26">

    <select name="estatus" class="select-filtro">
          <option value="">Estatus</option>
          <option value="EnProceso" <?= (($_GET['estatus'] ?? '') === 'A') ? 'selected' : '' ?>>En Proceso</option>
          <option value="Completado" <?= (($_GET['estatus'] ?? '') === 'I') ? 'selected' : '' ?>>Completado</option>
          <option value="Cancelado" <?= (($_GET['estatus'] ?? '') === 'I') ? 'selected' : '' ?>>Cancelado</option>
        </select>

    <select name="estatusDevolucion"  class="select-filtro w-40">
      <option value="">Estatus Devolución</option>
      <option value="ATiempo" <?= (($_GET['estatusDevolucion'] ?? '') === 'A') ? 'selected' : '' ?>>ATiempo</option>
      <option value="Vencido" <?= (($_GET['estatusDevolucion'] ?? '') === 'I') ? 'selected' : '' ?>>Vencido</option>
        </select>

    <button type="submit" class="btn-filtro ml-auto shrink-0">Buscar</button>
  </form>

  <!-- Panel lateral móvil -->
  <div id="panelFiltros" class="panel-filtros oculto">
  <div class="panel-filtros-contenido">
    <button type="button" id="cerrarPanel" class="cerrar-panel">&times;</button>
    <h2>Filtros</h2>

      <form method="GET" action="lista_prestamo.php" class="form-filtros-movil">
        <input type="text" name="buscar" class="input-busqueda"
               placeholder="Buscar por..."
               value="<?= htmlspecialchars($_GET['buscar'] ?? '') ?>">

            <input type="date" name="fechaRegistro" class="input-busqueda"
      value="<?= htmlspecialchars($_GET['fechaRegistro'] ?? '') ?>" placeholder="2000-08-26">

        <select name="estatus" class="select-filtro">
          <option value="">Estatus</option>
          <option value="EnProceso" <?= (($_GET['estatus'] ?? '') === 'A') ? 'selected' : '' ?>>En Proceso</option>
          <option value="Completado" <?= (($_GET['estatus'] ?? '') === 'I') ? 'selected' : '' ?>>Completado</option>
          <option value="Cancelado" <?= (($_GET['estatus'] ?? '') === 'I') ? 'selected' : '' ?>>Cancelado</option>
        </select>

        <select name="estatusDevolucion"  class="select-filtro">
      <option value="">Estatus Devolución</option>
      <option value="ATiempo" <?= (($_GET['estatusDevolucion'] ?? '') === 'A') ? 'selected' : '' ?>>ATiempo</option>
      <option value="Vencido" <?= (($_GET['estatusDevolucion'] ?? '') === 'I') ? 'selected' : '' ?>>Vencido</option>
        </select>

        <button type="submit" class="btn-filtro">Aplicar filtros</button>
      </form>
    </div>
  </div>

  <div class="tabla-prestamos-container">
    <table class="table-prestamos">
      <thead>
        <tr>
          <th>Código</th>
          <th>Fecha Registro</th>
          <th>Fecha Límite</th>
          <th>Fecha Entrega</th>
          <th>Folio Contrato</th>
          <th>Contrato</th>
          <th>Copia</th>
          <th>Solicitante</th>
          <th>Autorizante</th>
          <th>Estatus</th>
          <th>Devolución</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($resultado as $fila): ?>
          <tr>
            <td data-label="Código"><?= htmlspecialchars($fila["codigoPrestamo"]) ?></td>
            <td data-label="Fecha Registro"><?= htmlspecialchars($fila["fechaRegistro"]) ?></td>
            <td data-label="Fecha Límite"><?= htmlspecialchars($fila["fechaLimite"]) ?></td>
            <td data-label="Fecha Entrega"><?= htmlspecialchars($fila["fechaEntrega"]) ?></td>
            <td data-label="Folio Contrato"><?= htmlspecialchars($fila["folioContrato"]) ?></td>
            <td data-label="Contrato"><?= htmlspecialchars($fila["archivoContrato"]) ?></td>
            <td data-label="Copia"><?= htmlspecialchars($fila["isbnCopia"]) ?></td>
            <td data-label="Solicitante"><?= htmlspecialchars($fila["numSolicitante"]) ?></td>
            <td data-label="Autorizante"><?= htmlspecialchars($fila["numAutorizante"]) ?></td>
            <td data-label="Estatus"><?= htmlspecialchars($fila["estatus"]) ?></td>
            <td data-label="Devolución"><?= htmlspecialchars($fila["estatusDevolucion"]) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
          <!-- Script para abrir/cerrar el panel -->
  <script>
    const btnFiltros = document.getElementById('btnFiltros');
    const panelFiltros = document.getElementById('panelFiltros');
    const cerrarPanel = document.getElementById('cerrarPanel');
        
    btnFiltros.addEventListener('click', () => {
      panelFiltros.classList.add('mostrar');
      panelFiltros.classList.remove('oculto');
    });
    
    cerrarPanel.addEventListener('click', () => {
      panelFiltros.classList.remove('mostrar');
      panelFiltros.classList.add('oculto');
    });
    
    // Cerrar al hacer click fuera del contenido
    panelFiltros.addEventListener('click', (e) => {
      if (e.target === panelFiltros) {
        panelFiltros.classList.remove('mostrar');
        panelFiltros.classList.add('oculto');
      }
    });
  </script>

  <?php include('../includes/footer.php'); ?>
</body>
</html>