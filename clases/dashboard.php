<?php
class Dashboard {

    private $conexion;

    public function __construct() {
        require_once('conexion.php');
        $this->conexion = new Conexion(); // Igual que tus otras clases
    }

    // Total libros activos
    public function totalLibros() {
        return $this->obtenerValor("SELECT COUNT(*) AS total FROM libro WHERE estatus = 'A'");
    }

    // Total copias
    public function totalCopias() {
        return $this->obtenerValor("SELECT COUNT(*) AS total FROM copiaF");
    }

    // Total autores activos
    public function totalAutores() {
        return $this->obtenerValor("SELECT COUNT(*) AS total FROM autor WHERE estatus = 'A'");
    }

    // Total usuarios activos
    public function totalUsuarios() {
        return $this->obtenerValor("SELECT COUNT(*) AS total FROM usuario WHERE estatus = 'A'");
    }

    // Total categorías activas
    public function totalCategorias() {
        return $this->obtenerValor("SELECT COUNT(*) AS total FROM categoria WHERE estatus = 'A'");
    }

    // Total subcategorías activas
    public function totalSubcategorias() {
        return $this->obtenerValor("SELECT COUNT(*) AS total FROM subcategoria WHERE estatus = 'A'");
    }

    // Total editoriales activas
    public function totalEditoriales() {
        return $this->obtenerValor("SELECT COUNT(*) AS total FROM editorial WHERE estatus = 'A'");
    }

    // Total multas activas
    public function totalMultas() {
        return $this->obtenerValor("SELECT COUNT(*) AS total FROM multa WHERE estatus = 'A'");
    }

    // Total préstamos en proceso
    public function totalPrestamos() {
        return $this->obtenerValor("SELECT COUNT(*) AS total FROM prestamo WHERE estatus = 'EnProceso'");
    }

    // Total nacionalidades activas
    public function totalNacionalidades() {
        return $this->obtenerValor("SELECT COUNT(*) AS total FROM nacionalidad WHERE estatus = 'A'");
    }

    // ⭐ Libros más prestados
    public function librosMasPrestados($limite = 5) {
        $limite = (int)$limite;
        if ($limite <= 0) $limite = 5;

        $sql = "
            SELECT 
                l.pkLibro,
                l.titulo,
                COUNT(p.pkPrestamo) AS totalPrestamos
            FROM prestamo p
            INNER JOIN copiaF c ON p.fkCopiaF = c.pkCopiaF
            INNER JOIN libro l ON c.fkLibro = l.pkLibro
            GROUP BY l.pkLibro, l.titulo
            ORDER BY totalPrestamos DESC
            LIMIT {$limite}
        ";

        $result = $this->conexion->query($sql);
        $lista = [];

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $row['totalPrestamos'] = (int)$row['totalPrestamos'];
                $lista[] = $row;
            }
        }

        return $lista;
    }

    // --- Helper ---
    private function obtenerValor($sql) {
        $result = $this->conexion->query($sql);
        if ($result && $row = $result->fetch_assoc()) {
            return (int)$row['total'];
        }
        return 0;
    }
}
