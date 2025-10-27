<?php
$codigoEstanteria = $_POST['codigoEstanteria'];
$pasillo = $_POST['pasillo'];
$piso = $_POST['piso'];
$niveles = $_POST['niveles'];
$descripcion = $_POST['descripcion'];
$estatus = $_POST['estatus'];
include('../clases/estanterias.php');
$clase = new Estanterias();
$resultado = $clase->guardar($codigoEstanteria, $pasillo, $piso, $niveles, $descripcion, $estatus);
if($resultado){
	echo "Guardado";
}else{
	echo "Error";
}
?>