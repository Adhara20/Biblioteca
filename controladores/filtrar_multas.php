<?php
include_once('../clases/Multa.php');
$clase = new Multa();
$clase->generarMulta();

$buscar  = $_GET['buscar'] ?? '';
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
