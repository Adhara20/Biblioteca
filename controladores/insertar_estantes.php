<?php
$nivel = $_POST['nivel'];
$fkEstanteria = $_POST['fkEstanteria'];
$fkSubCategoria = $_POST['fkSubCategoria'];
$estatus = $_POST['estatus'];
include('../clases/estantes.php');
$clase = new Estantes();
$resultado = $clase->guardar($nivel, $fkEstanteria, $fkSubCategoria, $estatus);
if ($resultado) {
        header("Location: ../vistas/lista_usuarios.php?success=Usuario registrado correctamente");
        exit;
    } else {
        header("Location: ../vistas/formulario_usuario.php?error=Error al registrar el usuario");
        exit;
    }
?>