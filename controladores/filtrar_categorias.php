<?php
include_once('../clases/categoria.php');
$clase = new Categoria();

$buscar = strtoupper($_GET['buscar'] ?? '');
// $nombre = $_GET['nombre'] ?? '';
$estatus = $_GET['estatus'] ?? '';

$resultado = $clase->filtrar($buscar, $estatus);
?>