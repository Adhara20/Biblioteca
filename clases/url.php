<?php
class URL {
    private $conexion;

    function __construct() {
        require_once(__DIR__ . "/conexion.php");
        $this->conexion = new Conexion();
    }

    // Guardar nueva URL
    function guardar($url, $fkLibro) {
        // Si fkLibro es vacío, poner NULL
        // $fkLibroVal = !empty($fkLibro) ? "'$fkLibro'" : "NULL";
        $consulta = "INSERT INTO url (url, fkLibro) VALUES ('{$url}', '{$fkLibro}')";
        return $this->conexion->query($consulta);
    }

    // Obtener lista de URLs
    function listaURLs() {
        $consulta = "
            SELECT u.pkURL, u.url, u.estatus, l.titulo 
            FROM url u
            LEFT JOIN libro l ON u.fkLibro = l.pkLibro
            ORDER BY u.pkURL DESC
        ";
        $resultado = $this->conexion->query($consulta);

        $urls = [];
        if ($resultado) {
            while ($fila = $resultado->fetch_assoc()) {
                if (empty($fila['titulo'])) $fila['titulo'] = "Sin libro";
                $urls[] = $fila;
            }
        }
        return $urls;
    }

    // Desactivar URL
    function desactivar($pkURL) {
        $consulta = "UPDATE url SET estatus = 'I' WHERE pkURL = '{$pkURL}'";
        return $this->conexion->query($consulta);
    }

    // Activar URL
    function activar($pkURL) {
        $consulta = "UPDATE url SET estatus = 'A' WHERE pkURL = '{$pkURL}'";
        return $this->conexion->query($consulta);
    }

    // Detalles de una URL
    function detalles($pkURL) {
        $consulta = "
            SELECT u.pkURL, u.url, u.fkLibro, u.estatus, l.titulo AS nombreLibro
            FROM url u
            LEFT JOIN libro l ON u.fkLibro = l.pkLibro
            WHERE u.pkURL = '{$pkURL}'
        ";
        $resultado = $this->conexion->query($consulta);
        return $resultado;
    }

    // Filtar URLS de un libro
    function filtrarPorLibro($pkLibro, $buscar = '', $estatus = '') {
    $pkLibro = intval($pkLibro);

    $consulta = "
        SELECT u.pkUrl, u.url, u.estatus, l.titulo FROM url u 
        INNER JOIN libro l ON u.fkLibro = l.pkLibro
        WHERE u.fkLibro = '{$pkLibro}'
    ";

    if (!empty($buscar)) {
        $buscar = mysqli_real_escape_string($this->conexion, $buscar);
        $consulta .= " AND l.titulo LIKE '%$buscar%'";
    }

    if (!empty($estatus)) {
        $estatus = mysqli_real_escape_string($this->conexion, $estatus);
        $consulta .= " AND u.estatus = '$estatus'";
    }

    $resultado = mysqli_query($this->conexion, $consulta);
    return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
}


    // Filtrar general
    function filtrar($buscar = '', $estatus = '', $libro = '') {
        $consulta = "SELECT u.*, l.titulo
                     FROM url u
                     INNER JOIN libro l ON u.fkLibro = l.pkLibro
                     WHERE 1 = 1";

        if (!empty($buscar)) {
            $buscar = mysqli_real_escape_string($this->conexion, $buscar);
            $consulta .= " AND (l.titulo LIKE '%$buscar%')";
        }

        if (!empty($estatus)) {
            $estatus = mysqli_real_escape_string($this->conexion, $estatus);
            $consulta .= " AND u.estatus = '$estatus'";
        }

        if (!empty($tipo)) {
            $tipo = mysqli_real_escape_string($this->conexion, $tipo);
            $consulta .= " AND u.tipo = '$tipo'";
        }

        $resultado = mysqli_query($this->conexion, $consulta);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        }


}
?>
