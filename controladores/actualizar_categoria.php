<?php
$pkCategoria = $_POST['pkCategoria'];
$nombreCategoria = $_POST['nombreCategoria'];
 // <- Nombre consistente

$iconoCategoriaActual = $_POST['iconoCategoriaActual'];

include('../clases/Categoria.php');
$categoria = new Categoria();

// // Validar ISBN único
// if ($libro->existeISBNActualizar($isbn, $pkLibro)) {
//     header("Location: ../vistas/editar_libro.php?pkLibro=$pkLibro&error=El ISBN ya está registrado en otro libro");
//     exit;
// }

// Validar portada
if (!isset($_FILES['iconoCategoria']) || $_FILES['iconoCategoria']['error'] !== 0) {

    // No subió nueva → mantener la actual
    $iconoCategoria = $iconoCategoriaActual;

} else {

    // Sí subió nueva
    $iconoCategoriaNuevo = $_FILES['iconoCategoria']['name'];
    $tmp = $_FILES['iconoCategoria']['tmp_name'];

    move_uploaded_file($tmp, '../imagenes/categorias/'. $iconoCategoriaNuevo);

    $iconoCategoria = $iconoCategoriaNuevo;
}

// Ejecutar actualización
$resultado = $categoria->actualizar(
    $pkCategoria,
    $nombreCategoria,
    $iconoCategoria
);

if ($resultado) {
    header("Location: ../vistas/detalle_categoria.php?pkCategoria=$pkCategoria&success=Categoria actualizado correctamente");
} else {
    header("Location: ../vistas/editar_categoria.php?pkCategoria=$pkCategoria&error=Error al actualizar");
}

exit;
?>
