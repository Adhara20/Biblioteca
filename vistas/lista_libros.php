<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Libros</title>
  <!-- Ponen estos enlaces -->
  <link rel="stylesheet" href="../css/listas.css">
  <link rel="stylesheet" href="../css/filtros.css">
  <!-- <link rel="stylesheet" href="../css/style.css"> -->


</head>

<?php
// --- Clases ---
include('../clases/libro.php');
include('../clases/categoria.php');

// --- CONTROLADOR DE FILTRADO (Tambien Muestra) ---
include('../controladores/filtrar_libros.php'); // ← Aquí se define $resultado

// --- CATEGORIAS ---
$cat = new Categoria;
$cats = $cat->mostrar();

include('../includes/header.php');
?>

<body>
  <?php include('../includes/menu.php'); ?>

  <div class="px-10 mb-6">
    <h1 class="titulos">Libros</h1>
    <hr class="linea-separadora-listas">
  </div>
  <!-- Aquí agregan esto -->
  <!-- MENSAJE DE EXITO -->
<?php include('../includes/notificacion.php'); ?>


  <!-- Botón visible solo en móvil -->
  <div class="contenedor-btn-filtro block lg:hidden">
    <button id="btnFiltros" class="flex items-center gap-2 text-[#7C23BA] hover:text-[#4F0087] transition-colors duration-200">
      <svg viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5" aria-hidden="true">
        <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2l-5 6v5l-4-2v-3L3 6V4z" clip-rule="evenodd" />
      </svg>
      <span>Filtros</span>
    </button>
  </div>

  <!-- Formulario en pantallas grandes -->
  <form method="GET" action="lista_libros.php" class="filtros hidden lg:flex flex-wrap items-center gap-4">
    <input type="text" name="buscar" class="input-busqueda uppercase"
           placeholder="Buscar por título, autor o ISBN..."
           value="<?= htmlspecialchars($_GET['buscar'] ?? '') ?>" >

    <select name="categoria" class="select-filtro">
      <option value="">Todas las categorías</option>
      <?php foreach ($cats as $filaCat): ?>
        <option value="<?= htmlspecialchars($filaCat['pkCategoria']) ?>"
          <?= (isset($_GET['categoria']) && $_GET['categoria'] == $filaCat['pkCategoria']) ? 'selected' : '' ?>>
          <?= htmlspecialchars($filaCat['nombreCategoria']) ?>
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
          <?php foreach ($cats as $filaCat): ?>
            <option value="<?= htmlspecialchars($filaCat['pkCategoria']) ?>"
              <?= (isset($_GET['categoria']) && $_GET['categoria'] == $filaCat['pkCategoria']) ? 'selected' : '' ?>>
              <?= htmlspecialchars($filaCat['nombreCategoria']) ?>
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

  <!-- Obtener resultados -->
  <section class="grid-listas">
    <?php if (!empty($resultado)): ?>
      <?php foreach ($resultado as $fila): 
        $titulo = htmlspecialchars($fila['titulo']);
        $isbn = htmlspecialchars($fila['isbn']);
        $autor = htmlspecialchars($fila['nombreAutor']);
        $edicion = htmlspecialchars($fila['edicion']);
        $anio = htmlspecialchars($fila['anioPublicacion'] ?? '');
        $editorial = htmlspecialchars($fila['nombreEditorial']);
        $categoria = htmlspecialchars($fila['nombreCategoria']);
        $subcategoria = htmlspecialchars($fila['nombreSubCategoria']);
        $img = htmlspecialchars($fila['portada'] ?? '');
        $edicionLabel = trim($edicion) !== '' ? "{$edicion} Edición" : '';
        if ($anio !== '') {
          $edicionLabel = $edicionLabel !== '' ? "{$edicionLabel}, {$anio}" : "{$anio}";
        }
        // !!!!!
        // copien esto y pegenlo tal cual ->
        if(htmlspecialchars($fila['estatus'])=='A'){
          $estatus = 'ACTIVO';
          $colorEstatus= 'text-green-500 font-semibold [text-shadow:0_2px_4px_rgba(0,0,0,.3)]';
        }else{
          $estatus = 'INACTIVO';
          $colorEstatus= 'text-red-500 font-semibold [text-shadow:0_2px_4px_rgba(0,0,0,.3)]';
        }
        // <-
        
      ?>
      <!-- !!!!! -->
      <!-- Remplacen su div, por este                                                                   -->
    <div class="relative overflow-visible bg-white rounded-xl shadow p-4 flex items-center gap-4 hover:shadow-md transition group w-full max-w-[520px] border-[3px] border-[<?= $colorEstatus ?>]">

    <!-- Btn de Menú Kebab centrado derecha (Botón de tres puntos) -->
     <!-- Agregar en caso de no querer que sea clicleable la tarjeta: event.preventDefault() -->
    <button 
        class="absolute right-4 top-1/2 -translate-y-1/2 p-2 rounded hover:bg-gray-200 z-20 btn-kebab"
        onclick="event.stopPropagation();  toggleKebab(this)"
        aria-label="Abrir acciones">
        <img src="/Biblioteca/imagenes/btn Iconos/btnAcciones.png" class="size-6" alt="Acciones">
    </button>

    <!-- Menú Kebab: Ver detalles, Editar, Desactivar(Baja), Activar(Alta) -->
    <div class="menu-kebab hidden absolute right-4 top-14 bg-white shadow-lg rounded-lg border w-40 z-30">
      <!-- Detalles -->
       <!-- cambiar la ruta del archivo en  href y el pk-->
        <a href="detalle_libro.php?pkLibro=<?= $fila['pkLibro'] ?>"
          class="flex items-center gap-2 w-full text-left px-4 py-2 hover:bg-gray-100 hover:text-purple-400"
          onclick="event.stopPropagation();">
           <img src="/Biblioteca/imagenes/btn Iconos/btnVer.png" class="size-4">
           <span class="text-sm/6">Ver Detalles</span>
          </a>
          <!-- Editar -->
           <!-- cambiar la ruta del archivo en  href y el pk-->
        <a href="editar_libro.php?pkLibro=<?= $fila['pkLibro'] ?>"
          class="flex items-center gap-2 w-full text-left px-4 py-2 hover:bg-gray-100 hover:text-purple-400"
          onclick="event.stopPropagation();">
           <img src="/Biblioteca/imagenes/btn Iconos/btnEditar.png" class="size-4">
           <span class="text-sm/6">Editar</span>
          </a>
        <!-- Desactivar(si el registro está Activo) -->
        <?php if (($fila['estatus'] ?? '') === 'A'): ?>
          <!-- Desactivar -->
           <!-- cambiar la ruta del archivo en  href y el pk-->
          <a href="../controladores/desactivar_libro.php?pkLibro=<?= $fila['pkLibro'] ?>"
          class="flex items-center gap-2 w-full text-left px-4 py-2 hover:bg-gray-100 hover:text-red-400"
          onclick="event.stopPropagation();">
           <img src="/Biblioteca/imagenes/btn Iconos/btbBaja.png" class="size-4">
           <span class="text-sm/6">Desactivar</span>
          </a>
          <!-- Activar(si el registro está Inactivo) -->
        <?php else: ?>
          <!-- cambiar la ruta del archivo en  href y el pk-->
            <a href="../controladores/activar_libro.php?pkLibro=<?= $fila['pkLibro'] ?>"
          class="flex items-center gap-2 w-full text-left px-4 py-2 hover:bg-gray-100 hover:text-green-400"
          onclick="event.stopPropagation();">
           <img src="/Biblioteca/imagenes/btn Iconos/btnAlta.png" class="size-4">
           <span class="text-sm/6">Activar</span>
          </a>
        <?php endif; ?>
    </div>
    <!-- Contenido (Tarjeta)-->
    <a href="detalle_libro.php?pkLibro=<?= $fila['pkLibro'] ?>" 
       class="flex items-center gap-4 w-full">

        <!-- Portada (Sino tiene imagen, quient esto)--> 
        <img 
            src="<?= !empty($img) ? '../imagenes/portadas/' . $img : '../imagenes/portadas/placeholder.png'; ?>" 
            alt="Portada de <?= $titulo ?>" 
            class="w-24 h-32 object-cover rounded-lg flex-shrink-0"
        >

        <!-- Info -->
        <div class="flex flex-col gap-1 flex-1 mr-8">
            <h2 class="text-lg font-bold text-purple-900"><?= $titulo ?></h2>
            <p class="text-sm font-bold text-gray-700"><?= $autor ?></p>
            <p class="text-sm text-gray-600"><strong>ISBN:</strong> <?= $isbn ?></p>
            <p class="text-sm text-gray-600"><strong>Editorial:</strong> <?= $editorial ?></p>
            <p class="text-sm text-gray-600"><strong>Categoría:</strong> <?= $categoria ?></p>
            <p class="text-sm text-gray-500"><?= $edicionLabel ?></p>
            <!-- !!!!! Peguen esto al final aquí tal cual -->
            <p class="text-sm <?= $colorEstatus ?>"><?= $estatus ?></p>
        </div>

    </a>
<!-- hasta Acá (</a>) --> 
</div>
      <?php endforeach; ?>
    <?php else: ?>
      <!-- En caso de no encontrar nada/No tener Registros -->
      <p class="no-resultados">No se encontraron libros con esos filtros.</p>
    <?php endif; ?>
  </section>

  <!-- Script para filtros (panel) y kebab -->
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
  <!-- Footer -->
  <?php include('../includes/footer.php'); ?>
</body>
</html>
