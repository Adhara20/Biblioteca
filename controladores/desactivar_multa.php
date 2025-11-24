<?php
$pkMulta = $_GET['pkMulta'];

include('../clases/Multa.php');
$clase = new Multa();

$resultado = $clase->desactivar($pkMulta);

if ($resultado) {
    header('Location: ../vistas/lista_multas.php?success=Multa desactivada con éxito');
    exit;
} else {
    header('Location: ../vistas/lista_multas.php?error=Error al desactivar la multa');
    exit;
}
?>

