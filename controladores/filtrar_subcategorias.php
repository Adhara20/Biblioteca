<?php
include_once('../clases/subcategoria.php');
$clase = new Subcategoria();

$buscar = $_GET['buscar'] ?? '';
// $nombre = $_GET['nombre'] ?? '';
// $fkCategoria = $_GET['fkCategoria'] ?? '';
$estatus = $_GET['estatus'] ?? '';

$resultado = $clase->filtrar($buscar, $estatus);
?>