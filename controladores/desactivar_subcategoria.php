<?php
    $pkSubCategoria=$_GET['pkSubCategoria'];

    include('../clases/subcategoria.php');
    $clase= new Subcategoria();

    $resultado = $clase->desactivar($pkSubCategoria);
    if($resultado){
        header('Location: ../vistas/lista_subcategoria.php?success=Categoría desactivada con éxito');
        exit;
    }else{
        header('Location: ../vistas/lista_subcategoria.php?error=Error al desactivar categoria');
        exit;
    }

?>