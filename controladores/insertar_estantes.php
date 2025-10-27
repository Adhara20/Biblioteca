<?php
$nivel = $_POST['nivel'];
$fkEstanteria = $_POST['fkEstanteria'];
$fkSubCategoria = $_POST['fkSubCategoria'];
$estatus = $_POST['estatus'];
include('../clases/estantes.php');
$clase = new Estantes();
$resultado = $clase->guardar($nivel, $fkEstanteria, $fkSubCategoria, $estatus);
if($resultado){
	echo "Guardado";
}else{
	echo "Error";
}
?>