<?php
    class Idioma{
        //metodo constructor
	function __construct(){
		//se requiere una vez el archivo de conexion
		require_once('conexion.php');
		$this->conexion = new Conexion();
	}
        function mostrar(){
            $consulta = "SELECT * FROM idioma";
            $resultado = $this->conexion->query($consulta);
	    	return $resultado;
        }
    }
?>