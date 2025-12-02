<?php
require_once('../includes/auth.php');

// Solo Admin y Bibliotecario
requireRole(['A', 'B']);
?>

<?php
    $pkAutor=$_GET['pkAutor'];

    include('../clases/autor.php');
    $clase= new Autor();

    $resultado = $clase->activar($pkAutor);
    if($resultado){
        header('Location: ../vistas/lista_autor.php?success=Autor activado con éxito');
        exit;
    }else{
        header('Location: ../vistas/lista_autor.php?error=Error al activar autor');
        exit;
    }

?>