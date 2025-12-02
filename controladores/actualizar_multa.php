<?php
require_once('../includes/auth.php');

// Solo Admin y Bibliotecario
requireRole(['A', 'B']);
?>

<?php
session_start();
$pkMulta       = $_POST['pkMulta'] ?? null;
$tipoMulta     = $_POST['tipoMulta'] ?? '';
$montoMulta    = $_POST['montoMulta'] ?? null;
$codigoPrestamo    = $_POST['codigoPrestamo'] ?? null;

include('../clases/multa.php');
$multa = new Multa();

// --- Validaciones ---
$errores = [];

// PK debe existir
if (!$pkMulta) {
    $errores[] = "No se especificó la multa.";
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


// Si hay errores, redirigir con mensaje
if (!empty($errores)) {
    $msg = implode(", ", $errores);
    header("Location: ../vistas/editar_multa.php?pkMulta=$pkMulta&error=$msg");
    exit;
}

// --- Ejecutar actualización ---
$resultado = $multa->actualizar(
    $pkMulta,
    $tipoMulta,
    $montoMulta,
    $codigoPrestamo
);

// --- Redirigir según resultado ---
if ($resultado) {
    header("Location: ../vistas/detalle_multa.php?pkMulta=$pkMulta&success=Multa actualizada correctamente");
} else {
    header("Location: ../vistas/editar_multa.php?pkMulta=$pkMulta&error=Error al actualizar la multa");
}
exit;
?>
