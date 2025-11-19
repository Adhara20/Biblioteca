<?php
class Prestamo{
    function __construct(){
        require_once('Conexion.php');
        $this->conexion = new Conexion();
    }
    function guardar($fechaLimite, $folioContrato, $archivoContrato, $folio, $numCredS, $numCredA){
        $fkUsuarioAutoriza = $this->obtenerfkUsuarioA ($numCredA);
        $fkUsuarioSolicita = $this->obtenerfkUsuarioS ($numCredS);
        $fkCopiaF = $this ->obtenerfolio($folio);
        $codigoPrestamo = $this ->generarCodigo();
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
        $consulta = "SELECT pkCopiaF FROM copiaF WHERE folio = '{$folio}'";
        $resultado = $this->conexion->query($consulta);
        if ($fila = $resultado->fetch_assoc()) {
            return $fila['pkCopiaF'];
        }// validar que exista el libro -_-
        return null;
    }

    function verPrestamo() {
        $consulta = "
            SELECT 
                p.pkPrestamo,
                p.codigoPrestamo,
                p.fechaRegistro,
                p.fechaLimite,
                p.fechaEntrega,
                p.folioContrato,
                p.archivoContrato,
                l.isbn AS isbnCopia,  -- ISBN del libro asociado a la copia
                us.numCredencial AS numSolicitante,  -- Usuario que solicita
                ua.numCredencial AS numAutorizante,  -- Usuario que autoriza
                p.estatus,
                p.estatusDevolucion
            FROM prestamo p
            INNER JOIN copiaF c ON p.fkCopiaF = c.pkCopiaF
            INNER JOIN libro l ON c.fkLibro = l.pkLibro
            INNER JOIN usuario us ON p.fkUsuarioSolicita = us.pkUsuario
            INNER JOIN usuario ua ON p.fkUsuarioAutoriza = ua.pkUsuario
            ORDER BY p.codigoPrestamo ASC";

        $resultado = $this->conexion->query($consulta);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    function generarCodigo() {
    // Prefijo: Es la parte que se mantendra igual en todos los numCredenciales
    $prefijo = "CP-";
    // Se consulta el ultimo número que se registro, LIKE(busca los registros que se paresca al dato siguiente. $prefijo%(%se usa para indicar que solo busque registros que inicien con lo que se indica, en este caso OW-)
    //ORDER BY numCredencial DESC LIMIT 1: busca el ultimo registro, o sea el más alto, y con LIMIT 1 se indica que solo se quiere ese
    $consulta = "SELECT codigoPrestamo FROM prestamo WHERE codigoPrestamo LIKE '{$prefijo}%' ORDER BY codigoPrestamo DESC LIMIT 1";
    $resultado = $this->conexion->query($consulta);
    if ($fila = $resultado->fetch_assoc()) {
        // Se usa para extraer, por ejemplo: de OW-000012, "000012" y convertirlo a numero
        $ultimoFolio = intval(substr($fila['codigoPrestamo'], strlen($prefijo)));
        $nuevoFolio = $ultimoFolio + 1;//Al ultimo número se le aumenta 1 para que se cree el nuevo numero que ira despues del prefijo
    } else {
        //Si no hay registros, pues se empieza con 1
        $nuevoFolio = 1;
    }
    // Como se ocupan x cantidad de digitos, pues con esto llena lo que sobre con 0
    $folio = $prefijo . str_pad($nuevoFolio, 6, "0", STR_PAD_LEFT);
    return $folio;
    }

    function filtrar($buscar = '', $estatus = '', $estatusDevolucion = '', $fechaRegistro = '') {

    $consulta = "SELECT 
                    p.codigoPrestamo,
                    p.fechaRegistro,
                    p.fechaLimite,
                    p.fechaEntrega,
                    p.folioContrato,
                    p.archivoContrato,
                    l.isbn AS isbnCopia,
                    us.numCredencial AS numSolicitante,
                    ua.numCredencial AS numAutorizante,
                    p.estatus,
                    p.estatusDevolucion
                FROM prestamo p
                INNER JOIN copiaF c ON p.fkCopiaF = c.pkCopiaF
                INNER JOIN libro l ON c.fkLibro = l.pkLibro
                INNER JOIN usuario us ON p.fkUsuarioSolicita = us.pkUsuario
                INNER JOIN usuario ua ON p.fkUsuarioAutoriza = ua.pkUsuario
                WHERE 1=1";

    // Busqueda por usuario, código o folio
    if (!empty($buscar)) {
        $buscar = mysqli_real_escape_string($this->conexion, $buscar);
        $consulta .= " AND (
            us.numCredencial LIKE '%$buscar%' 
            OR p.codigoPrestamo LIKE '%$buscar%' 
            OR p.folioContrato LIKE '%$buscar%'
        )";
    }

    // Estatus
    if ($estatus !== '') {
        $estatus = mysqli_real_escape_string($this->conexion, $estatus);
        $consulta .= " AND p.estatus = '$estatus'";
    }

    // Estatus Devolución
    if ($estatusDevolucion !== '') {
        $estatusDevolucion = mysqli_real_escape_string($this->conexion, $estatusDevolucion);
        $consulta .= " AND p.estatusDevolucion = '$estatusDevolucion'";
    }

    // Filtrar por fecha exacta
    if (!empty($fechaRegistro)) {
        $fechaRegistro = mysqli_real_escape_string($this->conexion, $fechaRegistro);
        $consulta .= " AND p.fechaRegistro = '$fechaRegistro'";
    }

    $consulta .= " ORDER BY p.codigoPrestamo ASC";

    $resultado = mysqli_query($this->conexion, $consulta);
    return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
}
}
?>