<?php
class Subcategoria{
	//metodo constructor
    // private $conexion;

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
		function mostrar(){
		$consulta = "SELECT subCategoria.pkSubCategoria, subCategoria.nombreSubCategoria, subCategoria.iconoSubCategoria, subCategoria.abreviatura, categoria.nombreCategoria FROM subCategoria INNER JOIN categoria ON subCategoria.fkCategoria = categoria.pkCategoria WHERE subCategoria.estatus = 'A'";
		$resultado = $this->conexion->query($consulta);
		return $resultado;

	}
	 function filtrar($buscar = '', $estatus = '') {
    $consulta = "SELECT s.*, c.nombreCategoria FROM subcategoria s INNER JOIN categoria c ON s.fkCategoria = c.pkCategoria WHERE 1=1";

    if (!empty($buscar)) {
        $buscar = mysqli_real_escape_string($this->conexion, $buscar);
        $consulta .= " AND (s.nombreSubCategoria LIKE '%$buscar%' OR c.nombreCategoria LIKE '%$buscar%' OR s.abreviatura LIKE '%$buscar%')";
    }


    if (!empty($estatus)) {
        $estatus = mysqli_real_escape_string($this->conexion, $estatus);
        $consulta .= " AND s.estatus = '$estatus'";
    } else {
        // Si no se elige estatus, por defecto muestra los activos
        $consulta .= " AND s.estatus = 'A'";
    }
        $categoria = $_GET['categoria'] ?? '';
    if (!empty($categoria)) {
        $categoria = mysqli_real_escape_string($this->conexion, $categoria);
        $consulta .= " AND s.fkCategoria = '$categoria'";
    }

    $resultado = mysqli_query($this->conexion, $consulta);
    return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
}
function desactivar($pkSubCategoria) {
        $consulta = "UPDATE subCategoria
                     SET estatus = 'I' 
                     WHERE pkSubCategoria = '{$pkSubCategoria}'";
        $resultado = $this->conexion->query($consulta);
        return $resultado;
    }

    function activar($pkSubCategoria) {
        $consulta = "UPDATE subCategoria
                     SET estatus = 'A' 
                     WHERE pkSubCategoria = '{$pkSubCategoria}'";
        $resultado = $this->conexion->query($consulta);
        return $resultado;
    }
	    function verSubCategoria($pkSubCategoria) {
        $consulta = "SELECT * FROM subCategoria 
                     WHERE pkSubCategoria = '$pkSubCategoria'";
        $resultado = $this->conexion->query($consulta);
        return $resultado;
    }
	//     function detalles($pkSubCategoria) {
    // $consulta = "SELECT * FROM subCategoria WHERE pkSubCategoria = '{$pkSubCategoria}'";
    // $respuesta = $this->conexion->query($consulta);
    // return $respuesta;
    // }
    function detalles($pkSubCategoria) {
    $consulta = "SELECT s.*, c.nombreCategoria
                 FROM subcategoria s
                 INNER JOIN categoria c ON s.fkCategoria = c.pkCategoria
                 WHERE s.pkSubCategoria = '{$pkSubCategoria}'";

    $respuesta = $this->conexion->query($consulta);
    return $respuesta;
}
	    function actualizar($pkSubCategoria, $nombreSubCategoria, $iconoSubCategoria, $abreviatura, $fkCategoria) {
    $consulta = "UPDATE subCategoria SET 
        nombreSubCategoria = '{$nombreSubCategoria}',
        iconoSubCategoria = '{$iconoSubCategoria}',
        abreviatura = '{$abreviatura}',
        fkCategoria = {$fkCategoria}

        WHERE pkSubCategoria = '{$pkSubCategoria}'";
    $resultado = $this->conexion->query($consulta);
    return $resultado;
    }

} 
 ?>