<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/copias.css">
    <link rel="stylesheet" href="../css/filtros.css">
</head>
<?php 
        include('../includes/header.php');
	?>
<body>
      <?php 
        include('../controladores/filtrar_copias.php'); // Aquí deberías obtener $resultadoCopias
        include('../clases/subcategoria.php');
        $clase = new Subcategoria;
        $resultadoSub = $clase->listaActivo();
        include('../includes/menu.php');
	?>
    <div class="px-10 mb-4">
        <h1 class="titulos">Registro de Copias</h1>
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
  <form method="GET" action="lista_copia.php" class="filtros hidden lg:flex flex-wrap items-center gap-x-4 gap-y-2">
    <input type="text" name="buscar" class="input-busqueda w-48"
           placeholder="Buscar por ISBN, Titulo, Folio..."
           value="<?= htmlspecialchars($_GET['buscar'] ?? '') ?>">

    <select name="estatus"  class="select-filtro w-40">
      <option value="">Estatus</option>
      <option value="A" <?= (($_GET['estatus'] ?? '') === 'A') ? 'selected' : '' ?>>Activo</option>
      <option value="I" <?= (($_GET['estatus'] ?? '') === 'I') ? 'selected' : '' ?>>Inactivo</option>
    </select>

    <select name="subcategoria" class="select-filtro">
      <option value="">Todas las categorías</option>
      <?php foreach ($resultadoSub as $fila): ?>
        <option value="<?= htmlspecialchars($fila['pkSubCategoria']) ?>" 
          <?= (isset($_GET['subcategoria']) && $_GET['subcategoria'] == $fila['pkSubCategoria']) ? 'selected' : '' ?>>
          <?= htmlspecialchars($fila['nombreSubCategoria']) ?>
        </option>
      <?php endforeach; ?>
    </select>

    <button type="submit" class="btn-filtro ml-auto shrink-0">Buscar</button>
  </form>

  <!-- Panel lateral móvil -->
  <div id="panelFiltros" class="panel-filtros oculto">
  <div class="panel-filtros-contenido">
    <button type="button" id="cerrarPanel" class="cerrar-panel">&times;</button>
    <h2>Filtros</h2>

      <form method="GET" action="lista_usuarios.php" class="form-filtros-movil">
        <input type="text" name="buscar" class="input-busqueda"
               placeholder="Buscar por..."
               value="<?= htmlspecialchars($_GET['buscar'] ?? '') ?>">

        <select name="estatus" class="select-filtro">
          <option value="">Estatus</option>
          <option value="A" <?= (($_GET['estatus'] ?? '') === 'A') ? 'selected' : '' ?>>Activo</option>
          <option value="I" <?= (($_GET['estatus'] ?? '') === 'I') ? 'selected' : '' ?>>Inactivo</option>
        </select>

        <select name="subcategoria" class="select-filtro">
      <option value="">Todas las categorías</option>
      <?php foreach ($resultadoSub as $fila): ?>
        <option value="<?= htmlspecialchars($fila['pkSubCategoria']) ?>" 
          <?= (isset($_GET['subcategoria']) && $_GET['subcategoria'] == $fila['pkSubCategoria']) ? 'selected' : '' ?>>
          <?= htmlspecialchars($fila['nombreSubCategoria']) ?>
        </option>
      <?php endforeach; ?>
    </select>

        <button type="submit" class="btn-filtro">Aplicar filtros</button>
      </form>
    </div>
  </div>

    <div class="tabla-copias-container">
    <table class="table-copias">
    <tr>
        <th>ISBN</th>
        <th>Folio</th>
        <th>Título</th>
        <th>Subcategoría</th>
        <th>Estantería</th>
    </tr>
    <?php foreach ($resultadoCF as $fila) { ?>
        <tr>
            <td><?=$fila["isbn"]?></td>
            <td><?=$fila["folio"]?></td>
            <td><?=$fila["titulo"]?></td>
            <td><?=$fila["nombreSubCategoria"]?></td>
            <td><?=$fila["codigoEstanteria"]?></td>
        </tr>
    <?php } ?>
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