<?php
include_once('../clases/subcategoria.php');
$clase = new Subcategoria();

$buscar = mb_strtoupper($_GET['buscar'] ?? '', 'UTF-8');
// $nombre = $_GET['nombre'] ?? '';
// $fkCategoria = $_GET['fkCategoria'] ?? '';
$estatus = $_GET['estatus'] ?? '';

$resultado = $clase->filtrar($buscar, $estatus);
?>