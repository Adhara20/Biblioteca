<?php
include_once('../clases/copia.php');
$clase = new Copia();

$buscar = mb_strtoupper($_GET['buscar'] ?? '', 'UTF-8');
$subcategoria = $_GET['subcategoria'] ?? '';
$estatus = $_GET['estatus'] ?? '';

$resultadoCF = $clase->filtrar($buscar, $subcategoria, $estatus);
?>