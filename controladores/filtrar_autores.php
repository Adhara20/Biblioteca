<?php
include_once('../clases/autor.php');
$clase = new Autor();

$buscar = mb_strtoupper($_GET['buscar'] ?? '', 'UTF-8');
// $nombre = $_GET['nombre'] ?? '';
// $fkCategoria = $_GET['fkCategoria'] ?? '';
$estatus = $_GET['estatus'] ?? '';

$resultado = $clase->filtrar($buscar, $estatus);
?>