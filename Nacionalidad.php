<?php
class Nacionalidad {
    private $conexion;

    function __construct() {
        require_once("conexion.php");
        $this->conexion = new Conexion();
    }

    function guardar($nombreNaci) {
        $consulta = "INSERT INTO nacionalidad (nombreNaci)
                     VALUES ('$nombreNaci')";
        $resultado = $this->conexion->query($consulta);
        return $resultado;
    }

    function darBajaNacionalidad($pkNacionalidad) {
        $consulta = "UPDATE nacionalidad 
                     SET estatus = 'I' 
                     WHERE pkNacionalidad = '$pkNacionalidad'";
        $resultado = $this->conexion->query($consulta);
        return $resultado;
    }

    function verNacionalidad($pkNacionalidad) {
        $consulta = "SELECT * FROM nacionalidad 
                     WHERE pkNacionalidad = '$pkNacionalidad'";
        $resultado = $this->conexion->query($consulta);
        return $resultado;
    }

    function listaNacionalidades() {
        $consulta = "SELECT * FROM nacionalidad 
                     WHERE estatus = 'A'";
        $resultado = $this->conexion->query($consulta);
        return $resultado;
    }
}
?>
