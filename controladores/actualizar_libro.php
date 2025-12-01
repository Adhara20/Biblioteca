<?php
$pkLibro = $_POST['pkLibro'];
$isbn = $_POST['isbn'];
$titulo = strtoupper($_POST['titulo']);
$edicion = strtoupper($_POST['edicion']);
$numPaginas = $_POST['numPaginas'];
$anioPublicacion = $_POST['anioPublicacion'];
$fkIdioma = $_POST['fkIdioma'];
$sinopsis = $_POST['sinopsis'];
$fkAutor = $_POST['fkAutor'];
$fkEditorial = $_POST['fkEditorial'];
$fkSubCategoria = $_POST['fkSubCategoria']; // <- Nombre consistente

$portadaActual = $_POST['portadaActual'];

include('../clases/libro.php');
$libro = new Libro();

// Validar ISBN único
if ($libro->existeISBNActualizar($isbn, $pkLibro)) {
    header("Location: ../vistas/editar_libro.php?pkLibro=$pkLibro&error=El ISBN ya está registrado en otro libro");
    exit;
}

// Validar portada
if (!isset($_FILES['portada']) || $_FILES['portada']['error'] !== 0) {

    // No subió nueva → mantener la actual
    $portada = $portadaActual;

} else {

    // Sí subió nueva
    $portadaNueva = $_FILES['portada']['name'];
    $tmp = $_FILES['portada']['tmp_name'];

    move_uploaded_file($tmp, '../imagenes/portadas/' . $portadaNueva);

    $portada = $portadaNueva;
}

// Ejecutar actualización
$resultado = $libro->actualizar(
    $pkLibro,
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
    $portada
);

if ($resultado) {
    header("Location: ../vistas/detalle_libro.php?pkLibro=$pkLibro&success=Libro actualizado correctamente");
} else {
    header("Location: ../vistas/editar_libro.php?pkLibro=$pkLibro&error=Error al actualizar");
}

exit;
?>
