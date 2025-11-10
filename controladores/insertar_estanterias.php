<?php
$pasillo = $_POST['pasillo'];
$piso = $_POST['piso'];
$niveles = $_POST['niveles'];
$descripcion = $_POST['descripcion'];
include('../clases/estanterias.php');
$clase = new Estanterias();
$resultado = $clase->guardar($pasillo, $piso, $niveles, $descripcion);
if ($resultado) {
        header("Location: ../vistas/lista_estanterias.php?success=Estanteria registrada correctamente");
        exit;
    } else {
        header("Location: ../vistas/formulario_estanterias.php?error=Error al registrar Estanteria");
        exit;
    }
?>