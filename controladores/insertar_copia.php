<?php
$isbn = $_POST['isbn'];
$folio = $_POST['folio'];
$fkEstanteria = $_POST['fkEstanteria'];

include('../clases/copia.php');


$clase = new Copia();

$resultado = $clase ->guardar($isbn, $folio, $fkEstanteria);

if($resultado){
	echo "guardado";
 }else{
 	echo "error";
 }
?>