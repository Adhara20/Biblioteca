<?php 
    include_once('../clases/url.php');
    $clase = new Url();

    $buscar = mb_strtoupper($_GET['buscar'] ?? '', 'UTF-8');
    $estatus = $_GET['estatus'] ?? '';
    $pkLibro = $_GET['pkLibro'] ?? Null;

    if ($pkLibro) {
        // lector solo ve sus multas
        $resultado = $clase->filtrarPorLibro($pkLibro, $buscar, $estatus);
    } else {
        // admin ve todas
        $resultado = $clase->filtrar($buscar, $estatus);
    }



?>