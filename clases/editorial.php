<?php
class Editorial
{
    private $conexion;

    function __construct()
    {
        require_once("conexion.php");
        $this->conexion = new Conexion();
    }

    function guardar($nombreEditorial, $fkNacionalidad)
    {
        $consulta = "INSERT INTO editorial (nombreEditorial, fkNacionalidad, estatus)
                     VALUES ('{$nombreEditorial}', '{$fkNacionalidad}', 'A')";
        return $this->conexion->query($consulta);
    }


    function listaEditoriales()
    {
        $consulta = "SELECT 
                        e.pkEditorial,
                        e.nombreEditorial,
                        n.nombreNaci AS nacionalidad,
                        e.estatus
                     FROM editorial e
                     INNER JOIN nacionalidad n ON e.fkNacionalidad = n.pkNacionalidad";

        $resultado = $this->conexion->query($consulta);

        $editoriales = [];
        while ($fila = $resultado->fetch_assoc()) {
            $editoriales[] = $fila;
        }
        return $editoriales;
    }

    function detalles($pkEditorial)
    {
        $consulta = "SELECT 
                        e.pkEditorial,
                        e.nombreEditorial,
                        e.fkNacionalidad,
                        e.estatus,
                        n.nombreNaci AS nacionalidad
                     FROM editorial e
                     INNER JOIN nacionalidad n ON e.fkNacionalidad = n.pkNacionalidad
                     WHERE e.pkEditorial = '{$pkEditorial}'";

        return $this->conexion->query($consulta);
    }

    
    function actualizar($pkEditorial, $nombreEditorial, $fkNacionalidad)
    {
        $consulta = "UPDATE editorial
                     SET nombreEditorial = '{$nombreEditorial}',
                         fkNacionalidad = '{$fkNacionalidad}'
                     WHERE pkEditorial = '{$pkEditorial}'";

        return $this->conexion->query($consulta);
    }


    function desactivar($pkEditorial)
    {
        $consulta = "UPDATE editorial
                     SET estatus = 'I'
                     WHERE pkEditorial = '{$pkEditorial}'";

        return $this->conexion->query($consulta);
    }

    
    function activar($pkEditorial)
    {
        $consulta = "UPDATE editorial
                     SET estatus = 'A'
                     WHERE pkEditorial = '{$pkEditorial}'";

        return $this->conexion->query($consulta);
    }

  
    function filtrar($buscar = '', $estatus = '')
    {
        $consulta = "SELECT 
                        e.pkEditorial,
                        e.nombreEditorial,
                        n.nombreNaci AS nacionalidad,
                        e.estatus
                     FROM editorial e
                     INNER JOIN nacionalidad n ON e.fkNacionalidad = n.pkNacionalidad
                     WHERE 1=1";

        // filtro texto
        if (!empty($buscar)) {
            $buscar = mysqli_real_escape_string($this->conexion, $buscar);
            $consulta .= " AND e.nombreEditorial LIKE '%$buscar%'";
        }

        // filtro estatus
        if (!empty($estatus)) {
            $estatus = mysqli_real_escape_string($this->conexion, $estatus);
            $consulta .= " AND e.estatus = '$estatus'";
        } else {
            // por defecto → solo activos
            $consulta .= " AND e.estatus = 'A'";
        }

        $resultado = mysqli_query($this->conexion, $consulta);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    }
}
?>
