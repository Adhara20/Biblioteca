<?php
$fechaLimite = $_POST['fechaLimite'];
$folioContrato = $_POST['folioContrato'];
$archivoContrato = $_FILES['archivoContrato']['name'];
$ruta = $_FILES['archivoContrato']['tmp_name'];
move_uploaded_file($ruta, '../imagenes/archivos/'.$archivoContrato);
$folio = $_POST['folio'];
$numCredS = $_POST['numCredS'];
$numCredA = $_POST['numCredA'];

include('../clases/prestamo.php');
$clase = new Prestamo();
                    // aquí tambien
$resultado = $clase->guardar($fechaLimite, $folioContrato, $archivoContrato, $folio, $numCredS, $numCredA);


if ($resultado) {
        header("Location: ../vistas/lista_prestamos.php?success=Prestamo registrado correctamente");
        exit;
    } else {
        header("Location: ../vistas/formulario_prestamo.php?error=Error al registrar Prestamo");
        exit;
    }
?>