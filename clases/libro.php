<?php
class Libro {
    private $conexion;

    function __construct() {
        require_once("conexion.php");
        $this->conexion = new Conexion();
    }

    function registrarLibro($isbn, $titulo, $edicion, $numPaginas, $añoPublicacion, $idioma, $sinopsis, $fkAutor, $fkEditorial, $fkSubcategoria, $portada) {
    $consulta = "INSERT INTO libro 
        (isbn, titulo, edicion, numPaginas, añoPublicacion, idioma, sinopsis, fkAutor, fkEditorial, fkSubCategoria, portada, fechaRegistro)
        VALUES ('{$isbn}','{$titulo}','{$edicion}',{$numPaginas},'{$añoPublicacion}','{$idioma}','{$sinopsis}',{$fkAutor}, 
            {$fkEditorial},{$fkSubcategoria},'{$portada}', NOW())";
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
        $consulta = "SELECT l.*, c.nombreCategoria, sc.nombreSubCategoria, e.nombreEditorial, a.nombreAutor FROM categoria c INNER JOIN subCategoria sc ON c.pkCategoria = sc.fkCategoria INNER JOIN libro l ON sc.pkSubCategoria=l.fkSubCategoria INNER JOIN autor a ON a.pkAutor=l.fkAutor INNER JOIN editorial e ON l.fkEditorial=e.pkEditorial
                     WHERE l.estatus = 'A'";
        $resultado = $this->conexion->query($consulta);
        return $resultado;
    }
    function listaLibrosInactivos() {
        $consulta = "SELECT l.*, c.nombreCategoria, sc.nombreSubCategoria, e.nombreEditorial, a.nombreAutor FROM categoria c INNER JOIN subCategoria sc ON c.pkCategoria = sc.fkCategoria INNER JOIN libro l ON sc.pkSubCategoria=l.fkSubCategoria INNER JOIN autor a ON a.pkAutor=l.fkAutor INNER JOIN editorial e ON l.fkEditorial=e.pkEditorial
                     WHERE l.estatus = 'I'";
        $resultado = $this->conexion->query($consulta);
        return $resultado;
    }
}
?>
