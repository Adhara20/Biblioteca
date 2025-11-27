<?php
$pkMulta = $_GET['pkMulta'];

include('../clases/Multa.php');
$clase = new Multa();

$resultado = $clase->cancelar($pkMulta);

if ($resultado) {
    header('Location: ../vistas/lista_multas.php?success=Multa cancelada con éxito');
    exit;
} else {
    header('Location: ../vistas/lista_multas.php?error=Error al cancelar la multa');
    exit;
}
?>
