<?php
require_once('../includes/auth.php');

// Solo Admin y Bibliotecario
requireRole(['A', 'B']);
?>

<?php
    $pkLibro=$_GET['pkLibro'];

    include('../clases/libro.php');
    $clase= new Libro();

    $resultado = $clase->desactivar($pkLibro);
    if($resultado){
        header('Location: ../vistas/lista_libros.php?success=Libro desactivado Exito');
        exit;
    }else{
        header('Location: ../vistas/lista_libros.php?error=Error al desactivar Libro');
        exit;
    }

?>