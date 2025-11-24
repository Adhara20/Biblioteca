<?php
session_start();

$pkMulta       = $_POST['pkMulta'] ?? null;
$codigoMulta   = strtoupper($_POST['codigoMulta'] ?? '');
$tipoMulta     = $_POST['tipoMulta'] ?? '';
$montoMulta    = $_POST['montoMulta'] ?? null;
$fechaRegistro = $_POST['fechaRegistro'] ?? null;
$fechaPago     = $_POST['fechaPago'] ?? null;
$fkPrestamo    = $_POST['fkPrestamo'] ?? null;
$estatus       = $_POST['estatus'] ?? 'A';

include('../clases/Multa.php');
$multa = new Multa();

// --- Validaciones ---
$errores = [];

// PK debe existir
if (!$pkMulta) {
    $errores[] = "No se especificó la multa.";
}

// Código obligatorio
if (empty($codigoMulta)) {
    $errores[] = "El código de la multa es obligatorio.";
}

// Tipo válido
$tiposPermitidos = ['Retraso','Daño','Perdido'];
if (!in_array($tipoMulta, $tiposPermitidos)) {
    $errores[] = "Tipo de multa inválido.";
}

// Monto positivo
if ($montoMulta !== null && $montoMulta < 0) {
    $errores[] = "El monto de la multa debe ser positivo.";
}

// Fecha registro obligatoria
if (empty($fechaRegistro)) {
    $errores[] = "La fecha de registro es obligatoria.";
}

// FK Prestamo obligatorio
if (empty($fkPrestamo)) {
    $errores[] = "Debe seleccionar un préstamo.";
}

// Si hay errores, redirigir con mensaje
if (!empty($errores)) {
    $msg = implode(", ", $errores);
    header("Location: ../vistas/editar_multa.php?pkMulta=$pkMulta&error=$msg");
    exit;
}

// --- Ejecutar actualización ---
$resultado = $multa->actualizar(
    $pkMulta,
    $codigoMulta,
    $tipoMulta,
    $montoMulta,
    $fechaPago,
    $fkPrestamo,
    $estatus
);

// --- Redirigir según resultado ---
if ($resultado) {
    header("Location: ../vistas/detalle_multa.php?pkMulta=$pkMulta&success=Multa actualizada correctamente");
} else {
    header("Location: ../vistas/editar_multa.php?pkMulta=$pkMulta&error=Error al actualizar la multa");
}
exit;
?>
