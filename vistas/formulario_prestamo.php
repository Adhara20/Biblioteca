
<?php
require_once('../includes/auth.php');

// Solo Admin y Bibliotecario
requireRole(['A', 'B']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owl Book - Formulario Prestamo</title>
</head>
<?php include('../includes/header.php'); ?>
<body class="bg-gray-100 text-gray-900">

<?php include('../includes/menu.php'); ?>

<?php
include('../clases/copia.php');
include('../clases/usuario.php');

$copia = new Copia();
$usuario = new Usuario();

$listaCopias = $copia->mostrar();
$listaUsuario = $usuario->mostrar();

// Recibir el folio de la copia para prestarlo
// $folioInterno = $_GET['pkCopiaF'] ?? null;
$fkCopiaF = $_GET['pkCopiaF'] ?? null;
$folioCopia = $_GET['folio'] ?? null;
?>

<div class="w-full max-w-5xl bg-white shadow-lg rounded-2xl p-8 lg:p-12 border border-gray-300 mx-auto mb-10">
    <h2 class="text-2xl font-semibold text-center text-[#4F0087] mb-6">
    Formulario Prestamo
    </h2>
    <?php include('../includes/notificacion.php'); ?>
    <form action="../controladores/insertar_prestamo.php" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-4">
    
    <!--  Fecha Límite -->
      <?php
        $diaMin = date('Y-m-d', strtotime('+1 days'));
        $diaMax = date('Y-m-d', strtotime('+7 days'));
      ?>
     <div>
      <label class="block text-sm font-medium text-gray-700">Fecha Limite <span class="text-red-500 text-2xl">*</span></label>
      <input type="date" name="fechaLimite" required min="<?= $diaMin ?>" min="<?= $diaMax ?>" 
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087]">
    </div>
    
    <!-- Folio Contracto -->
     <div>
      <label class="block text-sm font-medium text-gray-700">Folio Contrato <span class="text-red-500 text-2xl">*</span></label>
      <input type="text" name="folioContrato" required
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087]">
    </div>
    <!-- Contracto -->
     <div>
      <label class="block text-sm font-medium text-gray-700">Contracto <span class="text-red-500 text-2xl">*</span></label>
      <input type="file" name="archivoContrato" required
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087]">
    </div>
    <!-- Folio Copia -->
    <div>
      <label class="block text-sm font-medium text-gray-700">Folio Copia <span class="text-red-500 text-2xl">*</span></label>
      <?php if($fkCopiaF): ?>
        <input type="text" name="folioVisible" value="<?= $folioCopia  ?>" required readonly
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087]">
        <input type="hidden" name="folio" value="<?= $fkCopiaF ?>">
        <?php else: ?>
      <select name="folio" required
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087] bg-white">

        <option value="">Seleccione una Copia</option>

        <?php foreach ($listaCopias as $fila): ?>
            <option value="<?= $fila['pkCopiaF'] ?>">
              <?= $fila['folio'] ?>
            </option>
        <?php endforeach; ?>
      </select>
      <?php endif; ?>
    </div>

          <!-- Usuario solicitante -->
        <div>
      <label><span class="block text-sm font-medium text-gray-700">Usuario Solicitante</span> <span class="text-xs font-medium text-gray-500">(Solo usuarios no vetados)</span> <span class="text-red-500 text-2xl">*</span></label>
      
      <select name="numCredS" required
        class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087] bg-white">

        <option value="">Seleccione un Usuario</option>

        <?php foreach ($listaUsuario as $fila): ?>
            <option value="<?= $fila['numCredencial'] ?>">
              <?= $fila['numCredencial'] ?>
            </option>
        <?php endforeach; ?>

      </select>
    </div>
        
    <!-- Este es automatico-->
     <div>
      <label class="block text-sm font-medium text-gray-700">Usuario Autorizante</label>
      <input type="text" name="numCredA"
        value="<?php echo isset($_SESSION['numCredencial']) ? htmlspecialchars($_SESSION['numCredencial']) : ''; ?>"
           class="w-full mt-1 p-2 border rounded-md bg-gray-200 text-gray-600"
           readonly>
    </div>
        
        <!-- BOTONES -->
    <div class="md:col-span-2 flex flex-col gap-3 md:flex-row md:justify-end mt-4">
      <button class="w-full md:w-32 bg-[#B55780] text-white py-2 rounded-md font-semibold hover:bg-[#c46b93] transition">
        Cancelar
      </button>
      <button type="submit"
        class="w-full md:w-32 bg-[#4F0087] text-white py-2 rounded-md font-semibold hover:bg-[#6A00B8] transition">
        Guardar
      </button>
    </div>

    </form>
</div>
<?php include('../includes/footer.php'); ?>
</body>
</html>
