<?php
require_once('../includes/auth.php');

// Solo Admin y Bibliotecario
requireRole(['A', 'B', 'L']);

include('../clases/usuario.php');
$clase = new Usuario();

// Obtener pkUsuario
$pkUsuario = $_GET['pkUsuario'] ?? null;
$miPerfil = ($pkUsuario == $pkUsuarioLog);

if (!$pkUsuario) {
    header("Location: ../index.php?error=No se especificó usuario");
    exit;
}

// Solo Admin o su propio perfil
if (!$rol && $pkUsuario != $pkUsuarioLog && $estatusLog=='I') {
    header("Location: ../index.php?error=No puedes acceder a este usuario");
    exit;
}

// Obtener detalles del usuario
$resultado = $clase->detalles($pkUsuario);
if (!$resultado || $resultado->num_rows == 0) {
    header("Location: ../index.php?error=Usuario no encontrado");
    exit;
}
$fila = $resultado->fetch_assoc();

// Determinar imagen
$imgRuta = !empty($fila['foto']) ? "../imagenes/usuarios/{$fila['foto']}" : "../imagenes/usuarios/placeholder.png";

include('../includes/header.php');
?>
<body class="bg-gray-100 text-gray-900">
<?php include('../includes/menu.php'); ?>

<!--  Título principal -->
<div class="w-full flex flex-col items-start px-8 mt-8">
    <div class="w-full max-w-4xl mx-auto">
        <h1 class="titulos">Perfil</h1>
        <hr class="linea-separadora mb-6">
        <?php include('../includes/notificacion.php'); ?>
    </div>
</div>

<?php
// Determinar color y texto del rol
if($fila['rol']=='A'){
    $rol1='ADMINISTRADOR';
    $colorR = 'text-purple-400 font-semibold [text-shadow:0_2px_4px_rgba(0,0,0,.3)]';
}else if($fila['rol']=='B'){
    $rol1='BIBLIOTECARIO';
    $colorR = 'text-blue-500 font-semibold [text-shadow:0_2px_4px_rgba(0,0,0,.3)]';
}else{
    $rol1='LECTOR';
    $colorR = 'text-pink-500 font-semibold [text-shadow:0_2px_4px_rgba(0,0,0,.3)]';
}
?>

