<?php
    $pkAutor=$_GET['pkAutor'];

    include('../clases/autor.php');
    $clase= new Autor();

    $resultado = $clase->activar($pkAutor);
    if($resultado){
        header('Location: ../vistas/lista_autor.php?success=Autor activado al Exito');
        exit;
    }else{
        header('Location: ../vistas/lista_autor.php?error=Error al activar Autor');
        exit;
    }

?>