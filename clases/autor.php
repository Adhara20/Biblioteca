<?php
class Autor{
	//metodo constructor
	function __construct(){
		//se requiere una vez el archivo de conexion
		require_once('conexion.php');
		$this->conexion = new Conexion();
	}
	function guardar($nombreAutor, $iconoAutor, $fkNacionalidad){
		$consulta = "INSERT INTO autor (nombreAutor, iconoAutor, fkNacionalidad) VALUES ('{$nombreAutor}', '{$iconoAutor}', '{$fkNacionalidad}')";
		$respuesta = $this->conexion->query($consulta);
		return $respuesta;
	}	
	function mostrar(){
		// $consulta = "SELECT a.*, n.* FROM autor a INNER JOIN nacionalidad n ON a.fkNacionalidad = n.pkNacionalidad WHERE a.estatus = 'A'";
		$consulta = "SELECT autor.pkAutor, autor.nombreAutor, autor.iconoAutor, nacionalidad.nombreNaci FROM autor INNER JOIN nacionalidad ON autor.fkNacionalidad = nacionalidad.pkNacionalidad WHERE autor.estatus = 'A'";
		$resultado = $this->conexion->query($consulta);
		return $resultado;

	}
function filtrar($buscar = '', $estatus = '') {
    $consulta = "SELECT a.*, n.nombreNaci FROM autor a INNER JOIN nacionalidad n ON a.fkNacionalidad = n.pkNacionalidad WHERE 1=1";

    if (!empty($buscar)) {
        $buscar = mysqli_real_escape_string($this->conexion, $buscar);
        $consulta .= " AND (a.nombreAutor LIKE '%$buscar%' OR n.nombreNaci LIKE '%$buscar%')";
    }


    if (!empty($estatus)) {
        $estatus = mysqli_real_escape_string($this->conexion, $estatus);
        $consulta .= " AND a.estatus = '$estatus'";
    } else {
        // Si no se elige estatus, por defecto muestra los activos
        $consulta .= " AND a.estatus = 'A'";
    }
	 $nacionalidad = $_GET['nacionalidad'] ?? '';
    if (!empty($nacionalidad)) {
        $nacionalidad = mysqli_real_escape_string($this->conexion, $nacionalidad);
        $consulta .= " AND a.fkNacionalidad = '$nacionalidad'";
    }

    $resultado = mysqli_query($this->conexion, $consulta);
    return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
}
function desactivar($pkAutor) {
        $consulta = "UPDATE autor
                     SET estatus = 'I' 
                     WHERE pkAutor = '{$pkAutor}'";
        $resultado = $this->conexion->query($consulta);
        return $resultado;
    }

    function activar($pkAutor) {
        $consulta = "UPDATE autor
                     SET estatus = 'A' 
                     WHERE pkAutor = '{$pkAutor}'";
        $resultado = $this->conexion->query($consulta);
        return $resultado;
    }
	    function verCategoria($pkAutor) {
        $consulta = "SELECT * FROM autor 
                     WHERE pkAutor = '$pkAutor'";
        $resultado = $this->conexion->query($consulta);
        return $resultado;
    }
	function detalles($pkAutor) {
    $consulta = "SELECT a.*, n.nombreNaci
                 FROM autor a
                 INNER JOIN nacionalidad n ON a.fkNacionalidad = n.pkNacionalidad
                 WHERE a.pkAutor = '{$pkAutor}'";

    $respuesta = $this->conexion->query($consulta);
    return $respuesta;
}
	    function actualizar($pkAutor, $nombreAutor, $iconoAutor, $fkNacionalidad) {
    $consulta = "UPDATE autor SET 
        nombreAutor = '{$nombreAutor}',
        iconoAutor = '{$iconoAutor}',
        fkNacionalidad = {$fkNacionalidad}
        WHERE pkAutor = '{$pkAutor}'";
    $resultado = $this->conexion->query($consulta);
    return $resultado;
    }
}
 ?>