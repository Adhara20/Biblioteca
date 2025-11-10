<?php
if (!isset($_SESSION)) {
  session_start();
}
$nombre = $_SESSION['nombre'] ?? null;
?>

<?php include('includes/header.php'); ?>
<?php include('includes/menu.php'); ?>

<main class="flex-grow mt-24 flex flex-col items-center justify-center">
  <?php if ($nombre): ?>
    <h2 class="text-3xl font-semibold text-[#4F0087] mb-4">
      Bienvenido(a), <?= htmlspecialchars($nombre) ?> 
    </h2>
  <?php else: ?>
    <h2 class="text-3xl font-semibold text-[#4F0087] mb-4">Bienvenido a Owl Book</h2>
    <p class="text-gray-600">Por favor, inicia sesión para continuar.</p>
  <?php endif; ?>
</main>

<?php include('includes/footer.php'); ?>
