<?php
require_once('../includes/auth.php');

// Solo Admin y Bibliotecario
requireRole(['A', 'B']);
?>

<?php
    $pkCopiaF=$_GET['pkCopiaF'];

    include('../clases/copia.php');
    $clase= new Copia();

    $resultado = $clase->desactivar($pkCopiaF);
    if($resultado){
        header('Location: ../vistas/lista_copias.php?success=Copia desactivada con exito');
        exit;
    }else{
        header('Location: ../vistas/lista_copias.php?error=Error al desactivar la Copia');
        exit;
    }

?>