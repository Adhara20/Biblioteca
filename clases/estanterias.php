<?php
class Estanterias{
	//metodo constructor
	function __construct(){
		//se requiere una vez el archivo de conexion
		require_once('conexion.php');
		$this->conexion = new Conexion();
	}
	function guardar($codigoEstanteria, $pasillo, $piso, $niveles, $descripcion, $estatus='A'){
		$consulta = "INSERT INTO estanteria (codigoEstanteria, pasillo, piso, cantNiveles, descripcion, estatus) VALUES ('{$codigoEstanteria}', '{$pasillo}', '{$piso}','{$niveles}','{$descripcion}', '{$estatus}')";
		$respuesta = $this->conexion->query($consulta);
		return $respuesta;
	}	
	function listaActivos(){
		$consulta = "SELECT * FROM estanteria WHERE estatus='A'";
		$respuesta = $this->conexion->query($consulta);

		$estanteria = [];
		if($respuesta){ 
        while($fila = $respuesta->fetch_assoc()){
            $estanteria[] = $fila;
        }
		}
        return $estanteria;
	}
} 
 ?>