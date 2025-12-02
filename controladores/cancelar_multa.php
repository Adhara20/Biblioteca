<?php
require_once('../includes/auth.php');

// Solo Admin y Bibliotecario
requireRole(['A', 'B']);
?>

<?php
$pkMulta = $_GET['pkMulta'];

include('../clases/multa.php');
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
