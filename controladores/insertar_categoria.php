<?php
$nombre = $_POST['nombre'];
$iconoCategoria = $_POST['nombreIconoCategoria'];
$estatus = $_POST['estatus'];
include('../clases/categoria.php');
$clase = new Categoria();
$resultado = $clase->guardar($nombre, $iconoCategoria, $estatus);
if($resultado){
	echo "Guardado";
}else{
	echo "Error";
}
?>