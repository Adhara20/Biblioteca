<?php
require_once('../includes/auth.php');

// Solo Admin y Bibliotecario
requireRole(['A']);
?>

<?php
$pkURL = $_GET['pkURL'];

include('../clases/url.php');
$clase = new URL();

$resultado = $clase->desactivar($pkURL);

if ($resultado) {
    header("Location: ../vistas/lista_urls.php?success=URL desactivada con éxito");
    exit;
} else {
    header("Location: ../vistas/lista_urls.php?error=Error al desactivar la URL");
    exit;
}
?>
