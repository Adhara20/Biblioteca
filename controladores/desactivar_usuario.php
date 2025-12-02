<?php
require_once('../includes/auth.php');

// Solo Admin y Bibliotecario
requireRole(['A']);
?>

<?php
    $pkUsuario=$_GET['pkUsuario'];

    include('../clases/usuario.php');
    $clase= new Usuario();

    $resultado = $clase->desactivar($pkUsuario);
    if($resultado){
        header('Location: ../vistas/lista_usuarios.php?success=Usuario desactivado Exito');
        exit;
    }else{
        header('Location: ../vistas/lista_usuarios.php?error=Error al desactivar Usuario');
        exit;
    }

?>