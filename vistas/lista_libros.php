<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Catálogo de Libros</title>
  <link rel="stylesheet" href="../css/libros.css">
  <link rel="stylesheet" href="../css/filtros.css">
</head>

<?php
// --- MODELOS ---
include('../clases/libro.php');
include('../clases/categoria.php');

// --- CONTROLADOR ---
include('../controladores/filtrar_libros.php'); // ← Aquí se definen $resultado

// --- CATEGORÍAS ---
$cat = new Categoria;
$cats = $cat->mostrar();

include('../includes/header.php');
?>

<body>
  <?php include('../includes/menu.php'); ?>

  <div class="px-10 mb-6">
    <h1 class="titulos">Catálogo de Libros</h1>
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
  <form method="GET" action="lista_libros.php" class="filtros hidden lg:flex flex-wrap items-center gap-4">
    <input type="text" name="buscar" class="input-busqueda"
           placeholder="Buscar por título, autor o ISBN..."
           value="<?= htmlspecialchars($_GET['buscar'] ?? '') ?>">

    <select name="categoria" class="select-filtro">
      <option value="">Todas las categorías</option>
      <?php foreach ($cats as $fila): ?>
        <option value="<?= htmlspecialchars($fila['pkCategoria']) ?>" 
          <?= (isset($_GET['categoria']) && $_GET['categoria'] == $fila['pkCategoria']) ? 'selected' : '' ?>>
          <?= htmlspecialchars($fila['nombreCategoria']) ?>
        </option>
      <?php endforeach; ?>
    </select>

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

      <form method="GET" action="lista_libros.php" class="form-filtros-movil">
        <input type="text" name="buscar" class="input-busqueda"
               placeholder="Buscar por título, autor o ISBN..."
               value="<?= htmlspecialchars($_GET['buscar'] ?? '') ?>">

        <select name="categoria" class="select-filtro">
          <option value="">Todas las categorías</option>
          <?php foreach ($cats as $fila): ?>
            <option value="<?= htmlspecialchars($fila['pkCategoria']) ?>"
              <?= (isset($_GET['categoria']) && $_GET['categoria'] == $fila['pkCategoria']) ? 'selected' : '' ?>>
              <?= htmlspecialchars($fila['nombreCategoria']) ?>
            </option>
          <?php endforeach; ?>
        </select>

        <select name="estatus" class="select-filtro">
          <option value="">Estatus</option>
          <option value="A" <?= (isset($_GET['estatus']) && $_GET['estatus'] === 'A') ? 'selected' : '' ?>>Activo</option>
          <option value="I" <?= (isset($_GET['estatus']) && $_GET['estatus'] === 'I') ? 'selected' : '' ?>>Inactivo</option>
        </select>

        <button type="submit" class="btn-filtro">Aplicar filtros</button>
      </form>
    </div>
  </div>

  <!-- Mostrar resultados -->
  <section class="grid-libros">
    <?php if (!empty($resultado)): ?>
      <?php foreach ($resultado as $fila): 
        $titulo = htmlspecialchars($fila['titulo']);
        $isbn = htmlspecialchars($fila['isbn']);
        $autor = htmlspecialchars($fila['nombreAutor']);
        $edicion = htmlspecialchars($fila['edicion']);
        $anio = htmlspecialchars($fila['añoPublicacion'] ?? '');
        $editorial = htmlspecialchars($fila['nombreEditorial']);
        $categoria = htmlspecialchars($fila['nombreCategoria']);
        $subcategoria = htmlspecialchars($fila['nombreSubCategoria']);
        $img = htmlspecialchars($fila['portada'] ?? '');
        $edicionLabel = trim($edicion) !== '' ? "{$edicion} Edición" : '';
        if ($anio !== '') {
          $edicionLabel = $edicionLabel !== '' ? "{$edicionLabel}, {$anio}" : "{$anio}";
        }
      ?>
      <a href="detalle_libro.php?pkLibro=<?= $fila['pkLibro'] ?>" class="tarjeta-mini">
        <img src="<?= !empty($img) ? '../imagenes/portadas/' . $img : '../imagenes/portadas/placeholder.png'; ?>" 
             alt="Portada de <?= $titulo ?>" class="tarjeta-mini-img">

        <div class="tarjeta-mini-info">
          <h2 class="tarjeta-mini-titulo"><?= $titulo ?></h2>
          <p class="tarjeta-mini-autor"><?= $autor ?></p>
          <p><strong>ISBN:</strong> <?= $isbn ?></p>
          <p><strong>Editorial:</strong> <?= $editorial ?></p>
          <p><strong>Categoría:</strong> <?= $categoria ?></p>
          <p class="tarjeta-mini-extra"><?= $edicionLabel ?></p>
        </div>
      </a>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="no-resultados">No se encontraron libros con esos filtros.</p>
    <?php endif; ?>
  </section>

  <?php include('../includes/footer.php'); ?>

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
