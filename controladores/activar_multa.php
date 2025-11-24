<?php
$pkMulta = $_GET['pkMulta'];

include('../clases/Multa.php');
$clase = new Multa();

$resultado = $clase->activar($pkMulta);

if ($resultado) {
    header('Location: ../vistas/lista_multas.php?success=Multa activada con éxito');
    exit;
} else {
    header('Location: ../vistas/lista_multas.php?error=Error al activar la multa');
    exit;
}
?>
