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
      <!-- Botón de Iniciar Sesión (solo visible sin iniciar Sesión) -->
      <a href="<?=$rutaBase?>vistas/login.php" class="bg-white text-[#4F0087] px-4 py-2 rounded-lg font-semibold hover:bg-[#E5E0F2] transition">
        Iniciar sesión
      </a>
    <?php else: ?>
      <button id="hamburger" class="text-white text-2xl lg:hidden focus:outline-none">☰</button>
    <?php endif; ?>
  </div>

  <?php if ($rol): ?>
<!-- Menú principal de Opciones (solo visible al iniciar Sesión)-->
  <div id="menu" class="hidden flex-col absolute right-0 bg-white shadow-lg lg:static lg:flex lg:flex-row 
                       lg:justify-end lg:items-center lg:space-x-6 px-6 py-2">

    <a href="<?=$rutaBase?>index.php" class="block py-2 text-gray-800 hover:text-[#4F0087]">Inicio</a>
    <a href="<?=$rutaBase?>vistas/lista_libros.php" class="block py-2 text-gray-800 hover:text-[#4F0087]">Libros</a>
<!-- Puede ver Bibliotecario y Admin -->
    <?php if ($rol === 'A' || $rol === 'B'): ?>
      <a href="<?=$rutaBase?>vistas/lista_prestamos.php" class="block py-2 text-gray-800 hover:text-[#4F0087]">Préstamos</a>
      <a href="<?=$rutaBase?>vistas/lista_categoria.php" class="block py-2 text-gray-800 hover:text-[#4F0087]">Clasificaciones</a>
      <a href="<?=$rutaBase?>vistas/lista_multas.php" class="block py-2 text-gray-800 hover:text-[#4F0087]">Multas</a>
    <?php endif; ?>
<!-- Puede ver Admin -->
    <?php if ($rol === 'A'): ?>
      <a href="<?=$rutaBase?>vistas/lista_usuarios.php" class="block py-2 text-gray-800 hover:text-[#4F0087]">Usuarios</a>
    <?php endif; ?>
<!-- Puede ver Bibliotecario y Admin -->
    <?php if ($rol === 'A' || $rol === 'B'): ?>
      <!-- Gestión Bibliográfica Compu -->
      <div class="relative group hidden lg:block">
        <button class="block py-2 text-gray-800 hover:text-[#4F0087] w-full text-left lg:text-center">
          Gestión Bibliográfica ▼
        </button>
        <div class="hidden group-hover:flex lg:absolute lg:flex-col bg-white shadow-md border rounded-md mt-1 min-w-[180px]">
          <a href="<?=$rutaBase?>vistas/lista_autor.php" class="px-4 py-2 hover:bg-gray-100">Autores</a>
          <a href="<?=$rutaBase?>vistas/lista_editoriales.php" class="px-4 py-2 hover:bg-gray-100">Editoriales</a>
          <a href="<?=$rutaBase?>vistas/lista_nacionalidades.php" class="px-4 py-2 hover:bg-gray-100">Nacionalidades</a>
        </div>
      </div>
      <!-- Gestión Bibliográfica Movil -->
      <button id="btn-submenu" class="block py-2 text-gray-800 hover:text-[#4F0087] w-full text-left lg:hidden">
        Gestión Bibliográfica →
      </button>
      <div id="offcanvas-submenu" class="fixed top-0 right-[-100%] h-full w-64 bg-white shadow-lg transition-all flex flex-col z-50 lg:hidden">
        <div class="flex justify-between items-center p-4 border-b">
          <span class="font-semibold">Gestión Bibliográfica</span>
          <button id="close-submenu" class="text-gray-700 text-xl">&times;</button>
        </div>
        <a href="<?=$rutaBase?>vistas/lista_autor.php" class="px-4 py-2 hover:bg-gray-100">Autores</a>
        <a href="<?=$rutaBase?>vistas/lista_editoriales.php" class="px-4 py-2 hover:bg-gray-100">Editoriales</a>
        <a href="<?=$rutaBase?>vistas/lista_nacionalidades.php" class="px-4 py-2 hover:bg-gray-100">Nacionalidades</a>
      </div>
    <?php endif; ?>
<!-- Puede ver Lector -->
    <?php if ($rol === 'L'): ?>
      <a href="<?=$rutaBase?>vistas/mis_prestamos.php" class="block py-2 text-gray-800 hover:text-[#4F0087]">Mis Préstamos</a>
      <a href="<?=$rutaBase?>vistas/mis_multas.php" class="block py-2 text-gray-800 hover:text-[#4F0087]">Mis Multas</a>
    <?php endif; ?>
      <!-- Mandar el pk del Usuario Logeado para que se muestre ese perfil -->
    <a href="<?=$rutaBase?>vistas/detalle_usuario.php?pkUsuario=<?=$_SESSION['pkUsuarioLog']?>" class="block py-2 text-gray-800 hover:text-[#4F0087]">
      Mi Perfil
    </a>

    <a href="<?=$rutaBase?>controladores/cerrar_sesion.php" class="block py-2 text-gray-800 hover:text-[#4F0087]">Salir</a>
  </div>
  <?php endif; ?>
</nav>
<!-- Scrip para hacer funcionar el Menú de Opciones -->
<script>
// Menú principal mobile
const hamburger = document.getElementById('hamburger');
const menu = document.getElementById('menu');
hamburger?.addEventListener('click', () => {
  menu.classList.toggle('hidden');
  menu.classList.toggle('flex');
});

// Submenú mobile off-canvas
const btnSubmenu = document.getElementById('btn-submenu');
const offcanvasSubmenu = document.getElementById('offcanvas-submenu');
const closeSubmenu = document.getElementById('close-submenu');

btnSubmenu?.addEventListener('click', () => {
  offcanvasSubmenu.style.right = '0';
});

closeSubmenu?.addEventListener('click', () => {
  offcanvasSubmenu.style.right = '-100%';
});

// Clic afuera para cerrar off-canvas
document.addEventListener('click', (e) => {
  if (window.innerWidth < 1024) {
    if (!offcanvasSubmenu.contains(e.target) && !btnSubmenu.contains(e.target)) {
      offcanvasSubmenu.style.right = '-100%';
    }
  }
});
</script>
<!-- <main class="bg-gray-100 min-h-screen flex flex-col items-start justify-start pt-36 px-8"> -->
  <!-- <main class="bg-gray-100 min-h-screen pt-36 px-8"> -->
<main class="bg-gray-100 flex flex-col min-h-screen pt-36">
  <div class="flex-1">
  



