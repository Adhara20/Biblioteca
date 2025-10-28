<?php
class Subcategoria{
	//metodo constructor
	function __construct(){
		//se requiere una vez el archivo de conexion
		require_once('conexion.php');
		$this->conexion = new Conexion();
	}
	function guardar($nombre, $iconoSubCategoria, $abreviatura, $fkCategoria){
		$consulta = "INSERT INTO subCategoria (nombreSubCategoria, iconoSubCategoria, abreviatura, fkCategoria) VALUES ('{$nombre}', '{$iconoSubCategoria}', '{$abreviatura}',{$fkCategoria})";
		$respuesta = $this->conexion->query($consulta);
		return $respuesta;
	}	
	function listaActivo(){
		$consulta = "SELECT * FROM subCategoria WHERE estatus='A'";
		$respuesta = $this->conexion->query($consulta);

		$subcategorias = [];
		if($respuesta){ 
        while($fila = $respuesta->fetch_assoc()){
            $subcategorias[] = $fila;
        }
		}
        return $subcategorias;
	}
	function listaInactivo(){
		$consulta = "SELECT * FROM subCategoria WHERE estatus='I'";
		$respuesta = $this->conexion->query($consulta);

		$subcategorias = [];
		if($respuesta){ 
        while($fila = $respuesta->fetch_assoc()){
            $subcategorias[] = $fila;
        }
		}
        return $subcategorias;
	}
} 
 ?>