<?php
class Estantes{
	//metodo constructor
	function __construct(){
		//se requiere una vez el archivo de conexion
		require_once('conexion.php');
		$this->conexion = new Conexion();
	}
	function guardar($nivel, $fkEstanteria, $fkSubCategoria, $estatus='A'){
		$consulta = "INSERT INTO estante (nivel, fkEstanteria, fkSubCategoria, estatus) VALUES ('{$nivel}', {$fkEstanteria}, {$fkSubCategoria}, '{$estatus}')";
		$respuesta = $this->conexion->query($consulta);
		return $respuesta;
	}	
	function mostrar(){
		$consulta = "SELECT * FROM estante WHERE estatus='A'";
		$respuesta = $this->conexion->query($consulta);
		return $respuesta;
	}
} 
 ?>