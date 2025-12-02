<?php
require_once('../includes/auth.php');

// Solo Admin y Bibliotecario
requireRole(['A', 'B']);
?>

<?php

$pkEditorial = $_POST['pkEditorial'];
$nombre = mb_strtoupper($_POST['nombreEditorial'], 'UTF-8');
$fkNacionalidad = $_POST['fkNacionalidad'];

include('../clases/editorial.php');
$e = new Editorial();

$resultado = $e->actualizar($pkEditorial, $nombre, $fkNacionalidad);

if ($resultado) {
    header("Location: ../vistas/detalle_editorial.php?pkEditorial=$pkEditorial&success=Actualizado correctamente");
    exit;
} else {
    header("Location: ../vistas/editar_editorial.php?pkEditorial=$pkEditorial&error=Error al actualizar");
    exit;
}
?>
