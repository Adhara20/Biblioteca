<?php
include_once('../clases/nacionalidad.php');
$clase = new Nacionalidad();

$buscar = $_GET['buscar'] ?? '';
$estatus = $_GET['estatus'] ?? '';

$resultado = $clase->filtrar($buscar, $estatus);
