<?php
class Multa
{
    private $conexion;

    function __construct()
    {
        require_once("conexion.php");
        $this->conexion = new Conexion();
    }

    function registrarMulta($tipoMulta, $montoMulta, $fechaRegistro, $fechaPago, $fkPrestamo)
    {
        $codigoMulta = $this->generarCodigoMulta();

        $consulta = "INSERT INTO multa 
             (codigoMulta, tipoMulta, montoMulta, fechaRegistro, fechaPago, fkPrestamo, estatus)
             VALUES 
             ('{$codigoMulta}', '{$tipoMulta}', '{$montoMulta}', '{$fechaRegistro}', '{$fechaPago}', '{$fkPrestamo}', 'P')";


        $resultado = $this->conexion->query($consulta);
        return $resultado;
    }
    function cambiarEstatusMulta($pkMulta, $nuevoEstatus)
    {

        if ($nuevoEstatus != 'A' && $nuevoEstatus != 'P') {
            return false;
        }

        $consulta = "UPDATE multa 
                 SET estatus = '$nuevoEstatus' 
                 WHERE pkMulta = '$pkMulta'";

        $resultado = $this->conexion->query($consulta);
        return $resultado;
    }
    function verMulta($pkMulta)
    {
        $consulta = "SELECT * FROM multa 
                 WHERE pkMulta = '$pkMulta'";
        $resultado = $this->conexion->query($consulta);
        return $resultado;
    }
    function listaMultas() {
    $consulta = "
        SELECT m.pkMulta, m.codigoMulta, m.tipoMulta, m.montoMulta, m.fechaRegistro, m.fechaPago, m.fkPrestamo, u.nombres AS usuarioSolicita
        FROM multa m
        INNER JOIN prestamo p ON m.fkPrestamo = p.pkPrestamo
        INNER JOIN usuario u ON p.fkUsuarioSolicita = u.pkUsuario
    ";

    $resultado = $this->conexion->query($consulta);

    $multas = [];
    while ($fila = $resultado->fetch_assoc()) {
        $multas[] = $fila;
    }

    return $multas;
}
    function generarCodigoMulta()
    {
        $prefijo = "M-";

        $consulta = "SELECT codigoMulta FROM multa WHERE codigoMulta LIKE '{$prefijo}%' ORDER BY codigoMulta DESC  LIMIT 1";
        $resultado = $this->conexion->query($consulta);
        if ($fila = $resultado->fetch_assoc()) {

            $ultimoNumero = intval(substr($fila['codigoMulta'], strlen($prefijo)));
            $nuevoNumero = $ultimoNumero + 1;
        } else {

            $nuevoNumero = 1;
        }


        $codigoMulta = $prefijo . str_pad($nuevoNumero, 6, "0", STR_PAD_LEFT);

        return $codigoMulta;
    }
    function buscarMulta($busqueda) {
    $consulta = "
        SELECT 
            m.pkMulta,
            m.codigoMulta,
            m.tipoMulta,
            m.montoMulta,
            m.fechaRegistro,
            m.fechaPago,
            m.fkPrestamo,
            u.nombres AS usuarioSolicita
        FROM multa m
        INNER JOIN prestamo p ON m.fkPrestamo = p.pkPrestamo
        INNER JOIN usuario u ON p.fkUsuarioSolicita = u.pkUsuario
        WHERE 
            m.codigoMulta LIKE '%{$busqueda}%' 
            OR m.tipoMulta LIKE '%{$busqueda}%'
            OR u.nombres LIKE '%{$busqueda}%'
    ";

    return $this->conexion->query($consulta);
}

}
