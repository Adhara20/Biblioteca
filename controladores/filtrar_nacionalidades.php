<?php
include_once('../clases/nacionalidad.php');
$clase = new Nacionalidad();

$buscar = mb_strtoupper($_GET['buscar'] ?? '', 'UTF-8');
$estatus = $_GET['estatus'] ?? '';

$resultado = $clase->filtrar($buscar, $estatus);
?>