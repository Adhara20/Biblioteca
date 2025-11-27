<?php
$pkMulta = $_GET['pkMulta'];

include('../clases/multa.php');
$clase = new Multa();

$resultado = $clase->pagar($pkMulta);

if ($resultado) {
    header('Location: ../vistas/lista_multas.php?success=Multa pagada con éxito');
    exit;
} else {
    header('Location: ../vistas/lista_multas.php?error=Error al pagar la multa');
    exit;
}
?>

