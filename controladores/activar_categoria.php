<?php
    $pkCategoria=$_GET['pkCategoria'];

    include('../clases/categoria.php');
    $clase= new Categoria();

    $resultado = $clase->activar($pkCategoria);
    if($resultado){
        header('Location: ../vistas/lista_categoria.php?success=Categoría activada con éxito');
        exit;
    }else{
        header('Location: ../vistas/lista_categoria.php?error=Error al activar categoría');
        exit;
    }

?>