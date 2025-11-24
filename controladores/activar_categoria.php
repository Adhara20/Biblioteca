<?php
    $pkCategoria=$_GET['pkCategoria'];

    include('../clases/categoria.php');
    $clase= new Categoria();

    $resultado = $clase->activar($pkCategoria);
    if($resultado){
        header('Location: ../vistas/lista_categoria.php?success=Categoria activado Exito');
        exit;
    }else{
        header('Location: ../vistas/lista_categoria.php?error=Error al activar Categoria');
        exit;
    }

?>