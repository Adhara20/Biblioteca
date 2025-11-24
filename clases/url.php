<?php
class URL {
    private $conexion;

    function __construct() {
        require_once(__DIR__ . "/conexion.php");
        $this->conexion = new Conexion();
    }

    // Guardar nueva URL
    function guardar($url, $fkLibro = null) {
        // Si fkLibro es vacío, poner NULL
        $fkLibroVal = !empty($fkLibro) ? "'$fkLibro'" : "NULL";
        $consulta = "INSERT INTO url (url, fkLibro, estatus) VALUES ('$url', $fkLibroVal, 'A')";
        return $this->conexion->query($consulta);
    }

    // Obtener lista de URLs
    function listaURLs() {
        $consulta = "
            SELECT u.pkURL, u.url, u.estatus, l.titulo AS nombreLibro
            FROM url u
            LEFT JOIN libro l ON u.fkLibro = l.pkLibro
            ORDER BY u.pkURL DESC
        ";
        $resultado = $this->conexion->query($consulta);

        $urls = [];
        if ($resultado) {
            while ($fila = $resultado->fetch_assoc()) {
                if (empty($fila['nombreLibro'])) $fila['nombreLibro'] = "Sin libro";
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
}
?>
