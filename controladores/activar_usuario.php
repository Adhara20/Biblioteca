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