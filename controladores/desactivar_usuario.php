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