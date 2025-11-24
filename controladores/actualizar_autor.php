<?php
$pkAutor = $_POST['pkAutor'];
$nombreAutor = $_POST['nombreAutor'];
 // <- Nombre consistente

$fkNacionalidad = $_POST['fkNacionalidad'];


include('../clases/autor.php');
$autor = new Autor();


// Ejecutar actualización
$resultado = $autor->actualizar(
    $pkAutor,
    $nombreAutor,
    $fkNacionalidad
);

if ($resultado) {
    header("Location: ../vistas/detalle_autor.php?pkAutor=$pkAutor&success=Autor actualizado correctamente");
} else {
    header("Location: ../vistas/editar_autor.php?pkAutor=$pkAutor&error=Error al actualizar");
}

exit;
?>