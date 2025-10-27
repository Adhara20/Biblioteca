<?php
class Subcategoria{
	//metodo constructor
	function __construct(){
		//se requiere una vez el archivo de conexion
		require_once('conexion.php');
		$this->conexion = new Conexion();
	}
	function guardar($nombre, $iconoSubCategoria, $abreviatura, $fkCategoria, $estatus='A' ){
		$consulta = "INSERT INTO subCategoria (nombreSubCategoria, iconoSubCategoria, abreviatura, fkCategoria, estatus) VALUES ('{$nombre}', '{$iconoSubCategoria}', '{$abreviatura}',{$fkCategoria}, '{$estatus}')";
		$respuesta = $this->conexion->query($consulta);
		return $respuesta;
	}	
	function mostrar(){
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
} 
 ?>