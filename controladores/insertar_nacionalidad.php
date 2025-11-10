<?php
$nombreNaci = $_POST['nombreNaci'];

include('../clases/nacionalidad.php');

$clase = new Nacionalidad();

$resultado = $clase->guardar($nombreNaci);

if ($resultado) {
        header("Location: ../vistas/lista_nacionalidades.php?success=Nacionalidad registrada correctamente");
        exit;
    } else {
        header("Location: ../vistas/lista_nacionalidades.php?error=Error al registrar Nacionalidad");
        exit;
    }
?>
