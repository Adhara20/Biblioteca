<?php
session_start();

// Recibir datos del formulario
$tipoMulta     = $_POST['tipoMulta'];
$montoMulta    = $_POST['montoMulta'];
$fechaRegistro = $_POST['fechaRegistro'];
$fechaPago     = $_POST['fechaPago'];
$fkPrestamo    = $_POST['fkPrestamo'];

// Guardar datos en sesión por si ocurre un error
$_SESSION['form_multa'] = [
    'tipoMulta'      => $tipoMulta,
    'montoMulta'     => $montoMulta,
    'fechaRegistro'  => $fechaRegistro,
    'fechaPago'      => $fechaPago,
    'fkPrestamo'     => $fkPrestamo
];

include('../clases/multa.php');
$clase = new Multa();

$resultado = $clase->insertar($tipoMulta, $montoMulta, $fechaRegistro, $fechaPago, $fkPrestamo);

if ($resultado) {

    // Limpiar el formulario
    unset($_SESSION['form_multa']);

    // Redirigir directamente a la lista de multas mostrando mensaje
    header("Location: ../vistas/lista_multas.php?success=Multa registrada correctamente");
    exit;
    
} else {

    // Regresar con error y mantener los valores
    header("Location: ../vistas/formulario_multa.php?error=Error al registrar la multa");
    exit;
}
?>
