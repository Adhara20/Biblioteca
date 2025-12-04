<?php
require_once('../includes/auth.php');

// Solo Admin y Bibliotecario
requireRole(['A', 'B', 'L']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Usuario</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<?php include('../includes/header.php'); ?>
<body>
<?php include('../includes/menu.php'); ?>

<?php
include('../clases/usuario.php');
$clase = new Usuario();

$pkUsuario = $_GET['pkUsuario'] ?? null;

if (!$pkUsuario) {
    echo "<p>No se especificó Usuario.</p>";
    exit;
}

// Usas tu función "detalles" como pediste
$resultado = $clase->detalles($pkUsuario);

if ($resultado && $resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
} else {
    echo "<p>No se encontró Usuario.</p>";
    exit;
}

// Determinar imagen actual
$imgRuta = !empty($fila['foto']) 
    ? "../imagenes/usuarios/" . $fila['foto']
    : "../imagenes/usuarios/placeholder.png";
?>

  <div class="min-h-screen flex justify-center items-center px-4 mb-6">

    <div class="bg-white shadow-lg rounded-2xl overflow-hidden flex flex-col lg:flex-row w-full max-w-5xl">
    

    <!-- LADO DERECHO (formulario) -->
    <div class="flex-1 p-8 lg:p-12">
      <?php if($pkUsuarioLog == $pkUsuario){ ?>
        <h2 class="text-2xl font-semibold text-center text-[#4F0087] mb-6">Editar Mi Perfil</h2>
      <?php }else{ ?>
        <h2 class="text-2xl font-semibold text-center text-[#4F0087] mb-6">Editar Usuario</h2>
      <?php } ?>
      <!-- Mensaje de error -->
      <?php include('../includes/notificacion.php'); ?>

      <form action="../controladores/actualizar_usuario.php" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-4">

      <!-- PK -->
    <input type="hidden" name="pkUsuario" value="<?= $fila['pkUsuario'] ?>">

    <!-- PORTADA ACTUAL (para el controlador) -->
    <input type="hidden" name="fotoActual" value="<?= $fila['foto'] ?>">

        <div>
          <label class="block text-sm font-medium text-gray-700">Nombre(s)</label>
          <input type="text" name="nombres" placeholder="Nombre(s)" 
            class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087] uppercase" value="<?= $fila['nombres'] ?>">
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Apellido Paterno</label>
          <input type="text" name="apaterno" placeholder="Apellido Paterno" 
            class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087] uppercase" value="<?= $fila['apaterno'] ?>">
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Apellido Materno</label>
          <input type="text" name="amaterno" placeholder="Apellido Materno"
            class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087] uppercase" value="<?= $fila['amaterno'] ?>">
        </div>
      <?php if($rol === 'A' && $pkUsuarioLog != $pkUsuario): ?>
        <div>
          <label class="block text-sm font-medium text-gray-700">CURP</label>
          <input type="text" name="curp" placeholder="CURP" 
            class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087] uppercase" value="<?= $fila['curp'] ?>">  <!-- uppercase (es una clase de Talwing para que lo que escribas se VEA MAYÚSCULAS. Ojo, es solo para que al escribir se vea en MAYÚSCULAS, para que se guarde como Mayuscula se hace en insertar) -->
        </div>
      <?php else: ?>
        <input type="hidden" name="curp" value="<?= $fila['curp'] ?>">
      <?php endif; ?>

        <div>
          <label class="block text-sm font-medium text-gray-700">Fecha de Nacimiento</label>
          <input type="date" name="fechaNac" 
            class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087]" value="<?= $fila['fechaNac'] ?>">
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Sexo</label>
          <select name="sexo" 
            class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087] bg-white">
            <option value="M" <?= $fila['sexo'] === 'M' ? 'selected' : '' ?>>Masculino</option>
            <option value="F" <?= $fila['sexo'] === 'F' ? 'selected' : '' ?>>Femenino</option>
          </select>
        </div>

        <div class="md:col-span-2">
          <label class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
          <input type="email" name="correo" placeholder="correo@ejemplo.com"
            class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087]" value="<?= $fila['correo'] ?>">
        </div>

