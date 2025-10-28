<?php
class Autor{
	//metodo constructor
	function __construct(){
		//se requiere una vez el archivo de conexion
		require_once('conexion.php');
		$this->conexion = new Conexion();
	}
	function guardar($nombreAutor, $fkNacionalidad){
		$consulta = "INSERT INTO autor (nombreAutor, fkNacionalidad) VALUES ('{$nombreAutor}', '{$fkNacionalidad}')";
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