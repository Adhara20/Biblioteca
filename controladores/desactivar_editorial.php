<?php
require_once('../includes/auth.php');

// Solo Admin y Bibliotecario
requireRole(['A', 'B']);
?>

<?php
$pkEditorial = $_GET['pkEditorial'];

include('../clases/editorial.php');
$clase = new Editorial();

$resultado = $clase->desactivar($pkEditorial);

if ($resultado) {
    header("Location: ../vistas/lista_editoriales.php?success=Editorial desactivada con éxito");
    exit;
} else {
    header("Location: ../vistas/lista_editoriales.php?error=Error al desactivar");
    exit;
}
?>

