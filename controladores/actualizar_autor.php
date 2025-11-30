<?php
$pkAutor = $_POST['pkAutor'];
$nombreAutor = strtoupper($_POST['nombreAutor']);
 // <- Nombre consistente
$iconoAutorActual = $_POST['iconoAutorActual'];
$fkNacionalidad = $_POST['fkNacionalidad'];


include('../clases/autor.php');
$autor = new Autor();

if (!isset($_FILES['iconoAutor']) || $_FILES['iconoAutor']['error'] !== 0) {

    $iconoAutor = $iconoAutorActual;

} else {

    $iconoAutorNuevo = $_FILES['iconoAutor']['name'];
    $tmp = $_FILES['iconoAutor']['tmp_name'];

    move_uploaded_file($tmp, '../imagenes/autores/'. $iconoAutorNuevo);

    $iconoAutor = $iconoAutorNuevo;
}

// Ejecutar actualización
$resultado = $autor->actualizar(
    $pkAutor,
    $nombreAutor,
    $iconoAutor,
    $fkNacionalidad
);

if ($resultado) {
    header("Location: ../vistas/detalle_autor.php?pkAutor=$pkAutor&success=Autor actualizado correctamente");
} else {
    header("Location: ../vistas/editar_autor.php?pkAutor=$pkAutor&error=Error al actualizar");
}

exit;
?>