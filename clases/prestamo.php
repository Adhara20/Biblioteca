<?php
class prestamo{
    function __construct(){
        require_once('Conexion.php');
        $this->conexion = new Conexion();
    }
    function guardar($codigoPrestamo, $fechaLimite, $folioContrato, $archivoContrato, $folio, $numCredS, $numCredA){
        $fkUsuarioAutoriza = $this->obtenerfkUsuarioA ($numCredA);
        $fkUsuarioSolicita = $this->obtenerfkUsuarioS ($numCredS);
        $fkCopiaF = $this ->obtenerfolio($folio);
        $consulta = "INSERT INTO prestamo (codigoPrestamo, fechaRegistro, fechaLimite, folioContrato, archivoContrato, fkCopiaF, fkUsuarioSolicita, fkUsuarioAutoriza) VALUES ('{$codigoPrestamo}', NOW(),'{$fechaLimite}', '{$folioContrato}', '{$archivoContrato}', '{$fkCopiaF}', '{$fkUsuarioSolicita}', '{$fkUsuarioAutoriza}')";
        $respuesta = $this->conexion->query($consulta);
        return $respuesta;
    }

    function obtenerfkUsuarioS($numCredS) {
        $consulta = "SELECT pkUsuario FROM usuario WHERE numCredencial = '{$numCredS}'";
        $resultado = $this->conexion->query($consulta);
        if ($fila = $resultado->fetch_assoc()) {
            return $fila['pkUsuario'];
        }// validar que exista el libro -_-
        return null;
    }

    function obtenerfkUsuarioA($numCredA) {
        $consulta = "SELECT pkUsuario FROM usuario WHERE numCredencial = '{$numCredA}'";
        $resultado = $this->conexion->query($consulta);
        if ($fila = $resultado->fetch_assoc()) {
            return $fila['pkUsuario'];
        }// validar que exista el libro -_-
        return null;
    }

    function obtenerfolio($folio) {
        $consulta = "SELECT pkCopiaF FROM copiaf WHERE folio = '{$folio}'";
        $resultado = $this->conexion->query($consulta);
        if ($fila = $resultado->fetch_assoc()) {
            return $fila['pkCopiaF'];
        }// validar que exista el libro -_-
        return null;
    }
}
?>