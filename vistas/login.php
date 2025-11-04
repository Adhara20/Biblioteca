<!DOCTYPE html>
<html lang="es" class="h-full bg-gray-100">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar Sesión | Owl Book</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="h-full flex flex-col justify-center items-center">
  <?php if (isset($_GET['error'])): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 w-80 text-center">
      <?= htmlspecialchars($_GET['error']) ?>
    </div>
  <?php endif; ?>

  <div class="w-full max-w-sm bg-white p-6 rounded-2xl shadow-lg">
    <div class="flex flex-col items-center mb-6">
      <img src="#"
           alt="Logo Owl Book" class="h-12 w-auto mb-3">
      <h2 class="text-2xl font-semibold text-gray-800">Iniciar Sesión</h2>
    </div>

    <form action="../controladores/iniciar_sesion.php" method="POST" class="space-y-5">
      <div>
        <label for="numCredencial" class="block text-sm font-medium text-gray-700 mb-1">Número de Credencial OW</label>
        <input type="text" name="numCredencial" id="numCredencial" required
          class="block w-full rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#4F0087] focus:border-transparent">
      </div>

      <div>
        <label for="pass" class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
        <input type="password" name="pass" id="pass" required
          class="block w-full rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#4F0087] focus:border-transparent">
      </div>

      <button type="submit"
        class="w-full bg-[#4F0087] text-white py-2 rounded-md hover:bg-[#6B21A8] transition font-medium">
        Ingresar
      </button>
    </form>

    <p class="mt-6 text-center text-sm text-gray-600">
      ¿Olvidaste tu contraseña?
      <a href="#" class="text-[#4F0087] font-semibold hover:underline">Recupérala aquí</a>
    </p>
  </div>
</body>
</html>
