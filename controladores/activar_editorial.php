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
