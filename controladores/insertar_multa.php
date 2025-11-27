<?php
session_start();

// Recibir datos del formulario
$tipoMulta      = $_POST['tipoMulta'];
//Redondea el número a 2 decilales
$montoMulta = round(floatval($_POST['montoMulta']), 2);
$fechaRegistro  = $_POST['fechaRegistro'];
$codigoPrestamo = $_POST['codigoPrestamo']; // ← ESTE es el correcto

// Guardar datos en sesión por si ocurre un error
$_SESSION['form_multa'] = [
    'tipoMulta'      => $tipoMulta,
    'montoMulta'     => $montoMulta,
    'codigoPrestamo' => $codigoPrestamo
];

include('../clases/multa.php');
$clase = new Multa();

// Intentar insertar (la clase convierte código → pk)
$resultado = $clase->insertar($tipoMulta, $montoMulta, $fechaRegistro, $codigoPrestamo);

if ($resultado) {

    // Limpiar los datos del formulario
    unset($_SESSION['form_multa']);

    // Redirigir con mensaje de éxito
    header("Location: ../vistas/lista_multas.php?success=Multa registrada correctamente");
    exit;

} else {

    // Redirigir con mensaje de error genérico
    // (si quieres, te puedo armar un mensaje más específico)
    header("Location: ../vistas/formulario_multa.php?error=No se pudo registrar la multa. Verifique el código del préstamo.");
    exit;
}
?>
