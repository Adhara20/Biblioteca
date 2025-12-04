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
        }
        return null;
    }

    function guardar($isbn, $observaciones)
    {
        $fkLibro = $this->obtenerIdLibroIsbn($isbn);
        $folio = $this->generarFolio();

        if (!$fkLibro) {
            return false; // ISBN no existe
        }

        // YA NO SE USA fkEstanteria
        $consulta = "INSERT INTO copiaF (folio, fkLibro, observaciones, fechaAdquisicion)
                     VALUES ('{$folio}', '{$fkLibro}', '{$observaciones}',NOW())";

        return $this->conexion->query($consulta);
    }

    function generarFolio()
    {
        $prefijo = "CF-";
        $consulta = "SELECT folio FROM copiaF WHERE folio LIKE '{$prefijo}%' 
                     ORDER BY folio DESC LIMIT 1";

        $resultado = $this->conexion->query($consulta);

        if ($fila = $resultado->fetch_assoc()) {
            $ultimoFolio = intval(substr($fila['folio'], strlen($prefijo)));
            $nuevoFolio = $ultimoFolio + 1;
        } else {
            $nuevoFolio = 1;
        }

        $folio = $prefijo . str_pad($nuevoFolio, 6, "0", STR_PAD_LEFT);
        return $folio;
    }

    function lista()
    {
        $consulta = "SELECT c.*,
                l.isbn,
                l.titulo,
                s.nombreSubCategoria
            FROM copiaF c
            INNER JOIN libro l ON c.fkLibro = l.pkLibro
            INNER JOIN subCategoria s ON l.fkSubCategoria = s.pkSubCategoria
            WHERE c.estatus = 'A'
            ORDER BY c.pkCopiaF ASC
        ";

        $resultado = $this->conexion->query($consulta);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    function detalles($pkCopiaF) {
        $consulta = "SELECT c.*, 
                sb.nombreSubCategoria,
                l.isbn, l.titulo, l.portada
            FROM copiaF c
            INNER JOIN libro l ON c.fkLibro = l.pkLibro
            INNER JOIN subCategoria sb ON l.fkSubCategoria = sb.pkSubCategoria
            WHERE c.pkCopiaF = '{$pkCopiaF}'
        ";

        return $this->conexion->query($consulta);
    }

    function desactivar($pkCopiaF) {
        $consulta = "UPDATE copiaF 
                     SET estatus = 'I' 
                     WHERE pkCopiaF = '{$pkCopiaF}'";

        return $this->conexion->query($consulta);
    }

    function activar($pkCopiaF) {
        $consulta = "UPDATE copiaF 
                     SET estatus = 'A' 
                     WHERE pkCopiaF = '{$pkCopiaF}'";

        return $this->conexion->query($consulta);
    }

    function actualizar($pkCopiaF, $isbn, $observaciones) {
    $fkLibro = $this->obtenerIdLibroIsbn($isbn);

    if (!$fkLibro) {
        return false; // ISBN no existe
    }

    $consulta = "UPDATE copiaF 
                 SET fkLibro = '{$fkLibro}', observaciones = '{$observaciones}'
                 WHERE pkCopiaF = '{$pkCopiaF}'";

    return $this->conexion->query($consulta);
    return $resultado;
    }

    function filtrar($buscar = '', $subcategoria = '', $estatus = '') 
    {
        $consulta = "SELECT c.*, 
                sb.nombreSubCategoria,
                l.isbn, 
                l.titulo, 
                l.portada
            FROM copiaF c
            INNER JOIN libro l ON c.fkLibro = l.pkLibro
            INNER JOIN subCategoria sb ON l.fkSubCategoria = sb.pkSubCategoria";

        if (!empty($buscar)) {
            $buscar = mysqli_real_escape_string($this->conexion, $buscar);
            $consulta .= " AND (c.folio LIKE '%$buscar%' 
                            OR l.titulo LIKE '%$buscar%' 
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
            $consulta .= " AND c.estatus = 'A'";
        }

        $resultado = mysqli_query($this->conexion, $consulta);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    }

    function mostrar(){
    $consulta = "SELECT pkCopiaF, folio FROM copiaf WHERE estatus = 'A' && disponibilidad = 'Disponible'";
    $resultado = $this->conexion->query($consulta);
    return $resultado;
}
// ends here
}

?>
