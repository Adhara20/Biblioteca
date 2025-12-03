<?php
require_once('../includes/auth.php');

// Solo Admin y Bibliotecario
requireRole(['A', 'B']);
?>
<?php
ob_start();
include('../clases/libro.php');

$claseLibro = new Libro();

// Por si el libro se especifico en lista
$fkLibro = $_GET['pkLibro'] ?? NULL;
$isbnLibro = $_GET['isbn'] ?? NULL;



// Obtener todos los libros activos
$libros = $claseLibro->verLibro();

ob_end_clean();
?>

<?php include('../includes/header.php'); ?>
<body class="bg-gray-100 text-gray-900">

<?php include('../includes/menu.php'); ?>

<?php include('../includes/notificacion.php'); ?>

<div class="w-full max-w-3xl bg-white shadow-lg rounded-2xl p-8 lg:p-12 border border-gray-300 mx-auto mb-10">
    <h2 class="text-2xl font-semibold text-center text-[#4F0087] mb-6">
        Formulario URL
    </h2>

    <form action="../controladores/insertar_url.php" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <!-- URL -->
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700">URL<span class="text-red-500 text-2xl">*</span></label>
            <input type="url" name="url" placeholder="https://ejemplo.com" required
                class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087] uppercase"
                value="<?= $_SESSION['form_url']['url'] ?? '' ?>">
        </div>

    <?php if($fkLibro): ?>
    <!-- Libro específico -->
    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-gray-700">ISBN del Libro</label>
        <input type="hidden" name="fkLibro" value="<?= htmlspecialchars($fkLibro) ?>">
        <input type="text" name="isbnLibro" placeholder="eje. 9781368098014" required
            class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087] uppercase"
            value="<?= htmlspecialchars($isbnLibro) ?>">
    </div>
<?php else: ?>
    <!-- Selección de libro -->
    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-gray-700">Libro<span class="text-red-500 text-2xl">*</span></label>
        <select name="fkLibro" class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087] bg-white" required>
            <option value="">Seleccione un libro</option>
                <?php foreach ($libros as $libro): ?>
                    <option value="<?= $libro['pkLibro'] ?>"
                        <?= (isset($_SESSION['form_url']['fkLibro']) && $_SESSION['form_url']['fkLibro'] == $libro['pkLibro']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($libro['titulo']) ?>
                    </option>
                <?php endforeach; ?>
        </select>
    </div>
<?php endif; ?>


        <!-- Botones -->
        <div class="md:col-span-2 flex flex-col gap-3 md:flex-row md:justify-end mt-4">
            <a href="lista_urls.php"
                class="w-full md:w-32 text-center bg-[#B55780] text-white py-2 rounded-md font-semibold hover:bg-[#c46b93] transition">
                Cancelar
            </a>
            <button type="submit"
                class="w-full md:w-32 bg-[#4F0087] text-white py-2 rounded-md font-semibold hover:bg-[#6A00B8] transition">
                Guardar
            </button>
        </div>

    </form>
</div>

<?php include('../includes/footer.php'); ?>
</body>
