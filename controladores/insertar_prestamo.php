<?php
$codigo = $_POST['codigo'];
$ = $_POST[''];
$ = $_POST[''];
$ = $_POST[''];
$ = $_POST[''];

include('../clases/prestamo.php');
$clase = new Prestamo();
$resultado = $clase->guardar($codigo, $, $, $, $);
if($resultado){
	echo "Guardado";
}else{
	echo "Error";
}
?>