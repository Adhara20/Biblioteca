<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include('includes/header.php'); ?>
<body>

<?php 
include('includes/menu.php');
include('includes/notificacion.php');
?>

<main class="flex-grow mt-24 flex flex-col items-center px-4">
  <?php if ($nombreLog): ?>
  <h2 class="text-2xl sm:text-3xl lg:text-4xl font-semibold text-[#4F0087] mb-4 text-center px-4">
    BIENVENIDO(A), 
    <span class="text-[#7A33B2] block sm:inline">
      <?= htmlspecialchars($nombreLog) ?>
    </span>
  </h2>
<?php else: ?>
  <h2 class="text-2xl sm:text-3xl lg:text-4xl font-semibold text-[#4F0087] mb-2 text-center px-4">
    Bienvenido a Owl Book
  </h2>

  <p class="text-gray-600 text-center text-base sm:text-lg px-6">
    Por favor, inicia sesión para continuar.
  </p>
<?php endif; ?>


  <?php 
  if ($rol != 'L' && $estatusLog == 'A') {
      require_once 'clases/dashboard.php';
      // $dash = new Dashboard();
      include(__DIR__ . '/index/indexSupremo.php');
  } else { ?>
      <?php
      include(__DIR__ . '/index/indexLector.php');
  }
  ?>
</main>

<?php include('includes/footer.php'); ?>
</body>
