<?php
    $pkLibro=$_GET['pkLibro'];

    include('../clases/libro.php');
    $clase= new Libro();

    $resultado = $clase->activar($pkLibro);
    if($resultado){
        header('Location: ../vistas/lista_libros.php?success=Libro desactivado Exito');
        exit;
    }else{
        header('Location: ../vistas/lista_libros.php?error=Error al activar Libro');
        exit;
    }

?>