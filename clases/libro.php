<?php
class Libro {
    private $conexion;
    function __construct() {
        // Cambien su ruta de coexión por esta ruta absoluta para evitar errores:
        require_once(__DIR__ . "/conexion.php");
        $this->conexion = new Conexion();
    }
    function guardar($isbn, $titulo, $edicion, $numPaginas, $anioPublicacion, $idioma, $sinopsis, $fkAutor, $fkEditorial, $fkSubCategoria, $portadaNombre) {
    $consulta = "INSERT INTO libro 
        (isbn, titulo, edicion, numPaginas, anioPublicacion, idioma, sinopsis, fkAutor, fkEditorial, fkSubCategoria, portada, fechaRegistro)
        VALUES ('{$isbn}','{$titulo}','{$edicion}',{$numPaginas},'{$anioPublicacion}','{$idioma}','{$sinopsis}',{$fkAutor}, 
            {$fkEditorial},{$fkSubCategoria},'{$portadaNombre}', NOW())";
    $resultado = $this->conexion->query($consulta);
    return $resultado;
    }
    function desactivar($pkLibro) {
        $consulta = "UPDATE libro 
                     SET estatus = 'I' 
                     WHERE pkLibro = '{$pkLibro}'";
        $resultado = $this->conexion->query($consulta);
        return $resultado;
    }

    function activar($pkLibro) {
        $consulta = "UPDATE libro 
                     SET estatus = 'A' 
                     WHERE pkLibro = '{$pkLibro}'";
        $resultado = $this->conexion->query($consulta);
        return $resultado;
    }
    
    function verLibro($pkLibro) {
        $consulta = "SELECT * FROM libro 
                     WHERE pkLibro = '$pkLibro'";
        $resultado = $this->conexion->query($consulta);
        return $resultado;
    }
    function detalles($pkLibro) {
    $consulta = "
        SELECT l.*, a.nombreAutor, e.nombreEditorial, s.nombreSubCategoria, c.nombreCategoria FROM libro l INNER JOIN autor a ON l.fkAutor = a.pkAutor INNER JOIN editorial e ON l.fkEditorial = e.pkEditorial INNER JOIN subcategoria s ON l.fkSubCategoria = s.pkSubCategoria INNER JOIN categoria c ON s.fkCategoria=c.pkCategoria WHERE l.pkLibro = '{$pkLibro}'";
    $respuesta = $this->conexion->query($consulta);
    return $respuesta;
}
    function filtrar($buscar = '', $categoria = '', $estatus = '') {
    $consulta = "SELECT l.*, 
           a.nombreAutor, 
           e.nombreEditorial, 
           c.nombreCategoria, 
           sc.nombreSubCategoria
    FROM libro l
    INNER JOIN autor a ON l.fkAutor = a.pkAutor
    INNER JOIN editorial e ON l.fkEditorial = e.pkEditorial
    INNER JOIN subCategoria sc ON l.fkSubCategoria = sc.pkSubCategoria
    INNER JOIN categoria c ON sc.fkCategoria = c.pkCategoria
    WHERE 1=1";

    if (!empty($buscar)) {
        $buscar = mysqli_real_escape_string($this->conexion, $buscar);
        $consulta .= " AND (l.titulo LIKE '%$buscar%' 
                    OR a.nombreAutor LIKE '%$buscar%' 
                    OR l.isbn LIKE '%$buscar%')";
    }

    if (!empty($categoria)) {
        $categoria = mysqli_real_escape_string($this->conexion, $categoria);
        $consulta .= " AND c.pkCategoria = '$categoria'";
    }

    if (!empty($estatus)) {
        $estatus = mysqli_real_escape_string($this->conexion, $estatus);
        $consulta .= " AND l.estatus = '$estatus'";
    } else {
        // Si no se elige estatus, por defecto muestra los activos
        $consulta .= " AND l.estatus = 'A'";
    }

    $resultado = mysqli_query($this->conexion, $consulta);
    return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
}
    function actualizar($pkLibro, $isbn, $titulo, $edicion, $numPaginas, $anioPublicacion, $idioma, $sinopsis, $fkAutor, $fkEditorial, $fkSubcategoria, $portada) {
    $consulta = "UPDATE libro SET 
        isbn = '{$isbn}',
        titulo = '{$titulo}',
        edicion = '{$edicion}',
        numPaginas = {$numPaginas},
        anioPublicacion = '{$anioPublicacion}',
        idioma = '{$idioma}',
        sinopsis = '{$sinopsis}',
        fkAutor = {$fkAutor},
        fkEditorial = {$fkEditorial},
        fkSubCategoria = {$fkSubcategoria},
        portada = '{$portada}'
        WHERE pkLibro = {$pkLibro}";
    $resultado = $this->conexion->query($consulta);
    return $resultado;
    }
    // Ingoren esto
// Para guardar
    function existeISBN($isbn) {
    $consulta = "SELECT * FROM libro WHERE isbn = '{$isbn}'";
    $resultado = $this->conexion->query($consulta);
    return ($resultado->num_rows > 0);
    }   
    // Para actualizar
    function existeISBNActualizar($isbn, $pkLibro) {
    $sql = "SELECT * FROM libro WHERE isbn='$isbn' AND pkLibro != $pkLibro";
    $result = $this->conexion->query($sql);
    return $result->num_rows > 0;
    }




}
?>
