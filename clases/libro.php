<?php
class Libro {
    private $conexion;

    function __construct() {
        require_once("conexion.php");
        $this->conexion = new Conexion();
    }

    function registrarLibro($isbn, $titulo, $edicion, $numPaginas, $añoPublicacion, $idioma, $sinopsis, $fkAutor, $fkEditorial, $fkSubcategoria, $portada) {
    $consulta = "INSERT INTO libro 
        (isbn, titulo, edicion, numPaginas, añoPublicacion, idioma, sinopsis, fkAutor, fkEditorial, fkSubCategoria, portada)
        VALUES ('{$isbn}','{$titulo}','{$edicion}',{$numPaginas},'{$añoPublicacion}','{$idioma}','{$sinopsis}',{$fkAutor}, 
            {$fkEditorial},{$fkSubcategoria},'{$portada}')";
    $resultado = $this->conexion->query($consulta);
    return $resultado;
}


    function darBajaLibro($pkLibro) {
        $consulta = "UPDATE libro 
                     SET estatus = 'I' 
                     WHERE pkLibro = '$pkLibro'";
        $resultado = $this->conexion->query($consulta);
        return $resultado;
    }

    function darAltaLibro($pkLibro) {
        $consulta = "UPDATE libro 
                     SET estatus = 'A' 
                     WHERE pkLibro = '$pkLibro'";
        $resultado = $this->conexion->query($consulta);
        return $resultado;
    }
    
    function verLibro($pkLibro) {
        $consulta = "SELECT * FROM libro 
                     WHERE pkLibro = '$pkLibro'";
        $resultado = $this->conexion->query($consulta);
        return $resultado;
    }

    function listaLibrosActivos() {
        $consulta = "SELECT * FROM libro 
                     WHERE estatus = 'A'";
        $resultado = $this->conexion->query($consulta);
        return $resultado;
    }
    function listaLibrosInactivos() {
        $consulta = "SELECT * FROM libro 
                     WHERE estatus = 'I'";
        $resultado = $this->conexion->query($consulta);
        return $resultado;
    }
}
?>
