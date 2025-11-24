<?php
class Categoria{
	//metodo constructor
	function __construct(){
		//se requiere una vez el archivo de conexion
		require_once('conexion.php');
        // require_once(__DIR__ . "/conexion.php");

		$this->conexion = new Conexion();
	}
	function guardar($nombre, $iconoCategoria){
		$consulta = "INSERT INTO categoria (nombreCategoria, iconoCategoria) VALUES ('{$nombre}', '{$iconoCategoria}')";
		$respuesta = $this->conexion->query($consulta);
		return $respuesta;
	}	
	function mostrar(){
		$consulta = "SELECT pkCategoria, nombreCategoria FROM categoria WHERE estatus='A'";
		$resultado = $this->conexion->query($consulta);
		return $resultado;
	}
	// "SELECT * FROM categoria WHERE estatus='A'";
	 function filtrar($buscar = '', $estatus = '') {
    $consulta = "SELECT * FROM categoria WHERE 1=1";

    if (!empty($buscar)) {
        $buscar = mysqli_real_escape_string($this->conexion, $buscar);
        $consulta .= " AND (nombreCategoria LIKE '%$buscar%')";
    }

    if (!empty($estatus)) {
        $estatus = mysqli_real_escape_string($this->conexion, $estatus);
        $consulta .= " AND estatus = '$estatus'";
    } else {
        // Si no se elige estatus, por defecto muestra los activos
        $consulta .= " AND estatus = 'A'";
    }

    $resultado = mysqli_query($this->conexion, $consulta);
    return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
}
    function desactivar($pkCategoria) {
        $consulta = "UPDATE categoria
                     SET estatus = 'I' 
                     WHERE pkCategoria = '{$pkCategoria}'";
        $resultado = $this->conexion->query($consulta);
        return $resultado;
    }

    function activar($pkCategoria) {
        $consulta = "UPDATE categoria
                     SET estatus = 'A' 
                     WHERE pkCategoria = '{$pkCategoria}'";
        $resultado = $this->conexion->query($consulta);
        return $resultado;
    }
	    function verCategoria($pkCategoria) {
        $consulta = "SELECT * FROM categoria 
                     WHERE pkCategoria = '$pkCategoria'";
        $resultado = $this->conexion->query($consulta);
        return $resultado;
    }
	    function detalles($pkCategoria) {
    $consulta = "SELECT * FROM categoria WHERE pkCategoria = '{$pkCategoria}'";
    $respuesta = $this->conexion->query($consulta);
    return $respuesta;
    }
	    function actualizar($pkCategoria, $nombreCategoria, $iconoCategoria) {
    $consulta = "UPDATE categoria SET 
        nombreCategoria = '{$nombreCategoria}',
        iconoCategoria = '{$iconoCategoria}'
        WHERE pkCategoria = '{$pkCategoria}'";
    $resultado = $this->conexion->query($consulta);
    return $resultado;
    }
}