<!-- Actualizar Contraseña -->
<div class="md:col-span-2 mt-4">

    <hr class="linea-separadora2 mb-4">

    <label class="block text-md font-semibold text-purple-900 mb-2 md:col-span-2">
        Actualizar Contraseña
    </label>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:col-span-2">

        <!-- Mostrar Contraseña Actual SOLO si el usuario edita su propio perfil -->
        <?php if ($pkUsuarioLog == $pkUsuario): ?>
        <div>
            <label class="block text-sm font-medium text-gray-700">
                Contraseña Actual
            </label>
            <input 
                type="password" 
                name="pass_actual" 
                placeholder="Ingrese su contraseña actual" 
                minlength="8" 
                maxlength="20"
                class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087]"
            >
        </div>
        <?php endif; ?>
        <!-- Contraseña Actual Oculta para enviarla en caso de que no la actualice el suaurio -->
        <?php if ($rol == 'A' && $pkUsuarioLog != $pkUsuario): ?>
          <input type="hidden" name="pass_actual_bd" value="<?= $fila['pass'] ?>">
        <?php endif; ?>


        <!-- Nueva Contraseña (siempre aparece, propio perfil o admin editando a otro) -->
        <div>
            <label class="block text-sm font-medium text-gray-700">
                Nueva Contraseña
            </label>
            <input 
                type="password" 
                name="pass_nueva" 
                placeholder="De 8 a 20 caracteres" 
                minlength="8" 
                maxlength="20"
                class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087]"
            >
        </div>

    </div>


    <!-- Confirmar contraseña (siempre visible) -->
    <div class="md:col-span-2 mt-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Confirmar Nueva Contraseña
        </label>
        <input 
            type="password" 
            name="pass_confirmar" 
            placeholder="Repita la nueva contraseña" 
            minlength="8" 
            maxlength="20"
            class="w-1/2 mt-1 p-2 border rounded-md focus:outline-[#4F0087] block"
        >
    </div>

    <hr class="linea-separadora2 mt-4">

</div>
<!-- FIN PASS -->

          <!-- Si quien lo edita es Admin y no es su propio perfil, ademas del perfil en edicion no es Lector -->
      <?php if($rol === 'A' && $pkUsuario != $pkUsuarioLog && $estatusLog=='A' && $fila['rol']!='L'): ?>
        <div>
            <label class="block text-sm font-medium text-gray-700">Rol</label>
            <select name="rol" 
                class="w-full mt-1 p-2 border rounded-md focus:outline-[#4F0087] bg-white">
                <option value="B" <?= $fila['rol'] === 'B' ? 'selected' : '' ?>>Bibliotecario</option>
                <option value="A" <?= $fila['rol'] === 'A' ? 'selected' : '' ?>>Administrador</option>
            </select>
        </div>
        <!-- Si es usuario lector, independiente de quien lo edite -->
    <?php else: ?>
      <input type="hidden" name="rol" value="<?= $fila['rol'] ?>">
    <?php endif; ?>

        <!-- Imagen -->
        <div class="flex justify-center items-center mt-4 flex-col">

            <!-- Contenedor de la imagen -->
            <div class="w-32 h-32 rounded-full overflow-hidden border-4 shadow-lg">
                <img src="<?= $imgRuta ?>" alt="Foto de perfil" class="w-full h-full object-cover">
            </div>

            <!-- Input para subir nueva foto -->
            <label class="block text-sm font-medium text-gray-700 mt-4">
                 Actualizar foto (opcional)
            </label>

            <input 
                type="file" 
                name="foto" 
                class="w-full max-w-xs mt-1 p-2 border rounded-md bg-white"
            >
        </div>
 <!--FIN IMAGEN  -->

        <!-- BOTONES -->
        <div class="md:col-span-2 flex flex-col gap-3 md:flex-row md:justify-end mt-4">
          <a href="detalle_usuario.php?pkUsuario=<?= $fila['pkUsuario'] ?>"
            class="w-full md:w-32 bg-[#B55780] text-white py-2 rounded-md font-semibold hover:bg-[#c46b93] transition text-center">
            Cancelar
          </a>

          <button type="submit"
            class="w-full md:w-32 bg-[#4F0087] text-white py-2 rounded-md font-semibold hover:bg-[#6A00B8] transition">
            Guardar
          </button>
        </div>
        <!-- FIN BOTONES -->


      </form>
    </div>
  </div>
  
<?php include('../includes/footer.php'); ?>
</body>
</html>
