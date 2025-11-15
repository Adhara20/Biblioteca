<?php
$nombreNaci = $_POST['nombreNaci'];

include('../clases/nacionalidad.php');

$clase = new Nacionalidad();

$resultado = $clase->guardar($nombreNaci);

if ($resultado) {
    echo "Nacionalidad registrada correctamente.";
} else {
    echo "Error al registrar la nacionalidad.";
}
?>
