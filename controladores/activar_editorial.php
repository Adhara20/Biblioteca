<?php
require_once('../includes/auth.php');

// Solo Admin y Bibliotecario
requireRole(['A', 'B']);
?>

<?php
$pkEditorial = $_GET['pkEditorial'];

include('../clases/editorial.php');
$clase = new Editorial();

$resultado = $clase->activar($pkEditorial);

if ($resultado) {
    header("Location: ../vistas/lista_editoriales.php?success=Editorial activada con éxito");
    exit;
} else {
    header("Location: ../vistas/lista_editoriales.php?error=Error al activar");
    exit;
}
?>
