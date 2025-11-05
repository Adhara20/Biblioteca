<?php
$codigoPrestamo = $_POST['codigoPrestamo'];
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
$resultado = $clase->guardar($codigoPrestamo, $fechaLimite, $folioContrato, $archivoContrato, $folio, $numCredS, $numCredA);


if($resultado){
	echo "Guardado";
}else{
	echo "Error";
}
?>