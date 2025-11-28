<?php
class Nacionalidad {
    private $conexion;

    function __construct() {
        require_once(__DIR__ . "/conexion.php");
        $this->conexion = new Conexion();
    }

    // Guardar nueva nacionalidad
    function guardar($nombreNaci) {
        $nombreNaci = mysqli_real_escape_string($this->conexion, strtoupper($nombreNaci));
        
        // Si tu tabla no tiene fechaRegistro, usa este INSERT
        $consulta = "INSERT INTO nacionalidad (nombreNaci, estatus) 
                     VALUES ('$nombreNaci', 'A')";
                     
        // Si quieres agregar fechaRegistro en la BD, usa este en su lugar:
        // $consulta = "INSERT INTO nacionalidad (nombreNaci, estatus, fechaRegistro) VALUES ('$nombreNaci', 'A', NOW())";
        
        return $this->conexion->query($consulta);
    }

    // Desactivar
    function desactivar($pkNacionalidad) {
        $consulta = "UPDATE nacionalidad SET estatus = 'I' 
                     WHERE pkNacionalidad = '{$pkNacionalidad}'";
        return $this->conexion->query($consulta);
    }

    // Activar
    function activar($pkNacionalidad) {
        $consulta = "UPDATE nacionalidad SET estatus = 'A' 
                     WHERE pkNacionalidad = '{$pkNacionalidad}'";
        return $this->conexion->query($consulta);
    }

    // Ver nacionalidad específica
    function verNacionalidad($pkNacionalidad) {
        $consulta = "SELECT * FROM nacionalidad WHERE pkNacionalidad = '{$pkNacionalidad}'";
        return $this->conexion->query($consulta);
    }

    // Detalles
    function detalles($pkNacionalidad) {
        return $this->verNacionalidad($pkNacionalidad);
    }

    // Filtrar por nombre y estatus
    function filtrar($buscar = '', $estatus = '') {
        $consulta = "SELECT * FROM nacionalidad WHERE 1=1";

        if (!empty($buscar)) {
            $buscar = mysqli_real_escape_string($this->conexion, $buscar);
            $consulta .= " AND nombreNaci LIKE '%$buscar%'";
        }

        if ($estatus === 'A' || $estatus === 'I') {
            $consulta .= " AND estatus = '$estatus'";
        } else {
            $consulta .= " AND estatus = 'A'";
        }

        $consulta .= " ORDER BY nombreNaci ASC";
        return $this->conexion->query($consulta);
    }

    // Actualizar nombre
    function actualizar($pkNacionalidad, $nombreNaci) {
        $nombreNaci = mysqli_real_escape_string($this->conexion, strtoupper($nombreNaci));
        $consulta = "UPDATE nacionalidad SET nombreNaci = '{$nombreNaci}' 
                     WHERE pkNacionalidad = '{$pkNacionalidad}'";
        return $this->conexion->query($consulta);
    }

    // Validar si existe nombre
    function existeNombre($nombreNaci) {
        $nombreNaci = mysqli_real_escape_string($this->conexion, strtoupper($nombreNaci));
        $consulta = "SELECT * FROM nacionalidad WHERE nombreNaci = '{$nombreNaci}'";
        $resultado = $this->conexion->query($consulta);
        return ($resultado->num_rows > 0);
    }

    // Validar si existe nombre para actualizar
    function existeNombreActualizar($nombreNaci, $pkNacionalidad) {
        $nombreNaci = mysqli_real_escape_string($this->conexion, strtoupper($nombreNaci));
        $consulta = "SELECT * FROM nacionalidad 
                     WHERE nombreNaci = '{$nombreNaci}' AND pkNacionalidad != {$pkNacionalidad}";
        $resultado = $this->conexion->query($consulta);
        return ($resultado->num_rows > 0);
    }

    // Lista todas las nacionalidades (opcional por estatus)
    function listaNacionalidades($estatus = '') {
        $consulta = "SELECT * FROM nacionalidad WHERE 1=1";
        if ($estatus === 'A' || $estatus === 'I') {
            $consulta .= " AND estatus = '$estatus'";
        }
        $consulta .= " ORDER BY nombreNaci ASC";
        return $this->conexion->query($consulta);
    }
}
?>

