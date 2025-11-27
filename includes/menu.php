<?php
if (!isset($_SESSION)) {
  session_start();
}
$pkUsuarioLog = $_SESSION['pkUsuarioLog'] ?? null;
$rol = $_SESSION['rol'] ?? null;
$nombreLog = $_SESSION['nombreLog'] ?? null;
$estatusLog = $_SESSION['estatusLog'] ?? null;
// hacer una direccion universal para no tener problemas
$rutaBase = (strpos($_SERVER['PHP_SELF'], '/vistas/') !== false) ? '../' : '';
?>

<nav class="fixed top-0 left-0 w-full z-50 h-28">
  <!-- Logo y Nombre (Visible siempre) -->
  <div class="bg-[#4F0087] flex justify-between items-center px-6 py-3">
    <div class="flex items-center">
      <img src="../imagenes/logos/lechuzaSombraLuna.jpg" class="h-10 mr-3" alt="Logo">
      <h1 class="text-gray-100 text-xl font-normal" style="font-family: 'Marcellus SC', serif;">Owl Book</h1>
    </div>

    <?php if (!$rol): ?>
      <a href="<?=$rutaBase?>vistas/login.php" class="bg-white text-[#4F0087] px-4 py-2 rounded-lg font-semibold hover:bg-[#E5E0F2] transition">
        Iniciar sesión
      </a>
    <?php else: ?>
      <button id="hamburger" class="text-white text-2xl lg:hidden focus:outline-none">☰</button>
    <?php endif; ?>
  </div>

  <?php if ($rol): ?>
  <div id="menu" class="hidden flex-col absolute right-0 bg-white shadow-lg lg:static lg:flex lg:flex-row 
                       lg:justify-end lg:items-center lg:space-x-6 px-6 py-2">

    <a href="<?=$rutaBase?>index.php" class="block py-2 text-gray-800 hover:text-[#4F0087]">Inicio</a>
    <a href="<?=$rutaBase?>vistas/lista_libros.php" class="block py-2 text-gray-800 hover:text-[#4F0087]">Libros</a>

    <?php if ($rol === 'A' || $rol === 'B'): ?>
      <a href="<?=$rutaBase?>vistas/lista_prestamos.php" class="block py-2 text-gray-800 hover:text-[#4F0087]">Préstamos</a>

      <!-- Clasificaciones PC -->
      <div class="relative group hidden lg:block">
        <button class="flex block py-2 text-gray-800 hover:text-[#4F0087] w-full text-left lg:text-center">
          Clasicicaciones <img src="<?=$rutaBase?>imagenes/btn Iconos/abajoFlecha.png" class="size-3 mt-2 ml-1">
        </button>
        <div class="hidden group-hover:flex lg:absolute lg:flex-col bg-white shadow-md border rounded-md mt-1 min-w-[180px]">
          <a href="<?=$rutaBase?>vistas/lista_categoria.php" class="px-4 py-2 hover:bg-gray-100">Categorías</a>
          <a href="<?=$rutaBase?>vistas/lista_subcategoria.php" class="px-4 py-2 hover:bg-gray-100">Subcategorías</a>
        </div>
      </div>

      <!-- Clasificaciones Móvil -->
      <button id="btn-submenu-clas" class="flex block py-2 text-gray-800 hover:text-[#4F0087] w-full text-left lg:hidden">
        Clasicicaciones <img src="<?=$rutaBase?>imagenes/btn Iconos/drchFlecha.png" class="size-3 mt-2 ml-1">
      </button>
      <div id="offcanvas-clas" class="fixed top-0 right-[-100%] h-full w-64 bg-white shadow-lg transition-all flex flex-col z-50 lg:hidden">
        <div class="flex justify-between items-center p-4 border-b">
          <span class="font-semibold">Clasicicaciones</span>
          <button id="close-clas" class="text-gray-700 text-xl">&times;</button>
        </div>
        <a href="<?=$rutaBase?>vistas/lista_categoria.php" class="px-4 py-2 hover:bg-gray-100">Categorías</a>
        <a href="<?=$rutaBase?>vistas/lista_subcategoria.php" class="px-4 py-2 hover:bg-gray-100">Subcategorías</a>
      </div>

      <a href="<?=$rutaBase?>vistas/lista_multas.php" class="block py-2 text-gray-800 hover:text-[#4F0087]">Multas</a>
      <a href="<?=$rutaBase?>vistas/lista_copias.php" class="block py-2 text-gray-800 hover:text-[#4F0087]">Ejemplares</a>
    <?php endif; ?>

    <?php if ($rol === 'A'): ?>
      <a href="<?=$rutaBase?>vistas/lista_usuarios.php" class="block py-2 text-gray-800 hover:text-[#4F0087]">Usuarios</a>
    <?php endif; ?>

    <?php if ($rol === 'A' || $rol === 'B'): ?>
      <!-- Gestión Bibliográfica PC -->
      <div class="relative group hidden lg:block">
        <button class="flex block py-2 text-gray-800 hover:text-[#4F0087] w-full text-left lg:text-center">
          Gestión Bibliográfica <img src="<?=$rutaBase?>imagenes/btn Iconos/abajoFlecha.png" class="size-3 mt-2 ml-1">
        </button>
        <div class="hidden group-hover:flex lg:absolute lg:flex-col bg-white shadow-md border rounded-md mt-1 min-w-[180px]">
          <a href="<?=$rutaBase?>vistas/lista_autor.php" class="px-4 py-2 hover:bg-gray-100">Autores</a>
          <a href="<?=$rutaBase?>vistas/lista_editoriales.php" class="px-4 py-2 hover:bg-gray-100">Editoriales</a>
          <a href="<?=$rutaBase?>vistas/lista_nacionalidades.php" class="px-4 py-2 hover:bg-gray-100">Nacionalidades</a>
        </div>
      </div>

      <!-- Gestión Bibliográfica Móvil -->
      <button id="btn-submenu-ges" class="flex block py-2 text-gray-800 hover:text-[#4F0087] w-full text-left lg:hidden">
        Gestión Bibliográfica <img src="<?=$rutaBase?>imagenes/btn Iconos/drchFlecha.png" class="size-3 mt-2 ml-1">
      </button>
      <div id="offcanvas-ges" class="fixed top-0 right-[-100%] h-full w-64 bg-white shadow-lg transition-all flex flex-col z-50 lg:hidden">
        <div class="flex justify-between items-center p-4 border-b">
          <span class="font-semibold">Gestión Bibliográfica</span>
          <button id="close-ges" class="text-gray-700 text-xl">&times;</button>
        </div>
        <a href="<?=$rutaBase?>vistas/lista_autor.php" class="px-4 py-2 hover:bg-gray-100">Autores</a>
        <a href="<?=$rutaBase?>vistas/lista_editoriales.php" class="px-4 py-2 hover:bg-gray-100">Editoriales</a>
        <a href="<?=$rutaBase?>vistas/lista_nacionalidades.php" class="px-4 py-2 hover:bg-gray-100">Nacionalidades</a>
      </div>
    <?php endif; ?>

    <?php if ($rol === 'L'): ?>
      <a href="<?=$rutaBase?>vistas/lista_prestamos.php" class="block py-2 text-gray-800 hover:text-[#4F0087]">Mis Préstamos</a>
      <a href="<?=$rutaBase?>vistas/lista_multas.php" class="block py-2 text-gray-800 hover:text-[#4F0087]">Mis Multas</a>
    <?php endif; ?>

    <a href="<?=$rutaBase?>vistas/detalle_usuario.php?pkUsuario=<?=$_SESSION['pkUsuarioLog']?>" class="block py-2 text-gray-800 hover:text-[#4F0087]">
      Mi Perfil
    </a>

    <a href="<?=$rutaBase?>controladores/cerrar_sesion.php" class="block py-2 text-gray-800 hover:text-[#4F0087]">Salir</a>
  </div>
  <?php endif; ?>
