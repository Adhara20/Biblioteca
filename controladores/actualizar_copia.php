<?php
$isbn = $_POST['isbn'];
$pkCopiaF = $_POST['pkCopiaF']; 
$observaciones = $_POST['observaciones'];

include('../clases/copia.php');
$copia = new Copia();

// Ejecutar actualización
$resultado = $copia->actualizar(
    $pkCopiaF,
    $isbn,
    $observaciones
);

if ($resultado) {
    header("Location: ../vistas/detalle_copia.php?pkCopiaF=$pkCopiaF&success=Copia actualizado correctamente");
} else {
    header("Location: ../vistas/editar_copia.php?pkCopiaF=$pkCopiaF&error=Error al actualizar");
}

exit;
?>