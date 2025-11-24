<?php
class Estanterias{
	//metodo constructor
	function __construct(){
		//se requiere una vez el archivo de conexion
		require_once('conexion.php');
		$this->conexion = new Conexion();
	}
	function generarCodigoEstanteria() {
    	$prefijo = "EST-";
    	$consulta = "SELECT codigoEstanteria FROM estanteria WHERE codigoEstanteria LIKE '{$prefijo}%' ORDER BY codigoEstanteria DESC LIMIT 1";
    	$resultado = $this->conexion->query($consulta);
    	if ($fila = $resultado->fetch_assoc()) {
    	    $ultimoNumero = intval(substr($fila['codigoEstanteria'], strlen($prefijo)));
    	    $nuevoNumero = $ultimoNumero + 1;
    	} else {
    	    $nuevoNumero = 1;
    	}
    	$codigo = $prefijo . str_pad($nuevoNumero, 6, "0", STR_PAD_LEFT);
    	return $codigo;
	}

	function guardar($pasillo, $piso, $niveles, $descripcion){
		$codigoEstanteria = $this->generarCodigoEstanteria();
		$consulta = "INSERT INTO estanteria (codigoEstanteria, pasillo, piso, cantNiveles, descripcion) VALUES ('{$codigoEstanteria}', '{$pasillo}', '{$piso}','{$niveles}','{$descripcion}')";
		$respuesta = $this->conexion->query($consulta);
		return $respuesta;
	}
	function filtrar($buscar = '', $estatus = '') {
    $consulta = "SELECT * FROM estanteria WHERE 1=1";

    if (!empty($buscar)) {
        $buscar = mysqli_real_escape_string($this->conexion, $buscar);
        $consulta .= " AND (pasillo LIKE '%$buscar%' OR piso LIKE '%$buscar%')";
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
	// function listaActivos(){
	// 	$consulta = "SELECT * FROM estanteria WHERE estatus='A'";
	// 	$respuesta = $this->conexion->query($consulta);

	// 	$estanteria = [];
	// 	if($respuesta){ 
    //     while($fila = $respuesta->fetch_assoc()){
    //         $estanteria[] = $fila;
    //     }
	// 	}
    //     return $estanteria;
	// }
} 
 ?>