<?php
$nombreEditorial = $_POST['nombreEditorial'];
$fkNacionalidad = $_POST['fkNacionalidad'];

include('../clases/editorial.php');

$clase = new Editorial();

$resultado = $clase->guardar($nombreEditorial, $fkNacionalidad);

if ($resultado) {
    echo "Editorial registrada correctamente.";
} else {
    echo "Error al registrar la editorial.";
}
