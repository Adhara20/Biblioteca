<?php
$nombreAutor = $_POST['nombreAutor'];
$fkNacionalidad = $_POST['fkNacionalidad'];
include('../clases/autor.php');
$clase = new Autor();
$resultado = $clase->guardar($nombreAutor, $fkNacionalidad);
if($resultado){
	echo "Guardado";
}else{
	echo "Error";
}
?>