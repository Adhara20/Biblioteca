<?php
    $pkCategoria=$_GET['pkCategoria'];

    include('../clases/categoria.php');
    $clase= new Categoria();

    $resultado = $clase->desactivar($pkCategoria);
    if($resultado){
        header('Location: ../vistas/lista_categoria.php?success=Categoría desactivada con éxito');
        exit;
    }else{
        header('Location: ../vistas/lista_categoria.php?error=Error al desactivar categoria');
        exit;
    }

?>