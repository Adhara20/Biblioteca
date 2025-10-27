<?php
$nombre = $_POST['nombre'];
$iconoSubCategoria = $_POST['nombreIconoSubCategoria'];
$abreviatura = $_POST['abreviatura'];
$fkCategoria = $_POST['fkCategoria'];
$estatus = $_POST['estatus'];
include('../clases/subcategoria.php');
$clase = new Subcategoria();
$resultado = $clase->guardar($nombre, $iconoSubCategoria, $abreviatura, $fkCategoria, $estatus);
if($resultado){
	echo "Guardado";
}else{
	echo "Error";
}
?>