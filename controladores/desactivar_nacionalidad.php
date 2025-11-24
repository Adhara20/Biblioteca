<?php
$pkNacionalidad = $_GET['pkNacionalidad'];

include('../clases/nacionalidad.php');
$clase = new Nacionalidad();

$resultado = $clase->desactivar($pkNacionalidad);

if ($resultado) {
    header("Location: ../vistas/lista_nacionalidades.php?success=Nacionalidad desactivada con éxito");
    exit;
} else {
    header("Location: ../vistas/lista_nacionalidades.php?error=Error al desactivar");
    exit;
}
?>
