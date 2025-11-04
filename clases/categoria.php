<?php
class Categoria{
	//metodo constructor
	function __construct(){
		//se requiere una vez el archivo de conexion
		require_once('conexion.php');
		$this->conexion = new Conexion();
	}
	function guardar($nombre, $iconoCategoria){
		$consulta = "INSERT INTO categoria (nombreCategoria, iconoCategoria) VALUES ('{$nombre}', '{$iconoCategoria}')";
		$respuesta = $this->conexion->query($consulta);
		return $respuesta;
	}	
	function mostrar(){
		$consulta = "SELECT * FROM categoria WHERE estatus='A'";
		$resultado = $this->conexion->query($consulta);
		
		$categorias = [];
		if($resultado){ 
        while($fila = $resultado->fetch_assoc()){
            $categorias[] = $fila;
        }
		}
        return $categorias;
	}
} 
 ?>