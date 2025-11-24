<?php

$pkEditorial = $_POST['pkEditorial'];
$nombre = strtoupper($_POST['nombreEditorial']);
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
