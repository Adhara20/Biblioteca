<?php

$pkNacionalidad = $_POST['pkNacionalidad'];
$nombre = strtoupper($_POST['nombre']);

include('../clases/nacionalidad.php');
$n = new Nacionalidad();

$resultado = $n->actualizar($pkNacionalidad, $nombre);

if ($resultado) {
    header("Location: ../vistas/detalle_nacionalidad.php?pkNacionalidad=$pkNacionalidad&success=Actualizado correctamente");
    exit;
} else {
    header("Location: ../vistas/editar_nacionalidad.php?pkNacionalidad=$pkNacionalidad&error=Error al actualizar");
    exit;
}
?>