</nav>

<!-- Scripts -->
<script>
const hamburger = document.getElementById('hamburger');
const menu = document.getElementById('menu');
hamburger?.addEventListener('click', () => {
  menu.classList.toggle('hidden');
  menu.classList.toggle('flex');
});

/* ─────────────── CLASIFICACIONES ─────────────── */
const btnClas = document.getElementById('btn-submenu-clas');
const offClas = document.getElementById('offcanvas-clas');
const closeClas = document.getElementById('close-clas');

btnClas?.addEventListener('click', () => { offClas.style.right = '0'; });
closeClas?.addEventListener('click', () => { offClas.style.right = '-100%'; });

/* ─────────────── GESTIÓN BIBLIOGRÁFICA ─────────────── */
const btnGes = document.getElementById('btn-submenu-ges');
const offGes = document.getElementById('offcanvas-ges');
const closeGes = document.getElementById('close-ges');

btnGes?.addEventListener('click', () => { offGes.style.right = '0'; });
closeGes?.addEventListener('click', () => { offGes.style.right = '-100%'; });

// Cerrar si se hace clic fuera
document.addEventListener('click', (e) => {
  if (window.innerWidth < 1024) {
    if (!offClas.contains(e.target) && !btnClas.contains(e.target)) offClas.style.right = '-100%';
    if (!offGes.contains(e.target) && !btnGes.contains(e.target)) offGes.style.right = '-100%';
  }
});
</script>

<main class="bg-gray-100 flex flex-col min-h-screen pt-36">
  <div class="flex-1">
