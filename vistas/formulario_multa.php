<?php include('../includes/header.php'); ?>
<body class="bg-gray-100 text-gray-900">

<?php include('../includes/menu.php'); ?>
<?php include('../includes/notificacion.php'); ?>

<?php 

$form = $_SESSION['form_multa'] ?? [];
?>

<div class="w-full max-w-3xl bg-white shadow-lg rounded-2xl p-8 lg:p-10 border border-gray-300 mx-auto mb-10">

    <h2 class="text-2xl font-semibold text-center text-[#4F0087] mb-6">
        Registrar Multa
    </h2>

    <form action="../controladores/insertar_multa.php" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <!-- Tipo de multa -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Tipo de Multa</label>
            <select name="tipoMulta" required
                class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087] bg-white">
                <option value="">Seleccione un tipo</option>
                <option value="Retraso" <?= ($form['tipoMulta'] ?? '') === 'Retraso' ? 'selected':'' ?>>Retraso</option>
                <option value="Daño"    <?= ($form['tipoMulta'] ?? '') === 'Daño' ? 'selected':'' ?>>Daño</option>
                <option value="Perdido" <?= ($form['tipoMulta'] ?? '') === 'Perdido' ? 'selected':'' ?>>Perdido</option>
            </select>
        </div>

        <!-- Monto -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Monto</label>
            <input type="number" step="0.01" name="montoMulta" required
                value="<?= $form['montoMulta'] ?? '' ?>"
                class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087]">
        </div>

        <!-- Fecha Registro -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Fecha de Registro</label>
            <input type="date" name="fechaRegistro" required
                value="<?= $form['fechaRegistro'] ?? '' ?>"
                class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087]">
        </div>

        <!-- Fecha Pago -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Fecha de Pago</label>
            <input type="date" name="fechaPago"
                value="<?= $form['fechaPago'] ?? '' ?>"
                class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087]">
        </div>

        <!-- Préstamo -->
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700">Préstamo Relacionado</label>
            <input type="text" name="fkPrestamo" required
                placeholder="Escribe el número del préstamo existente"
                value="<?= $form['fkPrestamo'] ?? '' ?>"
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
