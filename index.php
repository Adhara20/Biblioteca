<?php include('includes/header.php'); ?>
<?php include('includes/menu.php'); ?>

<main class="flex-grow mt-24 flex flex-col items-center justify-center">
  <?php if ($nombreLog): ?>
    <h2 class="text-3xl font-semibold text-[#4F0087] mb-4">
  BIENVENIDO(A), 
  <span class="text-[#7A33B2]"><?= htmlspecialchars($nombreLog) ?></span>
</h2>

  <?php else: ?>
    <h2 class="text-3xl font-semibold text-[#4F0087] mb-4">Bienvenido a Owl Book</h2>
    <p class="text-gray-600">Por favor, inicia sesión para continuar.</p>
  <?php endif; ?>
</main>

<?php include('includes/footer.php'); ?>
