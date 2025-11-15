<?php

class Copia
{

    function __construct()
    {
        require_once('conexion.php');
        $this->conexion = new Conexion();
    }

    function obtenerIdLibroIsbn($isbn)
    {
        $consulta = "SELECT pkLibro FROM libro WHERE isbn = '{$isbn}'";
         
        $resultado = $this->conexion->query($consulta);
        if ($fila = $resultado->fetch_assoc()) {
            return $fila['pkLibro'];
        } // validar que exista el libro -_-
        return null;
    }

    function guardar($isbn, $fkEstanteria)
    {
        $fkLibro = $this->obtenerIdLibroIsbn($isbn);
        $folio = $this->generarFolio();
        if (!$fkLibro) {
            // ISBN no existe
            return false;
        }
        $consulta = "INSERT INTO copiaF (folio, fkLibro, fkEstanteria, fechaAdquisicion)
                     VALUES ('{$folio}', '{$fkLibro}', '{$fkEstanteria}', NOW())";
        return $this->conexion->query($consulta);
    }
    function generarFolio()
    {
        // Prefijo: Es la parte que se mantendra igual en todos los numCredenciales
        $prefijo = "CF-";
        // Se consulta el ultimo número que se registro, LIKE(busca los registros que se paresca al dato siguiente. $prefijo%(%se usa para indicar que solo busque registros que inicien con lo que se indica, en este caso OW-)
        //ORDER BY numCredencial DESC LIMIT 1: busca el ultimo registro, o sea el más alto, y con LIMIT 1 se indica que solo se quiere ese
        $consulta = "SELECT folio FROM copiaF WHERE folio LIKE '{$prefijo}%' ORDER BY folio DESC LIMIT 1";
        $resultado = $this->conexion->query($consulta);
        if ($fila = $resultado->fetch_assoc()) {
            // Se usa para extraer, por ejemplo: de OW-000012, "000012" y convertirlo a numero
            $ultimoFolio = intval(substr($fila['folio'], strlen($prefijo)));
            $nuevoFolio = $ultimoFolio + 1; //Al ultimo número se le aumenta 1 para que se cree el nuevo numero que ira despues del prefijo
        } else {
            //Si no hay registros, pues se empieza con 1
            $nuevoFolio = 1;
        }
        // Como se ocupan x cantidad de digitos, pues con esto llena lo que sobre con 0
        $folio = $prefijo . str_pad($nuevoFolio, 6, "0", STR_PAD_LEFT);
        return $folio;
    }

    function lista()
    {
        $consulta = "
        SELECT 
            c.*
            l.isbn,
            l.titulo,
            s.nombreSubCategoria,
            e.codigoEstanteria
        FROM copiaF c
        INNER JOIN libro l ON c.fkLibro = l.pkLibro
        INNER JOIN subCategoria s ON l.fkSubCategoria = s.pkSubCategoria
        INNER JOIN estanteria e ON c.fkEstanteria = e.pkEstanteria
        WHERE c.estatus = 'A'
        ORDER BY c.pkCopiaF ASC
    ";
        $resultado = $this->conexion->query($consulta);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }
    
    function filtrar($buscar = '', $subcategoria = '', $estatus = '') {
    $consulta = "SELECT c.*, 
           sb.nombreSubCategoria,
           e.codigoEstanteria,
           l.isbn, l.titulo
    FROM copiaF c
    INNER JOIN estanteria e ON e.pkEstanteria = c.fkEstanteria
    INNER JOIN libro l ON c.fkLibro = l.pkLibro
    INNER JOIN subCategoria sb ON l.fkSubCategoria=sb.pkSubCategoria
    WHERE 1=1";

    if (!empty($buscar)) {
        $buscar = mysqli_real_escape_string($this->conexion, $buscar);
        $consulta .= " AND (c.folio LIKE '%$buscar%' 
                    OR l.titulo LIKE '%$buscar%' 
                    OR e.codigoEstanteria LIKE '%$buscar%' 
                    OR l.isbn LIKE '%$buscar%')";
    }

    if (!empty($subcategoria)) {
        $subcategoria = mysqli_real_escape_string($this->conexion, $subcategoria);
        $consulta .= " AND sb.pkSubCategoria = '$subcategoria'";
    }

    if (!empty($estatus)) {
        $estatus = mysqli_real_escape_string($this->conexion, $estatus);
        $consulta .= " AND c.estatus = '$estatus'";
    } else {
        // Si no se elige estatus, por defecto muestra los activos
        $consulta .= " AND c.estatus = 'A'";
    }

    $resultado = mysqli_query($this->conexion, $consulta);
    return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
}


}
