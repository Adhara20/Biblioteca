<?php include('../includes/header.php'); ?>
<body class="bg-gray-100 text-gray-900">

<?php include('../includes/menu.php'); ?>
<?php include('../includes/notificacion.php'); ?>

<?php 

$form = $_SESSION['form_multa'] ?? [];
$codigoPrestamo = $_GET['codigoPrestamo'] ?? null;
?>

<div class="w-full max-w-3xl bg-white shadow-lg rounded-2xl p-8 lg:p-10 border border-gray-300 mx-auto">

    <h2 class="text-2xl font-semibold text-center text-[#4F0087]">
        Registrar Multa
    </h2>

    <form action="../controladores/insertar_multa.php" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <!-- Tipo de multa -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Tipo de Multa</label>
            <select name="tipoMulta" required
                class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087] bg-white">
                <option value="">Seleccione un tipo</option>
                <option value="Daño"    <?= ($form['tipoMulta'] ?? '') === 'Daño' ? 'selected':'' ?>>Daño</option>
                <option value="Perdido" <?= ($form['tipoMulta'] ?? '') === 'Perdido' ? 'selected':'' ?>>Perdido</option>
            </select>
        </div>

        <!-- Monto -->
<div>
    <label class="block text-sm font-medium text-gray-700 w-1/2">Monto</label>

    <div class="relative">
        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">$</span>

        <input type="number" min="0" max="9999.99" step="0.01" pattern="^\d+(\.\d{1,2})?$" name="montoMulta" placeholder="00.00" required
            value="<?= $form['montoMulta'] ?? '' ?>"
            class="w-full pl-8 mt-1 p-2 border rounded-md focus:outline-[#4F0087]">
    </div>
</div>


        <!-- Fecha Registro -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Fecha de Registro</label>
            <input type="date" name="fechaRegistro" required
                value="<?= date('Y-m-d') ?>" readonly
         class="w-full mt-1 p-2 border rounded-md bg-gray-200 text-gray-600">
        </div>


        <!-- Préstamo -->
        <div  class="block gap-4">
            <label class="block text-sm font-medium text-gray-700">Préstamo Relacionado</label>
            <input type="text" name="codigoPrestamo" readonly
                placeholder="Código del Prestamo: CP-000000"
                value="<?= $codigoPrestamo ?>"
                class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087]">
        </div>

        <!-- Botones -->
        <div class="md:col-span-2 flex flex-col gap-3 md:flex-row md:justify-end mt-4">

            <a href="lista_multas.php"
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
