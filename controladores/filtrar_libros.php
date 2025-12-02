<?php
include_once('../clases/libro.php');
$clase = new Libro();

$buscar = mb_strtoupper($_GET['buscar'] ?? '', 'UTF-8');
$categoria = $_GET['categoria'] ?? '';
$idioma = $_GET['idioma'] ?? '';
$estatus = $_GET['estatus'] ?? '';

$resultado = $clase->filtrar($buscar, $categoria, $idioma, $estatus);
?>