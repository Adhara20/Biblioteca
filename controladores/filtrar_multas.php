<?php
include_once('../clases/multa.php');
$clase = new Multa();
$clase->generarMultasAutomaticas();

$buscar = mb_strtoupper($_GET['buscar'] ?? '', 'UTF-8');
$estatus = $_GET['estatus'] ?? '';
$tipo    = $_GET['tipo'] ?? '';

$rol = $_SESSION['rol'];  
$pkUsuario = $_SESSION['pkUsuarioLog'];

if ($rol == 'L') {
    // lector solo ve sus multas
    $resultado = $clase->filtrarPorUsuario($pkUsuario, $buscar, $estatus, $tipo);
} else {
    // admin ve todas
    $resultado = $clase->filtrar($buscar, $estatus, $tipo);
}

?>
