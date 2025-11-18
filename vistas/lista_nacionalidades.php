<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de nacionalidades</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/copias.css">

    <!-- AlpineJS (necesario para el menú kebab) -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<?php include('../includes/header.php'); ?>

<body>
    <?php
    include('../clases/nacionalidad.php');
    $nac = new Nacionalidad();
    $resultado = $nac->listaNacionalidades();
    include('../includes/menu.php');
    ?>

    <div class="px-10 mb-4">
        <h1 class="titulos">Registro de Copias</h1>
        <hr class="linea-separadora-listas">
    </div>

    <div class="tabla-copias-container">
        <table class="table-copias">
            <tr>
                <th>Nacionalidad</th>
                <th>Estatus</th>
                <th>Acciones</th>
            </tr>

            <?php foreach ($resultado as $fila):
                $estatus = ($fila["estatus"] === 'A') ? 'Activa' : 'Inactiva';
            ?>
                <tr>
                    <td><?= $fila['nombreNaci'] ?></td>

                    <td><?= htmlspecialchars($estatus) ?></td>

                    <!-- Columna Acciones -->
                    <td class="relative">
                        <div class="relative" x-data="{open:false}">
                            <!-- Botón kebab -->
                            <button @click="open = !open"
                                class="p-2 rounded hover:bg-gray-100 text-xl leading-none">
                                <img src="/Biblioteca/imagenes/btn Iconos/btnAcciones.png" class="size-6" alt="Acciones">
                            </button>

                            <!-- Menú desplegable -->
                            <div x-show="open"
                                x-transition
                                @click.outside="open = false"
                                class="absolute right-0 w-40 bg-white shadow-lg rounded-lg border z-50"
                                :class="(window.innerHeight - $el.getBoundingClientRect().bottom < 150)
                                    ? 'bottom-full mb-1'
                                    : 'top-full mt-1'">

                                <button class="flex items-center gap-2 w-full text-left px-4 py-2 hover:bg-gray-100 hover:text-blue-400">
                                    <img src="/Biblioteca/imagenes/btn Iconos/btnEditar.png" class="size-4">
                                    <span class="text-sm/6">Editar</span>
                                </button>

                                <button class="flex items-center gap-2 w-full text-left px-4 py-2 hover:bg-gray-100 hover:text-green-400">
                                    <img src="/Biblioteca/imagenes/btn Iconos/btnAlta.png" class="size-4">
                                    <span class="text-sm/6">Activar</span>
                                </button>

                                <button class="flex items-center gap-2 w-full text-left px-4 py-2 hover:bg-gray-100 hover:text-red-400">
                                    <img src="/Biblioteca/imagenes/btn Iconos/btbBaja.png" class="size-4">
                                    <span class="text-sm/6">Desactivar</span>
                                </button>
                            </div>
                        </div>
                    </td>

                </tr>
            <?php endforeach; ?>
        </table>
    </div>

</body>

</html>
