<?php
$nombreEditorial = $_POST['nombreEditorial'];
$fkNacionalidad = $_POST['fkNacionalidad'];

include('../clases/editorial.php');

$clase = new Editorial();

$resultado = $clase->guardar($nombreEditorial, $fkNacionalidad);

if ($resultado) {
        header("Location: ../vistas/lista_editoriales.php?success=Editorial registrada correctamente");
        exit;
    } else {
        header("Location: ../vistas/formulario_editorial.php?error=Error al registrar Editorial");
        exit;
    }
?>
