<?php
$tipoMulta = $_POST['tipoMulta'];
$montoMulta = $_POST['montoMulta'];
$fechaRegistro = $_POST['fechaRegistro'];
$fechaPago = $_POST['fechaPago'];
$fkPrestamo = $_POST['fkPrestamo'];

include('../clases/multa.php');

$clase = new Multa();

$resultado = $clase->registrarMulta($tipoMulta, $montoMulta, $fechaRegistro, $fechaPago, $fkPrestamo);

if ($resultado) {
    echo "Multa registrada correctamente.";
} else {
    echo "Error al registrar la multa.";
}
