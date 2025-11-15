<?php
class URL {
    private $conexion;

    function __construct() {
        require_once("conexion.php");
        $this->conexion = new Conexion();
    }

    function guardar($url, $fkLibro) {
        $consulta = "INSERT INTO url (url, fkLibro) 
                     VALUES ('$url', '$fkLibro')";
        $resultado = $this->conexion->query($consulta);
        return $resultado;
    }

    function darBajaURL($pkUrl) {
        $consulta = "UPDATE url 
                     SET estatus = 'I' 
                     WHERE pkUrl = '$pkUrl'";
        $resultado = $this->conexion->query($consulta);
        return $resultado;
    }

    function listaURLs() {
        $consulta = "SELECT * FROM url WHERE estatus = 'A'";
        $resultado = $this->conexion->query($consulta);

        $urls = [];
        if ($resultado) {
            while ($fila = $resultado->fetch_assoc()) {
                $urls[] = $fila;
            }
        }
        return $urls;
    }
    
}
?>
