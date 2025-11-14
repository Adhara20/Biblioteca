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
    <h1 class="titulos">Usuarios</h1>
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

  <?php if (isset($_GET['success'])) { ?>
    <div class="bg-green-100 text-green-800 p-3 rounded-md mb-4 font-semibold">
      <?= htmlspecialchars($_GET['success']) ?>
    </div>
  <?php } ?>

  <!-- Lista envuelta en div (Esto no se lo agreuen, si ven que su contenido queda al borde, me dicen primero)-->
  <div class="px-8">
    <!-- Lista de usuarios -->
    <ul role="list" class="bg-gray-100">
      <?php foreach ($resultado as $fila) {
        // Obtener el Rol, y
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
        <li class="flex flex-col sm:flex-row items-center justify-between gap-4 p-4 bg-white rounded-xl shadow mb-4 hover:bg-gray-50 transition">
          <!--  Imagen -->
          <div class="flex-shrink-0">
            <!-- Mostrarla con la variable de la rutaImagen -->
            <img src="<?= htmlspecialchars($rutaImagen ?? '../imagenes/usuarios/default.png') ?>" 
                 alt="Foto de <?= htmlspecialchars($nombreCompleto) ?>" 
                 class="w-16 h-16 rounded-full object-cover border border-gray-300">
          </div>

          <!-- Info principal -->
          <div class="flex-1 text-center sm:text-left">
            <p class="text-lg font-semibold text-[#4F0087]"><?= htmlspecialchars($nombreCompleto) ?></p>
            <p class="text-sm text-gray-600"><?= htmlspecialchars($fila["curp"] ?? '') ?></p>
            <p class="text-xs text-gray-500">Núm. Credencial: <?= htmlspecialchars($fila["numCredencial"] ?? '') ?></p>
          </div>

          <!-- Info a la derecha -->
          <div class="text-sm text-center sm:text-right">
            <p class="font-medium"><?= $rolTraducido ?></p>
            <p class="text-gray-500">Edad: <?= $clase->obtenerEdad($fila["fechaNac"]) ?></p>
            <p class="text-xs text-gray-400">Nacido el <?= htmlspecialchars($fila["fechaNac"]) ?></p>
          </div>
      </li>
      <?php } ?>
    </ul>
  </div>

  <?php include('../includes/footer.php'); ?>

  <!-- Script abrir/cerrar panel -->
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
