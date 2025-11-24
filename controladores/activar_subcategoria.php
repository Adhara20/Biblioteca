<?php
    $pkSubCategoria=$_GET['pkSubCategoria'];

    include('../clases/subcategoria.php');
    $clase= new Subcategoria();

    $resultado = $clase->activar($pkSubCategoria);
    if($resultado){
        header('Location: ../vistas/lista_subcategoria.php?success=Categoria activado Exito');
        exit;
    }else{
        header('Location: ../vistas/lista_subcategoria.php?error=Error al activar Categoria');
        exit;
    }

?>