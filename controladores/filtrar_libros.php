<?php
include_once('../clases/libro.php');
$clase = new Libro();

$buscar = strtoupper($_GET['buscar'] ?? '');
$categoria = $_GET['categoria'] ?? '';
$idioma = $_GET['idioma'] ?? '';
$estatus = $_GET['estatus'] ?? '';

$resultado = $clase->filtrar($buscar, $categoria, $idioma, $estatus);
?>