<?php
    class Editorial {
    private $conexion;
    function __construct() {
        require_once("conexion.php");
        $this->conexion = new Conexion();
    }

    function guardar($nombreEditorial, $fkNacionalidad) {
        $consulta = "INSERT INTO editorial (nombreEditorial, fkNacionalidad)
                     VALUES ('{$nombreEditorial}', '{$fkNacionalidad}')";
        return $this->conexion->query($consulta);
    }

    function darBajaEditorial($pkEditorial) {
        $consulta = "UPDATE editorial 
                     SET estatus = 'I' 
                     WHERE pkEditorial = '{$pkEditorial}'";
        return $this->conexion->query($consulta);
    }

    function verEditorial() {
        $consulta = "SELECT e.pkEditorial, e.nombreEditorial, n.nombre AS nacionalidad
                     FROM editorial e
                     INNER JOIN nacionalidad n ON e.fkNacionalidad = n.pkNacionalidad
                     WHERE e.estatus = 'A'";

        $resultado = $this->conexion->query($consulta);

        $editoriales = [];
        while ($fila = $resultado->fetch_assoc()) {
            $editoriales[] = $fila;
        }

        return $editoriales;
    }

    function listaEditoriales() {
        $consulta = "SELECT e.pkEditorial, e.nombreEditorial, n.nombreNaci AS nacionalidad, e.estatus
                     FROM editorial e
                     INNER JOIN nacionalidad n ON e.fkNacionalidad = n.pkNacionalidad";

        $resultado = $this->conexion->query($consulta);

        $editoriales = [];
        while ($fila = $resultado->fetch_assoc()) {
            $editoriales[] = $fila;
        }

        return $editoriales;
    }
}
?>
