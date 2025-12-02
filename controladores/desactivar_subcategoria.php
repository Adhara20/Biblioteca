<?php
require_once('../includes/auth.php');

// Solo Admin y Bibliotecario
requireRole(['A', 'B']);
?>

<?php
    $pkSubCategoria=$_GET['pkSubCategoria'];

    include('../clases/subcategoria.php');
    $clase= new Subcategoria();

    $resultado = $clase->desactivar($pkSubCategoria);
    if($resultado){
        header('Location: ../vistas/lista_subcategoria.php?success=Subategoría desactivada con éxito');
        exit;
    }else{
        header('Location: ../vistas/lista_subcategoria.php?error=Error al desactivar subcategoría');
        exit;
    }

?>