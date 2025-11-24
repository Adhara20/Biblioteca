<?php
include_once('../clases/autor.php');
$clase = new Autor();

$buscar = $_GET['buscar'] ?? '';
// $nombre = $_GET['nombre'] ?? '';
// $fkCategoria = $_GET['fkCategoria'] ?? '';
$estatus = $_GET['estatus'] ?? '';

$resultado = $clase->filtrar($buscar, $estatus);
?>