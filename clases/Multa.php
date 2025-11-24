<?php
class Multa {
    private $conexion;

    function __construct() {
        require_once('Conexion.php');
        $this->conexion = new Conexion();
    }

    // Listar todas las multas
    function listar() {
        $consulta = "SELECT m.*, p.codigoPrestamo, p.fechaRegistro AS fechaPrestamo
                     FROM multa m
                     INNER JOIN prestamo p ON m.fkPrestamo = p.pkPrestamo
                     ORDER BY m.pkMulta DESC";

        $resultado = $this->conexion->query($consulta);
        return $resultado ? $resultado->fetch_all(MYSQLI_ASSOC) : [];
    }

    // Alias para compatibilidad con vistas
    function listaMultas() {
        return $this->listar();
    }

    // Filtrar multas según criterios
    function filtrar($buscar = '', $tipo = '', $estatus = '') {
        $consulta = "SELECT m.*, p.codigoPrestamo, p.fechaRegistro AS fechaPrestamo
                     FROM multa m
                     INNER JOIN prestamo p ON m.fkPrestamo = p.pkPrestamo
                     WHERE 1=1";

        if ($buscar !== '') {
            $buscar = mysqli_real_escape_string($this->conexion, $buscar);
            $consulta .= " AND (m.codigoMulta LIKE '%$buscar%' OR p.codigoPrestamo LIKE '%$buscar%')";
        }

        if ($tipo !== '') {
            $tipo = mysqli_real_escape_string($this->conexion, $tipo);
            $consulta .= " AND m.tipoMulta = '$tipo'";
        }

        if ($estatus !== '') {
            $estatus = mysqli_real_escape_string($this->conexion, $estatus);
            $consulta .= " AND m.estatus = '$estatus'";
        }

        $consulta .= " ORDER BY m.pkMulta DESC";

        $resultado = $this->conexion->query($consulta);
        return $resultado ? $resultado->fetch_all(MYSQLI_ASSOC) : [];
    }

    // Detalles de una multa
    function detalles($pkMulta) {
        $pkMulta = intval($pkMulta);
        $consulta = "SELECT m.*, p.codigoPrestamo, p.fechaRegistro AS fechaPrestamo
                     FROM multa m
                     INNER JOIN prestamo p ON m.fkPrestamo = p.pkPrestamo
                     WHERE m.pkMulta = $pkMulta
                     LIMIT 1";

        $resultado = $this->conexion->query($consulta);
        return $resultado;
    }

    // Actualizar multa
    function actualizar($pkMulta, $codigoMulta, $tipoMulta, $montoMulta, $fechaPago, $fkPrestamo, $estatus) {
        $pkMulta = intval($pkMulta);
        $fkPrestamo = intval($fkPrestamo);
        $codigoMulta = mysqli_real_escape_string($this->conexion, strtoupper($codigoMulta));
        $tipoMulta = mysqli_real_escape_string($this->conexion, $tipoMulta);
        $montoMulta = floatval($montoMulta);
        $fechaPago = $fechaPago ? "'$fechaPago'" : "NULL";
        $estatus = mysqli_real_escape_string($this->conexion, $estatus);

        $consulta = "UPDATE multa SET 
                        codigoMulta = '$codigoMulta',
                        tipoMulta = '$tipoMulta',
                        montoMulta = $montoMulta,
                        fechaPago = $fechaPago,
                        fkPrestamo = $fkPrestamo,
                        estatus = '$estatus'
                     WHERE pkMulta = $pkMulta";

        return $this->conexion->query($consulta);
    }

    // Activar multa
    function activar($pkMulta) {
        $pkMulta = intval($pkMulta);
        $consulta = "UPDATE multa SET estatus = 'A' WHERE pkMulta = $pkMulta";
        return $this->conexion->query($consulta);
    }

    // Desactivar multa
    function desactivar($pkMulta) {
        $pkMulta = intval($pkMulta);
        $consulta = "UPDATE multa SET estatus = 'P' WHERE pkMulta = $pkMulta";
        return $this->conexion->query($consulta);
    }
    // Insertar nueva multa
function insertar($tipoMulta, $montoMulta, $fechaRegistro, $fechaPago, $fkPrestamo) {

    $tipoMulta = mysqli_real_escape_string($this->conexion, $tipoMulta);
    $montoMulta = floatval($montoMulta);
    $fkPrestamo = intval($fkPrestamo);

    // Fecha de pago puede ser NULL
    $fechaPagoSQL = ($fechaPago != "" && $fechaPago != null) ? "'$fechaPago'" : "NULL";

    // Generar código de multa (algo como M4592)
    $codigoMulta = "M" . rand(1000, 9999);

    $consulta = "INSERT INTO multa (codigoMulta, tipoMulta, montoMulta, fechaRegistro, fechaPago, fkPrestamo, estatus)
                 VALUES ('$codigoMulta', '$tipoMulta', $montoMulta, '$fechaRegistro', $fechaPagoSQL, $fkPrestamo, 'A')";

    return $this->conexion->query($consulta);
}

}
?>


