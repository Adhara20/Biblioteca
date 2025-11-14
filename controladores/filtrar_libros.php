<?php
include_once('../clases/libro.php');
$clase = new Libro();

$buscar = $_GET['buscar'] ?? '';
$categoria = $_GET['categoria'] ?? '';
$estatus = $_GET['estatus'] ?? '';

$resultado = $clase->filtrar($buscar, $categoria, $estatus);
?>