<!-- Contenedor principal -->
<div class="w-full max-w-5xl bg-white shadow-lg rounded-2xl p-8 border border-gray-300 mb-12 mx-auto flex flex-col md:flex-row-reverse gap-8">

    <!-- Foto de Usuario -->
    <div class="flex-shrink-0 w-full md:w-1/3 flex justify-center items-start">
        <img src="<?= $imgRuta ?>" alt="Foto de <?= htmlspecialchars($fila['foto']) ?>" class="rounded-full shadow-md border border-gray-200 object-cover w-64 h-64 bg-gray-50" />
    </div>

    <!-- Datos del Usuario -->
    <div class="flex-1">
        <div class="mb-6 text-center md:text-left">
            <h2 class="text-2xl font-semibold text-[#4F0087]"><?= $fila['nombreCompleto'] ?></h2>
            <p class="text-gray-600">Información General</p>
        </div>

        <div class="border-t border-gray-300 pt-4">
            <dl class="divide-y divide-gray-200">
                <div class="py-3 grid grid-cols-3 gap-4">
                    <dt class="font-medium text-gray-700">Número de Credencial:</dt>
                    <dd class="col-span-2 <?= $colorR ?> font-medium"><?= $fila['numCredencial'] ?></dd>
                </div>

                <div class="py-3 grid grid-cols-3 gap-4">
                    <dt class="font-medium text-gray-700">CURP:</dt>
                    <dd class="col-span-2 text-gray-800 font-medium"><?= $fila['curp'] ?></dd>
                </div>

                <div class="py-3 grid grid-cols-3 gap-4">
                    <dt class="font-medium text-gray-700">Fecha de Nacimiento:</dt>
                    <dd class="col-span-2 text-gray-800 font-medium"><?= $fila['fechaNac'] ?></dd>
                </div>

                <div class="py-3 grid grid-cols-3 gap-4">
                    <dt class="font-medium text-gray-700">Edad:</dt>
                    <dd class="col-span-2 text-gray-800 font-medium"><?= $clase->obtenerEdad($fila["fechaNac"]) ?> años</dd>
                </div>

                <div class="py-3 grid grid-cols-3 gap-4">
                    <dt class="font-medium text-gray-700">Genero:</dt>
                    <?php $genero = ($fila['sexo']=='F') ? 'Femenino / Mujer' : 'Masculino / Hombre'; ?>
                    <dd class="col-span-2 text-gray-800 font-medium"><?= $genero ?></dd>
                </div>

                <div class="py-3 grid grid-cols-3 gap-4">
                    <dt class="font-medium text-gray-700">Correo:</dt>
                    <dd class="col-span-2 text-gray-800 font-medium"><?= $fila['correo'] ?></dd>
                </div>

                <div class="py-3 grid grid-cols-3 gap-4">
                    <dt class="font-medium text-gray-700">Rol:</dt>
                    <dd class="col-span-2 text-gray-800 <?= $colorR ?>"><?= $rol1?></dd>
                </div>

                <div class="py-3 grid grid-cols-3 gap-4">
                    <dt class="font-medium text-gray-700">Fecha de Registro:</dt>
                    <dd class="col-span-2 text-gray-800 font-medium"><?= $fila['fechaRegistro'] ?></dd>
                </div>

                <?php if(strtoupper(trim($fila['rol']))=='L'): ?>
                    <div class="py-3 grid grid-cols-3 gap-4">
                        <dt class="font-medium text-gray-700">Disponibilidad para préstamo:</dt>
                        <?php
                        if($fila['estatusPrestamista']=='A'){
                            $estatusPrestamista='ACTIVO';
                            $colorEP='text-blue-500 font-semibold [text-shadow:0_2px_4px_rgba(0,0,0,.3)]';
                        }else{
                            $estatusPrestamista='VETADO';
                            $colorEP='text-rose-400 font-semibold [text-shadow:0_2px_4px_rgba(0,0,0,.3)]';
                        }
                        ?>
                        <dd class="col-span-2 <?= $colorEP ?>"><?= $estatusPrestamista ?></dd>
                    </div>
                <?php endif; ?>

                <div class="py-3 grid grid-cols-3 gap-4">
                    <dt class="font-medium text-gray-700">Estatus usuario:</dt>
                    <?php
                    if($fila['estatus']=='A'){
                        $estatus='ACTIVO';
                        $color='text-green-500 font-semibold [text-shadow:0_2px_4px_rgba(0,0,0,.3)]';
                    }else{
                        $estatus='INACTIVO';
                        $color='text-red-400 font-semibold [text-shadow:0_2px_4px_rgba(0,0,0,.3)]';
                    }
                    ?>
                    <dd class="col-span-2 <?= $color ?>"><?= $estatus ?></dd>
                </div>
            </dl>
        </div>

        <!-- Botones de acción -->
        <div class="flex justify-end gap-3 mt-8">
            <?php if($estatusLog=='A'): ?>
                <?php if($rol=='A' || $miPerfil): ?>
                    <a href="editar_usuario.php?pkUsuario=<?= $fila['pkUsuario'] ?>" class="px-4 py-2.5 rounded-md font-medium transition border border-[#5780B5] text-[#5780B5] bg-blue-200 hover:bg-[#5780B5] hover:text-blue-200 shadow-sm">Editar</a>
                <?php endif; ?>
                <?php if($rol=='A' && !$miPerfil): ?>
                    <?php if($fila['estatus']=='A'): ?>
                        <a href="../controladores/desactivar_usuario.php?pkUsuario=<?= $fila['pkUsuario'] ?>" class="px-4 py-2.5 rounded-md text-white font-medium transition bg-[#B55780] hover:bg-[#e5b6ca] hover:text-[#B55780] border hover:border-[#B55780] shadow-sm">Desactivar</a>
                    <?php else: ?>
                        <a href="../controladores/activar_usuario.php?pkUsuario=<?= $fila['pkUsuario'] ?>" class="px-4 py-2.5 rounded-md text-white font-medium transition bg-[#34B980] hover:bg-[#c0eed9] hover:text-[#34B980] border hover:border-[#34B980] shadow-sm">Activar</a>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>
        </div>

    </div>
</div>

<?php include('../includes/footer.php'); ?>
</body>
</html>
