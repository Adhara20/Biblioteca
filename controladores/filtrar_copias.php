<?php
include_once('../clases/copia.php');
$clase = new Copia();

$buscar = $_GET['buscar'] ?? '';
$subcategoria = $_GET['subcategoria'] ?? '';
$estatus = $_GET['estatus'] ?? '';

$resultadoCF = $clase->filtrar($buscar, $subcategoria, $estatus);
?>