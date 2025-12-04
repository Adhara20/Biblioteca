<?php
include('../clases/editorial.php');
$edi = new Editorial();

$buscar = mb_strtoupper($_GET['buscar'] ?? '', 'UTF-8');
$nacionalidad = $_GET['nacionalidad'] ?? '';
$estatus = $_GET['estatus'] ?? '';

$resultado = $edi->filtrar($buscar, $nacionalidad, $estatus);
?>