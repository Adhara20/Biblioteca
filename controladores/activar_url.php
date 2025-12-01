<?php
$pkURL = $_GET['pkURL'];

include('../clases/url.php');
$clase = new URL();

$resultado = $clase->activar($pkURL);

if ($resultado) {
    header("Location: ../vistas/lista_urls.php?success=URL activada con éxito");
    exit;
} else {
    header("Location: ../vistas/lista_urls.php?error=Error al activar la URL");
    exit;
}
?>
