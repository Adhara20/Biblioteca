<?php
include_once('../clases/usuario.php');
$clase = new Usuario();

$buscar = $_GET['buscar'] ?? '';
$rol = $_GET['rol'] ?? '';
$estatus = $_GET['estatus'] ?? '';
$vetado = $_GET['vetado'] ?? '';
$sexo = $_GET['sexo'] ?? '';
$fechaRegistro = $_GET['fechaRegistro'] ?? '';

$resultado = $clase->filtrar($buscar, $rol, $estatus, $vetado, $sexo, $fechaRegistro);
?>
