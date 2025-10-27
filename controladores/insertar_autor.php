<?php
$nombre = $_POST['nombre'];
$fkNacionalidad = $_POST['fkNacionalidad'];
$estatus = $_POST['estatus'];
include('../clases/autor.php');
$clase = new Autor();
$resultado = $clase->guardar($nombre, $fkNacionalidad, $estatus);
if($resultado){
	echo "Guardado";
}else{
	echo "Error";
}
?>