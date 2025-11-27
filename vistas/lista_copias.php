<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Registro de Copias</title>
  <!-- Ponen estos enlaces -->
  <link rel="stylesheet" href="../css/listas.css">
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
        $resultadoSub = $clase->mostrar();
        include('../includes/menu.php');
	?>

<!-- !!!!!! -->
  <!-- Copian todo este Div y lo reemplazan por su div de Titulo y Linea separadora(es lo mismo pero con el boton acomodado) -->
  <div class="px-10 mb-6">
    <div class="flex items-center justify-between">
      <div>
        <!-- Nomas le dejan el nombre de su cosa -->
        <h1 class="titulos">Copias</h1>
      </div>

      <div class="flex items-center">
        <!-- !!!! Aquí le ponen el nombre de su formulario -->
        <a href="formulario_copia.php" class="rounded-md text-white font-medium transition bg-[#3BAA8D] hover:bg-[#abe4d5] hover:text-[#3BAA8D] border hover:border-[#3BAA8D]  shadow-sm px-4 py-2 w-full sm:w-40 text-center">
          <!-- Y así que cambian "Libro" por lo que vayan a hacer -->
          Agregar Copias
        </a>
      </div>
    </div>
    <hr class="linea-separadora-listas">
  </div>
<!-- !!!! -->
  <!-- Aquí agregan esto -->
  <!-- MENSAJE DE EXITO -->
<?php include('../includes/notificacion.php'); ?>


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
  <form method="GET" action="lista_copias.php" class="filtros hidden lg:flex flex-wrap items-center gap-x-4 gap-y-2">
    <input type="text" name="buscar" class="input-busqueda w-48"
           placeholder="Buscar por ISBN, Titulo, Folio..."
           value="<?= htmlspecialchars($_GET['buscar'] ?? '') ?>">

    <select name="estatus"  class="select-filtro w-40">
      <option value="">Estatus</option>
      <option value="A" <?= (($_GET['estatus'] ?? '') === 'A') ? 'selected' : '' ?>>Activo</option>
      <option value="I" <?= (($_GET['estatus'] ?? '') === 'I') ? 'selected' : '' ?>>Inactivo</option>
    </select>

    <select name="subcategoria" class="select-filtro">
      <option value="">Todas las categorías </option>
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

      <form method="GET" action="lista_copias.php" class="form-filtros-movil">
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

  <!-- LISTADO -->
<section class="grid-listas">

<?php if (!empty($resultadoCF)): ?>
<?php foreach ($resultadoCF as $fila): ?>

<?php 
$isbn = htmlspecialchars($fila['isbn']);
$folio = htmlspecialchars($fila['folio']);
$titulo = htmlspecialchars($fila['titulo']);
$nombreSubCategoria = htmlspecialchars($fila['nombreSubCategoria'] ?? '---');
$img = htmlspecialchars($fila['portada'] ?? null); // Trae la portada del libro (nuevo)

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
      <!-- Cambió de aqui -->
    <div class="relative overflow-visible bg-white rounded-xl shadow p-4 flex items-center gap-4 hover:shadow-md transition group w-full max-w-[520px]">

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
        <a href="detalle_copia.php?pkCopiaF=<?= $fila['pkCopiaF'] ?>"
          class="flex items-center gap-2 w-full text-left px-4 py-2 hover:bg-gray-100 hover:text-purple-400"
          onclick="event.stopPropagation();">
           <img src="/Biblioteca/imagenes/btn Iconos/btnVer.png" class="size-4">
           <span class="text-sm/6">Ver Detalles</span>
          </a>
          <!-- Editar -->
           <!-- cambiar la ruta del archivo en  href y el pk-->
        <a href="editar_copia.php?pkCopiaF=<?= $fila['pkCopiaF'] ?>"
          class="flex items-center gap-2 w-full text-left px-4 py-2 hover:bg-gray-100 hover:text-purple-400"
          onclick="event.stopPropagation();">
           <img src="/Biblioteca/imagenes/btn Iconos/btnEditar.png" class="size-4">
           <span class="text-sm/6">Editar</span>
          </a>
        <!-- Desactivar(si el registro está Activo) -->
        <?php if (($fila['estatus'] ?? '') === 'A'): ?>
          <!-- Desactivar -->
           <!-- cambiar la ruta del archivo en  href y el pk-->
          <a href="../controladores/desactivar_copia.php?pkCopiaF=<?= $fila['pkCopiaF'] ?>"
          class="flex items-center gap-2 w-full text-left px-4 py-2 hover:bg-gray-100 hover:text-red-400"
          onclick="event.stopPropagation();">
           <img src="/Biblioteca/imagenes/btn Iconos/btbBaja.png" class="size-4">
           <span class="text-sm/6">Desactivar</span>
          </a>
          <!-- Activar(si el registro está Inactivo) -->
        <?php else: ?>
          <!-- cambiar la ruta del archivo en  href y el pk-->
            <a href="../controladores/activar_copia.php?pkCopiaF=<?= $fila['pkCopiaF'] ?>"
          class="flex items-center gap-2 w-full text-left px-4 py-2 hover:bg-gray-100 hover:text-green-400"
          onclick="event.stopPropagation();">
           <img src="/Biblioteca/imagenes/btn Iconos/btnAlta.png" class="size-4">
           <span class="text-sm/6">Activar</span>
          </a>
        <?php endif; ?>
    </div>
    <!-- Contenido (Tarjeta)-->
    <a href="detalle_copia.php?pkCopiaF=<?= $fila['pkCopiaF'] ?>" 
       class="flex items-center gap-4 w-full">

        <!-- Portada (Sino tiene imagen, quient esto)--> 
        <img 
            src="<?= !empty($img) ? '../imagenes/portadas/' . $img : '../imagenes/portadas/placeholder.png'; ?>" 
            alt="Portada de <?= $titulo ?>" 
            class="w-24 h-32 object-cover rounded-lg flex-shrink-0"
        >

        <!-- Info -->
        <div class="flex flex-col gap-1 flex-1 mr-8">
            <p class="text-sm text-gray-600"><strong>ISBN:</strong> <?= $isbn ?></p>
            <p class="text-sm text-gray-600"><strong>Folio:</strong> <?= $folio ?></p>
            <p class="text-sm text-gray-600"><strong>Título:</strong> <?= $titulo ?></p>
            <p class="text-sm text-gray-600"><strong>Subcategoría:</strong> <?= $nombreSubCategoria ?></p>
            <p class="text-sm <?= $colorEstatus ?>"><?= $estatus ?></p>
        </div>

    </a>
<!-- hasta Acá (</a>) --> 
</div>
      <?php endforeach; ?>
    <?php else: ?>
      <!-- En caso de no encontrar nada/No tener Registros -->
      <p class="no-resultados">No se encontraron copias con esos filtros.</p>
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
