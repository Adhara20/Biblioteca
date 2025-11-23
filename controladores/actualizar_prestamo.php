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

if (!empty($_FILES['archivoContrato']['tmp_name'])) {
    $ruta = "../imagenes/archivos/" . basename($_FILES['archivoContrato']['name']);
    move_uploaded_file($_FILES['archivoContrato']['tmp_name'], $ruta);
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