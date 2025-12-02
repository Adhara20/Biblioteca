<?php
include_once('../clases/usuario.php');
$clase = new Usuario();

$buscar = mb_strtoupper($_GET['buscar'] ?? '', 'UTF-8');
$rol = $_GET['rol'] ?? '';
$estatus = $_GET['estatus'] ?? '';
$vetado = $_GET['vetado'] ?? '';
$sexo = $_GET['sexo'] ?? '';
$fechaRegistro = $_GET['fechaRegistro'] ?? '';

$resultado = $clase->filtrar($buscar, $rol, $estatus, $vetado, $sexo, $fechaRegistro);
?>
