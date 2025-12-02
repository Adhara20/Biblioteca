<?php include('../includes/header.php'); ?>
<?php include('../includes/menu.php'); ?>

<?php
$carpeta = "../imagenes/portadas/";
$extensiones = ["jpg", "jpeg", "png", "webp", "gif"];
$imagenes = [];

foreach (glob($carpeta . "*") as $archivo) {
    $ext = strtolower(pathinfo($archivo, PATHINFO_EXTENSION));
    if (in_array($ext, $extensiones)) {
        $imagenes[] = $archivo;
    }
}

shuffle($imagenes);
$imagenes = array_slice($imagenes, 0, 15);
?>


<main class="flex-grow mt-10 flex flex-col items-center justify-center">
  <?php if ($nombreLog): ?>
    <h2 class="text-3xl font-semibold text-[#4F0087] mb-4">
  BIENVENIDO(A), 
  <span class="text-[#7A33B2]"><?= htmlspecialchars($nombreLog) ?></span>
</h2>

  <?php else: ?>
    <h2 class="text-3xl font-semibold text-[#4F0087] mb-4">Bienvenido a Owl Book</h2>
    <p class="text-gray-600">Por favor, inicia sesión para continuar.</p>
  <?php endif; ?>

    <div class="swiper w-full max-w-5xl h-96 rounded-xl overflow-hidden shadow-xl mt-10">
    <div class="swiper-wrapper">
        <?php foreach ($imagenes as $img): ?>
            <div class="swiper-slide flex items-center justify-center bg-gray-100">
                <img src="<?= $img ?>" 
                     class="max-h-80 object-contain" 
                     alt="Portada">
            </div>
        <?php endforeach; ?>
    </div>

    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-pagination"></div>
</div>



<script>
var swiper = new Swiper('.swiper', {
    loop: true,
    autoplay: {
        delay: 3000,
        disableOnInteraction: false,
    },
    slidesPerView: 3,     
    slidesPerGroup: 3,   
    spaceBetween: 10,    

    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
});
</script>


</main>

<?php include('../includes/footer.php'); ?>
