<?php
$dash = new Dashboard();
// Obtener totales reales desde la clase
$librosTotal         = $dash->totalLibros();
$copiasTotal         = $dash->totalCopias();
$prestamosTotal      = $dash->totalPrestamos();
$multasTotal         = $dash->totalMultas();
$categoriasTotal     = $dash->totalCategorias();
$subcategoriasTotal  = $dash->totalSubcategorias();
$usuariosTotal       = $dash->totalUsuarios();
$autoresTotal        = $dash->totalAutores();
$editorialesTotal    = $dash->totalEditoriales();
$nacionalidadesTotal = $dash->totalNacionalidades();
?>
<div class="w-full max-w-6xl grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-10 px-4 mb-10">


    <div class="bg-white shadow-md rounded-xl p-6 border-l-4 border-purple-600">
        <h3 class="text-xl font-semibold text-gray-700">Libros</h3>
        <p class="text-4xl font-bold text-purple-700 mt-2"><?= $librosTotal ?></p>
        <span class="text-gray-500">Registrados en el sistema</span>
    </div>

    <div class="bg-white shadow-md rounded-xl p-6 border-l-4 border-blue-600">
        <h3 class="text-xl font-semibold text-gray-700">Copias Físicas</h3>
        <p class="text-4xl font-bold text-blue-700 mt-2"><?= $copiasTotal ?></p>
        <span class="text-gray-500">Ejemplares totales</span>
    </div>

    <div class="bg-white shadow-md rounded-xl p-6 border-l-4 border-green-600">
        <h3 class="text-xl font-semibold text-gray-700">Préstamos</h3>
        <p class="text-4xl font-bold text-green-700 mt-2"><?= $prestamosTotal ?></p>
        <span class="text-gray-500">En proceso</span>
    </div>

    <div class="bg-white shadow-md rounded-xl p-6 border-l-4 border-red-600">
        <h3 class="text-xl font-semibold text-gray-700">Multas</h3>
        <p class="text-4xl font-bold text-red-700 mt-2"><?= $multasTotal ?></p>
        <span class="text-gray-500">Pendientes</span>
    </div>

    <div class="bg-white shadow-md rounded-xl p-6 border-l-4 border-yellow-500">
        <h3 class="text-xl font-semibold text-gray-700">Categorías</h3>
        <p class="text-4xl font-bold text-yellow-600 mt-2"><?= $categoriasTotal ?></p>
        <span class="text-gray-500">Categorías registradas</span>
    </div>

    <div class="bg-white shadow-md rounded-xl p-6 border-l-4 border-pink-500">
        <h3 class="text-xl font-semibold text-gray-700">Subcategorías</h3>
        <p class="text-4xl font-bold text-pink-600 mt-2"><?= $subcategoriasTotal ?></p>
        <span class="text-gray-500">Subcategorías activas</span>
    </div>

    <div class="bg-white shadow-md rounded-xl p-6 border-l-4 border-indigo-600">
        <h3 class="text-xl font-semibold text-gray-700">Usuarios</h3>
        <p class="text-4xl font-bold text-indigo-700 mt-2"><?= $usuariosTotal ?></p>
        <span class="text-gray-500">Lectores, Admins y Bibliotecarios</span>
    </div>

    <div class="bg-white shadow-md rounded-xl p-6 border-l-4 border-teal-600">
        <h3 class="text-xl font-semibold text-gray-700">Autores</h3>
        <p class="text-4xl font-bold text-teal-700 mt-2"><?= $autoresTotal ?></p>
        <span class="text-gray-500">Autores registrados</span>
    </div>

    <div class="bg-white shadow-md rounded-xl p-6 border-l-4 border-orange-500">
        <h3 class="text-xl font-semibold text-gray-700">Editoriales</h3>
        <p class="text-4xl font-bold text-orange-600 mt-2"><?= $editorialesTotal ?></p>
        <span class="text-gray-500">Editoriales</span>
    </div>

    <div class="bg-white shadow-md rounded-xl p-6 border-l-4 border-gray-700">
        <h3 class="text-xl font-semibold text-gray-700">Nacionalidades</h3>
        <p class="text-4xl font-bold text-gray-800 mt-2"><?= $nacionalidadesTotal ?></p>
        <span class="text-gray-500">Países registrados</span>
    </div>

</div>

