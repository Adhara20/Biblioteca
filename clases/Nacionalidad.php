<?php
class Nacionalidad
{
    private $conexion;

    function __construct()
    {
        require_once("conexion.php");
        $this->conexion = new Conexion();
    }

    function guardar($nombreNaci)
    {
        $consulta = "INSERT INTO nacionalidad (nombreNaci)
                     VALUES ('{$nombreNaci}')";
        $resultado = $this->conexion->query($consulta);
        return $resultado;
    }

    function darBajaNacionalidad($pkNacionalidad)
    {
        $consulta = "UPDATE nacionalidad 
                     SET estatus = 'I' 
                     WHERE pkNacionalidad = '{$pkNacionalidad}'";
        $resultado = $this->conexion->query($consulta);
        return $resultado;
    }

    function verNacionalidad($pkNacionalidad)
    {
        $consulta = "SELECT * FROM nacionalidad 
                     WHERE pkNacionalidad = '{$pkNacionalidad}'";
        $resultado = $this->conexion->query($consulta);
        return $resultado;
    }

    function listaNacionalidades()
    {
        $consulta = "SELECT *  FROM nacionalidad 
                     WHERE estatus = 'A'";
        $resultado = $this->conexion->query($consulta);
        return $resultado;
    }
    function buscarNacionalidad($busqueda)
    {
        $consulta = "SELECT * FROM nacionalidad 
                 WHERE nombreNaci LIKE '%{$busqueda}%'";
        return $this->conexion->query($consulta);
    }

    function filtrar($buscar = '', $estatus = '')
    {
        $consulta = "SELECT * FROM nacionalidad
    WHERE 1=1";

        if (!empty($buscar)) {
            $buscar = mysqli_real_escape_string($this->conexion, $buscar);
            $consulta .= " AND ( nombreNaci LIKE '%$buscar%')";
        }

        if (!empty($estatus)) {
            $estatus = mysqli_real_escape_string($this->conexion, $estatus);
            $consulta .= " AND estatus = '$estatus'";
        } else {
            // Si no se elige estatus, por defecto muestra los activos
            $consulta .= " AND estatus = 'A'";
        }

        $resultado = mysqli_query($this->conexion, $consulta);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    }
}
