<?php
include_once('../clases/categoria.php');
$clase = new Categoria();

$buscar = mb_strtoupper($_GET['buscar'] ?? '', 'UTF-8');
// $nombre = $_GET['nombre'] ?? '';
$estatus = $_GET['estatus'] ?? '';

$resultado = $clase->filtrar($buscar, $estatus);
?>