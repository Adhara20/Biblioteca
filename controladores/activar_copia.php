<?php
require_once('../includes/auth.php');

// Solo Admin y Bibliotecario
requireRole(['A', 'B']);
?>

<?php
    $pkCopiaF=$_GET['pkCopiaF'];

    include('../clases/copia.php');
    $clase= new Copia();

    $resultado = $clase->activar($pkCopiaF);
    if($resultado){
        header('Location: ../vistas/lista_copias.php?success=Copia activada con Exito');
        exit;
    }else{
        header('Location: ../vistas/lista_copias.php?error=Error al activar Copia');
        exit;
    }

?>