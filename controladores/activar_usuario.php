<?php
require_once('../includes/auth.php');

// Solo Admin y Bibliotecario
requireRole(['A']);
?>

<?php
    $pkUsuario=$_GET['pkUsuario'];

    include('../clases/usuario.php');
    $clase= new Usuario();

    $resultado = $clase->activar($pkUsuario);
    if($resultado){
        header('Location: ../vistas/lista_usuarios.php?success=Usuario activado Exito');
        exit;
    }else{
        header('Location: ../vistas/lista_usuarios.php?error=Error al activar Usuario');
        exit;
    }

?>