<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lista de Usuarios</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="../css/filtros.css">
</head>

<?php
include('../includes/header.php');
include('../clases/usuario.php');
// Controlador (ajusta a filtrar_usuarios si lo separas)
include('../controladores/filtrar_usuarios.php');
?>

<body>
  <?php include('../includes/menu.php'); ?>

  <div class="px-10 mb-6">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="titulos">Usuarios</h1>
      </div>
      <div class="flex items-center">
        <?php if($rol == 'A' && $estatusLog == 'A') ?>
        <a href="formulario_usuario.php" 
          class="rounded-md text-white font-medium transition bg-[#3BAA8D] hover:bg-[#abe4d5] hover:text-[#3BAA8D] border hover:border-[#3BAA8D]  shadow-sm px-4 py-2 w-full sm:w-40 text-center">
          Agregar Usuario
        </a>
      </div>
    </div>
    <hr class="linea-separadora-listas">
  </div>

<!-- Mensaje de Exito para: insertar, dar de baja o alta (editar se muesta en Detalle, no listas) -->
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
  <form method="GET" action="lista_usuarios.php" class="filtros hidden lg:flex flex-wrap items-center gap-x-4 gap-y-2">
    <input type="text" name="buscar" class="input-busqueda w-48"
           placeholder="Buscar por Nombre, CURP, Número de Credencia..."
           value="<?= htmlspecialchars($_GET['buscar'] ?? '') ?>">

    <select name="rol"  class="select-filtro w-40">
      <option value="">Rol</option>
      <option value="A" <?= (($_GET['rol'] ?? '') === 'A') ? 'selected' : '' ?>>Admin</option>
      <option value="B" <?= (($_GET['rol'] ?? '') === 'B') ? 'selected' : '' ?>>Bibliotecario</option>
      <option value="L" <?= (($_GET['rol'] ?? '') === 'L') ? 'selected' : '' ?>>Lector</option>
    </select>

    <select name="estatus"  class="select-filtro w-40">
      <option value="">Estatus</option>
      <option value="A" <?= (($_GET['estatus'] ?? '') === 'A') ? 'selected' : '' ?>>Activo</option>
      <option value="I" <?= (($_GET['estatus'] ?? '') === 'I') ? 'selected' : '' ?>>Inactivo</option>
    </select>

    <select name="vetado"  class="select-filtro w-40">
      <option value="">Estado Prestamista</option>
      <option value="A" <?= (($_GET['vetado'] ?? '') === 'A') ? 'selected' : '' ?>>Activo</option>
      <option value="V" <?= (($_GET['vetado'] ?? '') === 'V') ? 'selected' : '' ?>>Vetado</option>
    </select>

    <select name="sexo"  class="select-filtro w-36">
      <option value="">Género</option>
      <option value="M" <?= (($_GET['sexo'] ?? '') === 'M') ? 'selected' : '' ?>>Masculino</option>
      <option value="F" <?= (($_GET['sexo'] ?? '') === 'F') ? 'selected' : '' ?>>Femenino</option>
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

        <select name="rol" class="select-filtro">
          <option value="">Rol</option>
          <option value="A" <?= (($_GET['rol'] ?? '') === 'A') ? 'selected' : '' ?>>Admin</option>
          <option value="B" <?= (($_GET['rol'] ?? '') === 'B') ? 'selected' : '' ?>>Bibliotecario</option>
          <option value="L" <?= (($_GET['rol'] ?? '') === 'L') ? 'selected' : '' ?>>Lector</option>
        </select>

        <select name="estatus" class="select-filtro">
          <option value="">Estatus</option>
          <option value="A" <?= (($_GET['estatus'] ?? '') === 'A') ? 'selected' : '' ?>>Activo</option>
          <option value="I" <?= (($_GET['estatus'] ?? '') === 'I') ? 'selected' : '' ?>>Inactivo</option>
        </select>

        <select name="vetado" class="select-filtro">
          <option value="">Estado Prestamista</option>
          <option value="A" <?= (($_GET['vetado'] ?? '') === 'A') ? 'selected' : '' ?>>Activo</option>
          <option value="V" <?= (($_GET['vetado'] ?? '') === 'V') ? 'selected' : '' ?>>Vetado</option>
        </select>

        <select name="sexo" class="select-filtro">
          <option value="">Género</option>
          <option value="M" <?= (($_GET['sexo'] ?? '') === 'M') ? 'selected' : '' ?>>Masculino</option>
          <option value="F" <?= (($_GET['sexo'] ?? '') === 'F') ? 'selected' : '' ?>>Femenino</option>
        </select>

        <button type="submit" class="btn-filtro">Aplicar filtros</button>
      </form>
    </div>
  </div>

  <!-- Lista envuelta en div (Esto no se lo agreuen, si ven que su contenido queda al borde, me dicen primero)-->
  <div class="px-8">
    <!-- Lista de usuarios -->
    <ul role="list" class="bg-gray-100">
      <?php foreach ($resultado as $fila) {
        // Obtener el Rol y traducir
        if ($fila["rol"] === 'A') {
        $rolTraducido = 'Administrador';
        } elseif ($fila["rol"] === 'B') {
            $rolTraducido = 'Bibliotecario';
        } elseif ($fila["rol"] === 'L') {
            $rolTraducido = 'Lector';
        } else {
            $rolTraducido = 'Desconocido';
        }
        // Obtener el nombre completo del Usuario
        $nombreCompleto = $fila["nombreCompleto"];
        // Obtener la foto del usuario y guardarla en una variable
        $rutaImagen = !empty($fila["foto"]) ? "../imagenes/usuarios/" . $fila["foto"] : "../imagenes/usuarios/default.png"; // imagen por defecto
      ?>
        <li 
        onclick="window.location='detalle_usuario.php?pkUsuario=<?= $fila['pkUsuario'] ?>'"
        class="relative flex flex-col sm:flex-row items-center justify-between gap-4 p-4 bg-white rounded-xl shadow mb-4 hover:bg-gray-50 transition">
          <!-- Imagen -->
          <div class="flex-shrink-0">
            <img src="<?= htmlspecialchars($rutaImagen ?? '../imagenes/usuarios/default.png') ?>" 
                 alt="Foto de <?= htmlspecialchars($nombreCompleto) ?>" 
                 class="w-16 h-16 rounded-full object-cover border border-gray-300">
          </div>

          <!-- Info principal -->
          <div class="flex-1 text-center sm:text-left">
            <p class="text-lg font-semibold text-[#4F0087]"><?= htmlspecialchars($nombreCompleto) ?></p>
            <p class="text-xs text-gray-500"><span class="font-semibold">Núm. Credencial:</span> <span class="font-bold"><?= htmlspecialchars($fila["numCredencial"] ?? '') ?></span></p>
            <p class="text-sm text-gray-600"><span class="font-semibold">CURP:</span> <?= htmlspecialchars($fila["curp"] ?? '') ?></p>
          </div>

          <!-- Info a la derecha -->
          <div class="text-sm text-center sm:text-right sm:pr-14">
            <p class="font-medium"><?= $rolTraducido ?></p>
            <p class="text-gray-500"><span class="font-medium">Edad:</span> <?= $clase->obtenerEdad($fila["fechaNac"]) ?> años</p>
            <p class="text-xs text-gray-700 font-medium">Nacido el <?= htmlspecialchars($fila["fechaNac"]) ?></p>
            <?php
              if(htmlspecialchars($fila["estatus"] ?? '') == 'A' ){
                $estatus='ACTIVO';
                $color= 'text-green-500 font-extrabold [text-shadow:0_2px_4px_rgba(0,0,0,.3)]';
              }else{
                $estatus='INACTIVO';
                $color= 'text-red-400 font-extrabold [text-shadow:0_2px_4px_rgba(0,0,0,.3)]';
              }
            ?>
            <p class="text-xs <?= $color ?>"><?= $estatus ?></p>
          </div>

          <!-- Botón Kebab (tres puntitos) -->
          <button 
              class="absolute right-4 top-1/2 -translate-y-1/2 p-2 rounded hover:bg-gray-200 z-20 btn-kebab"
              onclick="event.stopPropagation(); toggleKebab(this)"
              aria-label="Abrir acciones">
              <img src="../imagenes/btn Iconos/btnAcciones.png" class="w-6 h-6" alt="Acciones">
          </button>

          <!-- Menú Kebab -->
          <div class="menu-kebab hidden absolute right-4 top-14 bg-white shadow-lg rounded-lg border w-40 z-30">
            <a href="detalle_usuario.php?pkUsuario=<?= $fila['pkUsuario'] ?>"
               class="flex items-center gap-2 w-full text-left px-4 py-2 hover:bg-gray-100 hover:text-purple-400"
               onclick="event.stopPropagation();">
               <img src="../imagenes/btn Iconos/btnVer.png" class="w-4 h-4">
               <span class="text-sm">Ver Detalles</span>
            </a>
              <!-- ¡Agregar! -->
          <?php if($rol == 'A' && $estatusLog == 'A'){ ?>
            <a href="editar_usuario.php?pkUsuario=<?= $fila['pkUsuario'] ?>"
               class="flex items-center gap-2 w-full text-left px-4 py-2 hover:bg-gray-100 hover:text-purple-400"
               onclick="event.stopPropagation();">
               <img src="../imagenes/btn Iconos/btnEditar.png" class="w-4 h-4">
               <span class="text-sm">Editar</span>
            </a>

            <?php if ($fila['estatus'] === 'A'): ?>
              <a href="../controladores/desactivar_usuario.php?pkUsuario=<?= $fila['pkUsuario'] ?>"
                 class="flex items-center gap-2 w-full text-left px-4 py-2 hover:bg-gray-100 hover:text-red-400"
                 onclick="event.stopPropagation();">
                 <img src="../imagenes/btn Iconos/btbBaja.png" class="w-4 h-4">
                 <span class="text-sm">Desactivar</span>
              </a>
            <?php else: ?>
              <a href="../controladores/activar_usuario.php?pkUsuario=<?= $fila['pkUsuario'] ?>"
                 class="flex items-center gap-2 w-full text-left px-4 py-2 hover:bg-gray-100 hover:text-green-400"
                 onclick="event.stopPropagation();">
                 <img src="../imagenes/btn Iconos/btnAlta.png" class="w-4 h-4">
                 <span class="text-sm">Activar</span>
              </a>
            <?php endif; ?>
          <?php } ?>
          <!-- !-! -->
          </div>
        </li>

      <?php } ?>
    </ul>
  </div>

  <?php include('../includes/footer.php'); ?>

  <!-- Script abrir/cerrar panel -->
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
</body>
</html>
