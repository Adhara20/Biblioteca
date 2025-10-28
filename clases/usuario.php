<?php
class Usuario {
    private $conexion;

    function __construct() {
        require_once("conexion.php");
        $this->conexion = new Conexion();
    }

    function guardar($numCredencial, $nombres, $apaterno, $amaterno, $curp, $fechaNac, $edad, $sexo, $username, $pass, $correo, $foto, $rol) {
        $consulta = "INSERT INTO usuario 
                     (numCredencial, nombres, apaterno, amaterno, curp, fechaNac, edad, sexo, username, pass, correo, foto, rol, fechaRegistro)
                     VALUES 
                     ('{$numCredencial}', '{$nombres}', '{$apaterno}', '{$amaterno}', '{$curp}', '{$fechaNac}','{$edad}', '{$sexo}', '{$username}', '{$pass}', '{$correo}', '{$foto}', '{$rol}', NOW())";
        $resultado = $this->conexion->query($consulta);
        return $resultado;
    }

    function darBaja($pkUsuario) {
        $consulta = "UPDATE usuario 
                     SET estatus = 'I' 
                     WHERE pkUsuario = '$pkUsuario'";
        $resultado = $this->conexion->query($consulta);
        return $resultado;
    }

    function darAlta($pkUsuario) {
        $consulta = "UPDATE usuario 
                     SET estatus = 'A' 
                     WHERE pkUsuario = '$pkUsuario'";
        $resultado = $this->conexion->query($consulta);
        return $resultado;
    }

    function ver($pkUsuario) {
        $consulta = "SELECT * FROM usuario 
                     WHERE pkUsuario = '$pkUsuario'";
        $resultado = $this->conexion->query($consulta);
        return $resultado;
    }

    function listaActivos() {
        $consulta = "SELECT numCredencial, username, curp, rol, CONCAT(nombres, ' ', apaterno, ' ', COALESCE(amaterno, '')) AS nombreCompleto FROM usuario WHERE estatus='A'";

        $resultado = $this->conexion->query($consulta);
        return $resultado;
    }

    function listaInactivos() {
        $consulta = "SELECT numCredencial, username, curp, rol, CONCAT(nombres, ' ', apaterno, ' ', COALESCE(amaterno, '')) AS nombreCompleto FROM usuario 
                     WHERE estatus = 'I'";
        $resultado = $this->conexion->query($consulta);
        return $resultado;
    }

    function existeCurpTipo($curp, $rol) {
    if ($rol == 'L') {
        $consulta = "SELECT * FROM usuario WHERE curp = '$curp' AND rol = 'L'";
    } else {
        $consulta = "SELECT * FROM usuario WHERE curp = '$curp' AND rol IN ('A', 'B')";
    }
    $resultado = $this->conexion->query($consulta);
    return ($resultado->num_rows > 0); 
}

}
?>
