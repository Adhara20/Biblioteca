<?php
class Libro {
    private $conexion;
    function __construct() {
        // Cambien su ruta de coexión por esta ruta absoluta para evitar errores:
        require_once(__DIR__ . "/conexion.php");
        $this->conexion = new Conexion();
    }
    function guardar($isbn, $titulo, $edicion, $numPaginas, $anioPublicacion, $fkIdioma, $sinopsis, $fkAutor, $fkEditorial, $fkSubCategoria, $portadaNombre) {
    $consulta = "INSERT INTO libro 
        (isbn, titulo, edicion, numPaginas, anioPublicacion, fkIdioma, sinopsis, fkAutor, fkEditorial, fkSubCategoria, portada, fechaRegistro)
        VALUES ('{$isbn}','{$titulo}','{$edicion}',{$numPaginas},'{$anioPublicacion}',{$fkIdioma},'{$sinopsis}',{$fkAutor}, 
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
    
    function verLibro() {
        $consulta = "SELECT pkLibro, titulo FROM libro WHERE estatus ='A'";
        $resultado = $this->conexion->query($consulta);
        return $resultado;
    }
    function detalles($pkLibro) {
    $consulta = "SELECT 
            l.*, 
            a.nombreAutor, 
            e.nombreEditorial, 
            s.nombreSubCategoria, 
            c.nombreCategoria,
            i.idioma
        FROM libro l
        INNER JOIN autor a 
            ON l.fkAutor = a.pkAutor
        INNER JOIN editorial e 
            ON l.fkEditorial = e.pkEditorial
        INNER JOIN subcategoria s 
            ON l.fkSubCategoria = s.pkSubCategoria
        INNER JOIN categoria c 
            ON s.fkCategoria = c.pkCategoria
        INNER JOIN idioma i
            ON l.fkIdioma = i.pkIdioma
        WHERE l.pkLibro = '{$pkLibro}'";

    $respuesta = $this->conexion->query($consulta);
    return $respuesta;
}

    function filtrar($buscar = '', $categoria = '', $idioma = '', $estatus = '') {
        $consulta = "SELECT 
                l.*, 
                a.nombreAutor, 
                e.nombreEditorial, 
                c.nombreCategoria, 
                sc.nombreSubCategoria,
                i.idioma
            FROM libro l
            INNER JOIN autor a ON l.fkAutor = a.pkAutor
            INNER JOIN editorial e ON l.fkEditorial = e.pkEditorial
            INNER JOIN subCategoria sc ON l.fkSubCategoria = sc.pkSubCategoria
            INNER JOIN categoria c ON sc.fkCategoria = c.pkCategoria
            INNER JOIN idioma i ON l.fkIdioma = i.pkIdioma
            WHERE 1=1";

        // BUSCAR
        if (!empty($buscar)) {
            $buscar = mysqli_real_escape_string($this->conexion, $buscar);
            $consulta .= " AND (
                    UPPER(l.titulo) LIKE '%$buscar%' 
                    OR UPPER(a.nombreAutor) LIKE '%$buscar%'
                    OR l.isbn LIKE '%$buscar%')";
        }

        // CATEGORIA
        if (!empty($categoria)) {
            $categoria = mysqli_real_escape_string($this->conexion, $categoria);
            $consulta .= " AND c.pkCategoria = '$categoria'";
        }

        // FILTRO IDIOMA (opcional)
        if (!empty($idioma)) {
            $idioma = mysqli_real_escape_string($this->conexion, $idioma);
            $consulta .= " AND i.pkIdioma = '$idioma'";
        }

        // ESTATUS
        if (!empty($estatus)) {
            $estatus = mysqli_real_escape_string($this->conexion, $estatus);
            $consulta .= " AND l.estatus = '$estatus'";
        } else {
            // Default: activos
            $consulta .= " AND l.estatus = 'A'";
        }

        $resultado = mysqli_query($this->conexion, $consulta);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    }

    function actualizar($pkLibro, $isbn, $titulo, $edicion, $numPaginas, $anioPublicacion, $fkIdioma, $sinopsis, $fkAutor, $fkEditorial, $fkSubcategoria, $portada) {

        $consulta = "UPDATE libro SET 
            isbn = '{$isbn}',
            titulo = '{$titulo}',
            edicion = '{$edicion}',
            numPaginas = {$numPaginas},
            anioPublicacion = '{$anioPublicacion}',
            fkIdioma = {$fkIdioma},
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
