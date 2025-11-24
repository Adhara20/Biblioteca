<?php
    $pkAutor=$_GET['pkAutor'];

    include('../clases/autor.php');
    $clase= new Autor();

    $resultado = $clase->desactivar($pkAutor);
    if($resultado){
        header('Location: ../vistas/lista_autor.php?success=Autor desactivado con éxito');
        exit;
    }else{
        header('Location: ../vistas/lista_autor.php?error=Error al desactivar Autor');
        exit;
    }

?>