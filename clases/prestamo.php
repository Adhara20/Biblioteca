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

        $consultaDisponibilidad = "SELECT disponibilidad FROM copiaF WHERE pkCopiaF = '{$fkCopiaF}'";
        $resultado = $this->conexion->query($consultaDisponibilidad);
            if ($fila = $resultado->fetch_assoc()) {
                if ($fila['disponibilidad'] !== 'Disponible') {
                return false; 
            }
        } else {
        return false; // no existe
        }
        $codigoPrestamo = $this ->generarCodigo();

        // $dias = 5;
        $consulta = "INSERT INTO prestamo (codigoPrestamo, fechaRegistro, fechaLimite, folioContrato, archivoContrato, fkCopiaF, fkUsuarioSolicita, fkUsuarioAutoriza, estatusDevolucion) VALUES ('{$codigoPrestamo}', NOW(), '{$fechaLimite}', '{$folioContrato}', '{$archivoContrato}', '{$fkCopiaF}', '{$fkUsuarioSolicita}', '{$fkUsuarioAutoriza}', 'ATiempo')";
        $respuesta = $this->conexion->query($consulta);

        if ($respuesta) {
        $this->conexion->query("UPDATE copiaF SET disponibilidad = 'Prestado' WHERE pkCopiaF = '{$fkCopiaF}'");
    }
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

    function obtenerfolio($pkCopiaF) {
    $consulta = "SELECT pkCopiaF FROM copiaf WHERE pkCopiaF = '{$pkCopiaF}' LIMIT 1";
    $resultado = $this->conexion->query($consulta);

    if ($fila = $resultado->fetch_assoc()) {
        return $fila['pkCopiaF'];
    }

    throw new Exception("La copia con ID '{$pkCopiaF}' no existe en copiaf.");
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

    function detalles($pkPrestamo) {
    $consulta = "
        SELECT 
            p.pkPrestamo,
            p.codigoPrestamo,
            p.fechaRegistro,
            p.fechaLimite,
            p.fechaEntrega,
            p.folioContrato,
            p.archivoContrato,
            p.fkCopiaF,
            p.fkUsuarioSolicita,
            p.fkUsuarioAutoriza,
            l.isbn AS isbnCopia,
            c.folio AS folioCopia,
            us.numCredencial AS numSolicitante,
            ua.numCredencial AS numAutorizante,

            p.estatus,
            p.estatusDevolucion
        FROM prestamo p
        INNER JOIN copiaF c ON p.fkCopiaF = c.pkCopiaF
        INNER JOIN libro l ON c.fkLibro = l.pkLibro
        INNER JOIN usuario us ON p.fkUsuarioSolicita = us.pkUsuario
        INNER JOIN usuario ua ON p.fkUsuarioAutoriza = ua.pkUsuario
        WHERE p.pkPrestamo = '{$pkPrestamo}'
        LIMIT 1
    ";

    return $this->conexion->query($consulta);
}

    function cancelar($pkPrestamo) {
    $consultaPrestamo = "SELECT fkCopiaF FROM prestamo WHERE pkPrestamo = '{$pkPrestamo}'";
    $resultado = $this->conexion->query($consultaPrestamo);

    if ($fila = $resultado->fetch_assoc()) {
        $fkCopiaF = $fila['fkCopiaF'];

        $consultaActualizar = "UPDATE prestamo
                               SET estatus = 'Cancelado'
                               WHERE pkPrestamo = '{$pkPrestamo}'";
        $this->conexion->query($consultaActualizar);

        $this->conexion->query("UPDATE copiaF SET disponibilidad = 'Disponible' WHERE pkCopiaF = '{$fkCopiaF}'");

        return true;
    }

    return false;
    }

    function completar($pkPrestamo) {
        
        // 1. Obtener usuario del préstamo
        $consultaUsuario = "
            SELECT fkUsuarioSolicita 
            FROM prestamo
            WHERE pkPrestamo = '{$pkPrestamo}'";
        $rUsuario = $this->conexion->query($consultaUsuario);
        $fUsuario = $rUsuario->fetch_assoc();
        $fkUsuarioSolicita = $fUsuario['fkUsuarioSolicita'];
        
        // 2. Revisar multas pendientes ANTES de permitir completar
        $multasPendientes = $this->contarMultasPendientes($fkUsuarioSolicita);
        
        if ($multasPendientes > 0) {
            return 'MultasPendientes';  // ❌ NO permitimos completar
        }
    
        // 3. Obtener datos del préstamo
        $consultaPrestamo = "
            SELECT fkCopiaF, fechaLimite
            FROM prestamo
            WHERE pkPrestamo = '{$pkPrestamo}'
        ";
        $resultado = $this->conexion->query($consultaPrestamo);
        $fila = $resultado->fetch_assoc();
    
        $fkCopiaF = $fila['fkCopiaF'];
        $fechaLimite = $fila['fechaLimite'];
    
        // 4. Registrar fecha de entrega
        $consultaEntrega = "
            UPDATE prestamo 
            SET fechaEntrega = NOW()
            WHERE pkPrestamo = '{$pkPrestamo}'
        ";
        $this->conexion->query($consultaEntrega);
    
        // 5. Obtener fechaEntrega recién guardada
        $consultaFechaEntrega = "
            SELECT fechaEntrega 
            FROM prestamo 
            WHERE pkPrestamo = '{$pkPrestamo}'
        ";
        $r2 = $this->conexion->query($consultaFechaEntrega);
        $f2 = $r2->fetch_assoc();
        $fechaEntrega = $f2['fechaEntrega'];
    
        // 6. Determinar estatus devolucion
        if ($fechaEntrega > $fechaLimite) {
            $estatusDevolucion = 'Vencido';
        } else {
            $estatusDevolucion = 'ATiempo';
        }
    
        // 7. Actualizar préstamo como completado
        $consultafin = "
            UPDATE prestamo 
            SET estatus = 'Completado',
                estatusDevolucion = '{$estatusDevolucion}'
            WHERE pkPrestamo = '{$pkPrestamo}'
        ";
        $this->conexion->query($consultafin);
    
        // 8. Poner copia disponible
        $consultapain = "
            UPDATE copiaF
            SET disponibilidad = 'Disponible'
            WHERE pkCopiaF = '{$fkCopiaF}'
        ";
    
        return $this->conexion->query($consultapain);
    }


    // Añadir Observaciones a las copias fisicas despues de multarlas
    function anadirObservaciones($codigoPrestamo, $observaciones){
     // Obtener fkCopiaF
     $fkCopiaF = $this->obtenerCopia($codigoPrestamo);

     if (!$fkCopiaF) {
         return 'copiaNoEncontrada';
     }

     // Actualizar observaciones
     $consulta = "
         UPDATE copiaF 
         SET observaciones = CONCAT(IFNULL(observaciones, ''), '. ', '{$observaciones}')
         WHERE pkCopiaF = '{$fkCopiaF}'";

     return $this->conexion->query($consulta);
    }


    function obtenerCopia($codigoPrestamo){
        $consulta = "SELECT pkPrestamo, fkCopiaF FROM prestamo WHERE codigoPrestamo= '{$codigoPrestamo}' LIMIT 1";
        $resultado = $this->conexion->query($consulta);
        if ($fila = $resultado->fetch_assoc()) {
            return $fila['fkCopiaF']; 
        }
        return null;
    }



    function actualizar($pkPrestamo,$fechaLimite,$folioContrato,$archivoContrato,$folio,$numCredS,$numCredA) {

    $fkUsuarioSolicita = $this->obtenerfkUsuarioS($numCredS);
    $fkUsuarioAutoriza = $this->obtenerfkUsuarioA($numCredA);
    $fkCopiaF = $this->obtenerfolio($folio);

    if (!$fkUsuarioSolicita || !$fkUsuarioAutoriza || !$fkCopiaF) {
        return false;
    }

    $consulta = "
        UPDATE prestamo SET 
            fechaLimite = '{$fechaLimite}',
            folioContrato = '{$folioContrato}',
            archivoContrato = '{$archivoContrato}',
            fkCopiaF = '{$fkCopiaF}',
            fkUsuarioSolicita = '{$fkUsuarioSolicita}',
            fkUsuarioAutoriza = '{$fkUsuarioAutoriza}'
        WHERE pkPrestamo = '{$pkPrestamo}'
    ";

    return $this->conexion->query($consulta);
    return $resultado;
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
                       p.pkPrestamo,   
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
       function filtrarUsuario($pkUsuario, $buscar = '', $estatus = '', $estatusDevolucion = '', $fechaRegistro = '') {

    $consulta = "SELECT 
                    p.pkPrestamo,   
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
                WHERE p.fkUsuarioSolicita = '{$pkUsuario}'";

    // Busqueda por usuario, código o folio
    if (!empty($buscar)) {
        $buscar = mysqli_real_escape_string($this->conexion, $buscar);
        $consulta .= " AND (
            p.codigoPrestamo LIKE '%$buscar%' 
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

    // Fecha
    if (!empty($fechaRegistro)) {
        $fechaRegistro = mysqli_real_escape_string($this->conexion, $fechaRegistro);
        $consulta .= " AND p.fechaRegistro = '$fechaRegistro'";
    }

    $consulta .= " ORDER BY p.codigoPrestamo ASC";

    $resultado = mysqli_query($this->conexion, $consulta);
    return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
}


    function verPrestamoUsuario($pkUsuario) {

    $consulta = "SELECT 
                    p.pkPrestamo,   
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
                WHERE p.fkUsuarioSolicita = '$pkUsuario'
                ORDER BY p.codigoPrestamo ASC";

    $resultado = $this->conexion->query($consulta);
    return $resultado->fetch_all(MYSQLI_ASSOC);
}

    // Funcion para verirficar cuantas multas pendientes tiene el usuario
    function contarMultasPendientes($fkUsuarioSolicita) {
       $consulta = "SELECT COUNT(*) AS total
                    FROM multa
                    WHERE fkPrestamo IN (
                    SELECT pkPrestamo
                    FROM prestamo
                    WHERE fkUsuarioSolicita = '{$fkUsuarioSolicita}')
                    AND estatus = 'A'
                    AND tipoMulta IN ('Daño Menor', 'Daño Grave', 'Perdido')";
       
       $resultado = $this->conexion->query($consulta);
       $fila = $resultado->fetch_assoc();
       return $fila['total'] ?? 0;
    }


}
?>