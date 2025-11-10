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
    function detalles($pkLibro) {
    $consulta = "
        SELECT l.*, a.nombreAutor, e.nombreEditorial, s.nombreSubCategoria, c.nombreCategoria FROM libro l INNER JOIN autor a ON l.fkAutor = a.pkAutor INNER JOIN editorial e ON l.fkEditorial = e.pkEditorial INNER JOIN subcategoria s ON l.fkSubCategoria = s.pkSubCategoria INNER JOIN categoria c ON s.fkCategoria=c.pkCategoria WHERE l.pkLibro = '{$pkLibro}'";
    $respuesta = $this->conexion->query($consulta);
    return $respuesta;
}

}
?>
