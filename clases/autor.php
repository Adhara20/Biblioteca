<?php
class Autor{
	//metodo constructor
	function __construct(){
		//se requiere una vez el archivo de conexion
		require_once('conexion.php');
		$this->conexion = new Conexion();
	}
	function guardar($nombre, $fkNacionalidad, $estatus='A'){
		$consulta = "INSERT INTO autor (nombreAutor, fkNacionalidad, estatus) VALUES ('{$nombre}', {$fkNacionalidad}, '{$estatus}')";
		$respuesta = $this->conexion->query($consulta);
		return $respuesta;
	}	
	function mostrar(){
		$consulta = "SELECT * FROM autor";
		$respuesta = $this->conexion->query($consulta);
		return $respuesta;

	}

	function obtenerNacionalidades() {
    	$resultado = $this->conexion->query("SELECT * FROM nacionalidad");
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }
}
 ?>