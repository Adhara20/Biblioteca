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

