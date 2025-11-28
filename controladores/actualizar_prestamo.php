<?php
$pkPrestamo = $_POST['pkPrestamo']; 
$fechaLimite = $_POST['fechaLimite']; 
$folioContrato = $_POST['folioContrato']; 
$archivoContrato = $_FILES['archivoContrato']['name'] ?? $fila['archivoContrato'];
$folio = $_POST['folio']; 
$numCredS = $_POST['numCredS']; 
$numCredA = $_POST['numCredA'];

include('../clases/prestamo.php');
$prestamo = new Prestamo();

// AAAAAAAAAAA
$archivoActual = $_POST['archivoActual'];

if (!isset($_FILES['archivoContrato']) || $_FILES['archivoContrato']['error'] !== 0) {
    $archivoContrato = $archivoActual;
} else {
    $archivoNuevo = $_FILES['archivoContrato']['name'];
    $tmp = $_FILES['archivoContrato']['tmp_name'];
    move_uploaded_file($tmp, '../imagenes/archivos/' . $archivoNuevo);
    $archivoContrato = $archivoNuevo;
}

// Ejecutar actualización
$resultado = $prestamo->actualizar(
    $pkPrestamo,
    $fechaLimite,
    $folioContrato,
    $archivoContrato,
    $folio,
    $numCredS,
    $numCredA
);

if ($resultado) {
    header("Location: ../vistas/detalle_prestamo.php?pkPrestamo=$pkPrestamo&success=Prestamo actualizado correctamente");
} else {
    header("Location: ../vistas/editar_prestamo.php?pkPrestamo=$pkPrestamo&error=Error al actualizar");
}

exit;
?>