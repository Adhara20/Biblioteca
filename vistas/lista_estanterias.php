<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estanterias</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/copias.css">
    <link rel="stylesheet" href="../css/filtros.css">

</head>
<?php
// --- MODELOS ---
include('../clases/estanterias.php');

// --- CONTROLADOR ---
include('../controladores/filtrar_estanterias.php'); // ← Aquí se definen $resultado

// --- CATEGORÍAS ---


include('../includes/header.php');
?>

<body>
  <?php include('../includes/menu.php'); ?>

    <div class="px-10 mb-4">
    <h1 class="titulos">Registro de estanterias:</h1>
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

  <!-- Formulario en pantallas grandes -->
  <form method="GET" action="lista_estanterias.php" class="filtros hidden lg:flex flex-wrap items-center gap-4">
    <input type="text" name="buscar" maxlength="1" class="input-busqueda"
           placeholder="Buscar por pasillo o piso..."
           value="<?= htmlspecialchars($_GET['buscar'] ?? '') ?>">

	<select name="estatus" class="select-filtro">
      <option value="">Estatus</option>
      <option value="A" <?= (isset($_GET['estatus']) && $_GET['estatus'] === 'A') ? 'selected' : '' ?>>Activo</option>
      <option value="I" <?= (isset($_GET['estatus']) && $_GET['estatus'] === 'I') ? 'selected' : '' ?>>Inactivo</option>
    </select>

    <button type="submit" class="btn-filtro shrink-0">Buscar</button>
  </form>

    <!-- Panel lateral (slidebar de filtros para móvil) -->
  <div id="panelFiltros" class="panel-filtros oculto">
  <div class="panel-filtros-contenido">
    <button type="button" id="cerrarPanel" class="cerrar-panel">&times;</button>
    <h2>Filtros</h2>

      <form method="GET" action="lista_estanterias.php" class="form-filtros-movil">
        <input type="text" name="buscar" class="input-busqueda"
               placeholder="Buscar por pasillo o piso..."
               value="<?= htmlspecialchars($_GET['buscar'] ?? '') ?>">

	    <select name="estatus" class="select-filtro">
          <option value="">Estatus</option>
          <option value="A" <?= (isset($_GET['estatus']) && $_GET['estatus'] === 'A') ? 'selected' : '' ?>>Activo</option>
          <option value="I" <?= (isset($_GET['estatus']) && $_GET['estatus'] === 'I') ? 'selected' : '' ?>>Inactivo</option>
        </select>

        <button type="submit" class="btn-filtro">Aplicar filtros</button>
      </form>
    </div>
  </div>

<div class="tabla-copias-container">
<table class="table-copias" >
	<tr>
        <!-- <th>id:</th> -->
		<th>Codigo:</th>
		<th>Pasillo:</th>
		<th>Pisso:</th>
		<th>Nveles:</th>
		<th>Descripcion:</th>
		<th>Estatus:</th>

		 <?php if (!empty($resultado)): ?>
      <?php foreach ($resultado as $fila): ?>
    <tr>
        <td><?= htmlspecialchars($fila["codigoEstanteria"]) ?></td>
        <td><?= htmlspecialchars($fila["pasillo"]) ?></td>
        <td><?= htmlspecialchars($fila["piso"]) ?></td>
        <td><?= htmlspecialchars($fila["cantNiveles"]) ?></td>
        <td><?= htmlspecialchars($fila["descripcion"]) ?></td>

        <td><?= ($fila["estatus"] === 'A') ? 'Activo' : 'Inactivo' ?></td>
	</tr>
<?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="3">No se encontraron estanterias con esos filtros.</td></tr>
        <?php endif; ?>
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
</body>
</html>