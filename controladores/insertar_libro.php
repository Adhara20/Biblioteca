<?php
session_start(); // Iniciar sesión

// Recibir datos del formulario
$isbn            = $_POST['isbn'];
$titulo          = strtoupper($_POST['titulo']);
$edicion         = strtoupper($_POST['edicion']);
$numPaginas      = $_POST['numPaginas'];
$anioPublicacion  = $_POST['anioPublicacion'];
$fkIdioma         = $_POST['fkIdioma'];
$sinopsis        = $_POST['sinopsis'];
$fkAutor         = $_POST['fkAutor'];
$fkEditorial     = $_POST['fkEditorial'];
$fkSubCategoria  = $_POST['fkSubCategoria'];

// Guardar los datos en sesión (por si ocurre un error)
$_SESSION['form_libro'] = [
    'isbn'  => $_POST['isbn'],
    'titulo' => $_POST['titulo'],
    'edicion' => $_POST['edicion'],
    'numPaginas' => $_POST['numPaginas'],
    'anioPublicacion' => $_POST['anioPublicacion'],
    'fkIdioma' => $_POST['fkIdioma'],
    'sinopsis' => $_POST['sinopsis'],
    'fkAutor' => $_POST['fkAutor'],
    'fkEditorial' => $_POST['fkEditorial'],
    'fkSubCategoria' => $_POST['fkSubCategoria'], 
];


// --- Validar la portada obligatoria ---
if (!isset($_FILES['portada']) || $_FILES['portada']['error'] !== 0) {
    header("Location: ../vistas/formulario_libro.php?error=Debes subir la portada del libro");
    exit;
}

// Preparar la portada (sin moverla todavía)
$portadaNombre = $_FILES['portada']['name'];
$portadaTmp    = $_FILES['portada']['tmp_name'];
$ruta   = '../imagenes/portadas/' . $portadaNombre;

// Incluir clase de Libros
include('../clases/libro.php');

// Crear instancia de la clase correcta
$clase = new Libro();

// Validar si ya existe un libro con ese ISBN (si tu clase tiene esa función)
// Este if ignorenlo tanto en actualizar e intertar
if ($clase->existeISBN($isbn)) {
    header("Location: ../vistas/formulario_libro.php?error=Ya existe un libro con ese ISBN");
    exit;
}

// Subir archivo (ahora sí)
move_uploaded_file($portadaTmp, $ruta);

// Guardar libro en la BD
$resultado = $clase->guardar(
    $isbn,
    $titulo,
    $edicion,
    $numPaginas,
    $anioPublicacion,
    $fkIdioma,
    $sinopsis,
    $fkAutor,
    $fkEditorial,
    $fkSubCategoria,
    $portadaNombre
);


if ($resultado) {
    // Limpiar datos de sesión
    unset($_SESSION['form_libro']);

    header("Location: ../vistas/lista_libros.php?success=Libro registrado correctamente");
    exit;
} else {
    header("Location: ../vistas/formulario_libro.php?error=Error al registrar el libro");
    exit;
}
?>
