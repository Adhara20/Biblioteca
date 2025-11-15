<?php
$url = $_POST['url'];
$fkLibro = $_POST['fkLibro'];

include('../clases/url.php');

$clase = new URL();
$resultado = $clase->guardar($url, $fkLibro);

if ($resultado) {
    echo "URL registrada correctamente.";
} else {
    echo "Error al registrar la URL.";
}
?>
