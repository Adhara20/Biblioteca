<?php
require_once('../includes/auth.php');

// Solo Admin y Bibliotecario
requireRole(['A', 'B']);
?>

<?php

$pkNacionalidad = $_POST['pkNacionalidad'];
$nombre = mb_strtoupper($_POST['nombre'], 'UTF-8');

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
