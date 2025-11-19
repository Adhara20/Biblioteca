<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registrar Usuario</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<?php include('../includes/header.php'); ?>
<body>
<?php include('../includes/menu.php'); ?>


  <div class="bg-white shadow-lg rounded-2xl overflow-hidden flex flex-col lg:flex-row w-full max-w-5xl">
    
    <!-- LADO IZQUIERDO (solo visible en pantallas grandes) -->
    <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-[#4F0087] to-[#7A1BC1] text-white flex-col justify-center items-center p-10">
      <img src="../imagenes/logos/lechuzaSombraLuna.jpg" alt="Owl Book" class="h-24 w-auto mb-4 rounded-full shadow-lg">
      <h1 class="text-3xl font-semibold mb-2">Owl Book</h1>
      <p class="text-center text-white/90 max-w-xs">
        “El conocimiento es la luz en la noche más oscura.”
      </p>
    </div>

    <!-- LADO DERECHO (formulario) -->
    <div class="flex-1 p-8 lg:p-12">
      <h2 class="text-2xl font-semibold text-center text-[#4F0087] mb-6">Registrar Usuario</h2>

      <!-- Mensaje de error -->
      <?php include('../includes/notificacion.php'); ?>

      <form action="../controladores/insertar_usuario.php" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <div>
          <label class="block text-sm font-medium text-gray-700">Nombre(s)</label>
          <input type="text" name="nombres" placeholder="Nombre(s)" required
            class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087] uppercase" value="<?= $_SESSION['form_usuario']['nombres'] ?? '' ?>">
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Apellido Paterno</label>
          <input type="text" name="apaterno" placeholder="Apellido Paterno" required
            class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087] uppercase" value="<?= $_SESSION['form_usuario']['apaterno'] ?? '' ?>">
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Apellido Materno</label>
          <input type="text" name="amaterno" placeholder="Apellido Materno"
            class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087] uppercase" value="<?= $_SESSION['form_usuario']['amaterno'] ?? '' ?>">
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">CURP</label>
          <input type="text" name="curp" placeholder="CURP" required
            class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087] uppercase" value="<?= $_SESSION['form_usuario']['curp'] ?? '' ?>">  <!-- uppercase (es una clase de Talwing para que lo que escribas se VEA MAYÚSCULAS. Ojo, es solo para que al escribir se vea en MAYÚSCULAS, para que se guarde como Mayuscula se hace en insertar) -->
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Fecha de Nacimiento</label>
          <input type="date" name="fechaNac" required
            class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087]" value="<?= $_SESSION['form_usuario']['fechaNac'] ?? '' ?>">
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Sexo</label>
          <select name="sexo" required
            class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087] bg-white">
            <option value="M" <?= (isset($_SESSION['form_usuario']['sexo']) && $_SESSION['form_usuario']['sexo'] === 'M') ? 'selected' : '' ?>>Masculino</option>
            <option value="F" <?= (isset($_SESSION['form_usuario']['sexo']) && $_SESSION['form_usuario']['sexo'] === 'F') ? 'selected' : '' ?>>Femenino</option>
          </select>
        </div>

        <div class="md:col-span-2">
          <label class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
          <input type="email" name="correo" placeholder="correo@ejemplo.com" required
            class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087]" value="<?= $_SESSION['form_usuario']['correo'] ?? '' ?>">
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Contraseña</label>
          <input type="password" name="pass" placeholder="De 8 a 20 caracteres" minlength="8" maxlength="20" required
            class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087]">
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Rol</label>
          <select name="rol" required
            class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087] bg-white">
            <option value="L" <?= (isset($_SESSION['form_usuario']['rol']) && $_SESSION['form_usuario']['rol'] === 'L') ? 'selected' : '' ?>>Lector</option>
            <option value="B" <?= (isset($_SESSION['form_usuario']['rol']) && $_SESSION['form_usuario']['rol'] === 'B') ? 'selected' : '' ?>>Bibliotecario</option>
            <option value="A" <?= (isset($_SESSION['form_usuario']['rol']) && $_SESSION['form_usuario']['rol'] === 'A') ? 'selected' : '' ?>>Administrador</option>
          </select>
        </div>

        <div class="md:col-span-2">
          <label class="block text-sm font-medium text-gray-700">Foto de Usuario</label>
          <input type="file" name="foto"
            class="w-full mt-1 p-2 border rounded-md bg-white focus:outline-[#4F0087]">
        </div>

        <div class="md:col-span-2">
          <button type="submit"
            class="w-full bg-[#4F0087] text-white py-2 rounded-md font-semibold hover:bg-[#6A00B8] transition">
            Guardar
          </button>
        </div>
      </form>
    </div>
  </div>
<?php include('../includes/footer.php'); ?>
</body>
</html>
