<?php
require_once('../includes/auth.php');

// Solo Admin y Bibliotecario
requireRole(['A', 'B']);
?>

<?php
$pkSubCategoria = $_POST['pkSubCategoria'];
$nombreSubCategoria = mb_strtoupper($_POST['nombreSubCategoria'], 'UTF-8');
 // <- Nombre consistente

$iconoSubCategoriaActual = $_POST['iconoSubCategoriaActual'];
$abreviatura = mb_strtoupper($_POST['abreviatura'], 'UTF-8');
$fkCategoria = $_POST['fkCategoria'];


include('../clases/subcategoria.php');
$subcategoria = new Subcategoria();

// // Validar ISBN único
// if ($libro->existeISBNActualizar($isbn, $pkLibro)) {
//     header("Location: ../vistas/editar_libro.php?pkLibro=$pkLibro&error=El ISBN ya está registrado en otro libro");
//     exit;
// }

// Validar portada
if (!isset($_FILES['iconoSubCategoria']) || $_FILES['iconoSubCategoria']['error'] !== 0) {

    // No subió nueva → mantener la actual
    $iconoSubCategoria = $iconoSubCategoriaActual;

} else {

    // Sí subió nueva
    $iconoSubCategoriaNuevo = $_FILES['iconoSubCategoria']['name'];
    $tmp = $_FILES['iconoSubCategoria']['tmp_name'];

    move_uploaded_file($tmp, '../imagenes/subcategorias/'. $iconoSubCategoriaNuevo);

    $iconoSubCategoria = $iconoSubCategoriaNuevo;
}

// Ejecutar actualización
$resultado = $subcategoria->actualizar(
    $pkSubCategoria,
    $nombreSubCategoria,
    $iconoSubCategoria,
    $abreviatura,
    $fkCategoria
);

if ($resultado) {
    header("Location: ../vistas/detalle_subcategoria.php?pkSubCategoria=$pkSubCategoria&success=Subcategoría actualizada correctamente");
} else {
    header("Location: ../vistas/editar_subcategoria.php?pkSubCategoria=$pkSubCategoria&error=Error al actualizar subcategoría");
}

exit;
?>