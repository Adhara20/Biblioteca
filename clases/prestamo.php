<?php
class prestamo{
    function __construct(){
        require_once('Conexion.php');
        $this->conexion = new Conexion();
    }
    function guardar(){
        $consulta = "INSERT INTO prestamo () VALUES ('{$}')"//consulta
        $respuesta = $this->conexion->query($consulta);
        return $respuesta;
    }
}
?>