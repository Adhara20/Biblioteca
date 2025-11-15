<?php
include_once('../clases/prestamo.php');
$clase = new Prestamo();

$buscar = $_GET['buscar'] ?? '';
$estatus = $_GET['estatus'] ?? '';
$estatusDevolucion = $_GET['estatusDevolucion'] ?? '';
$fechaRegistro = $_GET['fechaRegistro'] ?? '';

$resultadoPF = $clase->filtrar($buscar, $estatus, $estatusDevolucion, $fechaRegistro);
?>