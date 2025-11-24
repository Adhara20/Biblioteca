<?php
include_once('../clases/estanterias.php');
$clase = new Estanterias();

$buscar = $_GET['buscar'] ?? '';
$estatus = $_GET['estatus'] ?? '';

$resultado = $clase->filtrar($buscar, $estatus);
?>