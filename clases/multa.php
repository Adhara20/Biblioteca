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
//Bibliotecario y Admin
    function filtrar($buscar = '', $estatus = '', $tipo = '') {
    $consulta = "SELECT m.*, 
                        CONCAT(u.nombres, ' ', u.apaterno, ' ', u.amaterno) AS nombreUsuario,
                        p.codigoPrestamo
                 FROM multa m
                 INNER JOIN prestamo p ON m.fkPrestamo = p.pkPrestamo
                 INNER JOIN usuario u ON p.fkUsuarioSolicita = u.pkUsuario
                 WHERE 1 = 1";

    if (!empty($buscar)) {
        $buscar = mysqli_real_escape_string($this->conexion, $buscar);
        $consulta .= " AND (u.nombres LIKE '%$buscar%'
                        OR u.apaterno LIKE '%$buscar%'
                        OR p.codigoPrestamo LIKE '%$buscar%'
                        OR m.tipoMulta LIKE '%$buscar%')";
    }

    if (!empty($estatus)) {
        $estatus = mysqli_real_escape_string($this->conexion, $estatus);
        $consulta .= " AND m.estatus = '$estatus'";
    }

    if (!empty($tipo)) {
        $tipo = mysqli_real_escape_string($this->conexion, $tipo);
        $consulta .= " AND m.tipoMulta = '$tipo'";
    }

    $resultado = mysqli_query($this->conexion, $consulta);
    return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
}




    // Filtrar mis Multas si soy lector
    function filtrarPorUsuario($pkUsuario, $buscar = '', $estatus = '', $tipo = '') {
    $pkUsuario = intval($pkUsuario);

    $consulta = "SELECT m.*, 
                        p.codigoPrestamo
                 FROM multa m
                 INNER JOIN prestamo p ON m.fkPrestamo = p.pkPrestamo
                 WHERE p.fkUsuarioSolicita = $pkUsuario";

    if (!empty($buscar)) {
        $buscar = mysqli_real_escape_string($this->conexion, $buscar);
        $consulta .= " AND (p.codigoPrestamo LIKE '%$buscar%'
                        OR m.tipoMulta LIKE '%$buscar%')";
    }

    if (!empty($estatus)) {
        $estatus = mysqli_real_escape_string($this->conexion, $estatus);
        $consulta .= " AND m.estatus = '$estatus'";
    }

    if (!empty($tipo)) {
        $tipo = mysqli_real_escape_string($this->conexion, $tipo);
        $consulta .= " AND m.tipoMulta = '$tipo'";
    }

    $resultado = mysqli_query($this->conexion, $consulta);
    return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
}




    // Detalles de una multa
function detalles($pkMulta) {
    $pkMulta = intval($pkMulta);

    $consulta = "
        SELECT 
            m.*,
            p.codigoPrestamo,
            p.fkUsuarioSolicita,
            CONCAT(u.nombres, ' ', u.apaterno) AS nombreUsuario,
            u.numCredencial
        FROM multa m
        INNER JOIN prestamo p ON m.fkPrestamo = p.pkPrestamo
        INNER JOIN usuario u ON p.fkUsuarioSolicita = u.pkUsuario
        WHERE m.pkMulta = {$pkMulta}
        LIMIT 1
    ";

    return $this->conexion->query($consulta);
}



    function actualizar($pkMulta, $tipoMulta, $montoMulta, $codigoPrestamo) {

    // Buscar id del préstamo por código
    $fkPrestamo = $this->obtenerPkPrestamoPorCodigo($codigoPrestamo);

    if ($fkPrestamo === null) {
        return false; // Prestamo no encontrado
    }

    $pkMulta    = intval($pkMulta);
    $tipoMulta  = mysqli_real_escape_string($this->conexion, $tipoMulta);
    $montoMulta = floatval($montoMulta);

    $consulta = "
        UPDATE multa SET 
            tipoMulta = '$tipoMulta',
            montoMulta = $montoMulta,
            fkPrestamo = $fkPrestamo
        WHERE pkMulta = $pkMulta
    ";

    return $this->conexion->query($consulta);
}



    // Activar multa
    function cancelar($pkMulta) {
        $pkMulta = intval($pkMulta);
        $consulta = "UPDATE multa SET estatus = 'C' WHERE pkMulta = $pkMulta";
        return $this->conexion->query($consulta);
    }

    // Desactivar multa
    function pagar($pkMulta) {
    $pkMulta = intval($pkMulta);

    // Guardar fecha actual
    $fechaPago = date("Y-m-d H:i:s");

    $consulta = "
        UPDATE multa 
        SET estatus = 'P',
            fechaPago = '$fechaPago'
        WHERE pkMulta = $pkMulta
    ";

    return $this->conexion->query($consulta);
}

    // Insertar nueva multa
    function insertar($tipoMulta, $montoMulta, $fechaRegistro, $codigoPrestamo) {

        $codigoMulta = $this->generarCodigoMulta();

        // Convertir codigo a pkPrestamo
        $fkPrestamo = $this->obtenerPkPrestamoPorCodigo($codigoPrestamo);

        if ($fkPrestamo === null) {
            return false; // Prestamo no encontrado
        }

        // 
        $tipoMulta = mysqli_real_escape_string($this->conexion, $tipoMulta);
        // Convertir a tipo flotante
        $montoMulta = floatval($montoMulta);

        // Insertar multa
        $consulta = "INSERT INTO multa (codigoMulta, tipoMulta, montoMulta, fechaRegistro, fkPrestamo, estatus)
            VALUES ('$codigoMulta', '$tipoMulta', $montoMulta, '$fechaRegistro', $fkPrestamo, 'A')";

        $insertado = $this->conexion->query($consulta);

        // Ver si se intertó
        if (!$insertado) {
            return false; 
        }

        // Si es Daño Grave o Perdido, entonces marcar copia como Inactiva
        if ($tipoMulta == 'Perdido' || $tipoMulta == 'Daño Grave') {

            // Obtener fkCopiaF
            $buscarCopia = "SELECT fkCopiaF FROM prestamo WHERE pkPrestamo = '{$fkPrestamo}' LIMIT 1";

            $resultadoBusqueda = $this->conexion->query($buscarCopia);

            if ($resultadoBusqueda && $resultadoBusqueda->num_rows > 0) {

                $fila = $resultadoBusqueda->fetch_assoc();
                $fkCopiaF = $fila['fkCopiaF'];

                // Desactivar la copia
                $actualizar = "UPDATE copiaF SET estatus = 'I' WHERE pkCopiaF = '$fkCopiaF'";

                $this->conexion->query($actualizar);
            }
        }
        return true;
    }


// Generar codigo-número
    function generarCodigoMulta() {
    // Prefijo: Es la parte que se mantendra igual en todos los numCredenciales
    $prefijo = "M-";
    // Se consulta el ultimo número que se registro, LIKE(busca los registros que se paresca al dato siguiente. $prefijo%(%se usa para indicar que solo busque registros que inicien con lo que se indica, en este caso OW-)
    //ORDER BY numCredencial DESC LIMIT 1: busca el ultimo registro, o sea el más alto, y con LIMIT 1 se indica que solo se quiere ese
    $consulta = "SELECT codigoMulta FROM multa WHERE codigoMulta LIKE '{$prefijo}%' ORDER BY codigoMulta DESC LIMIT 1";
    $resultado = $this->conexion->query($consulta);
    if ($fila = $resultado->fetch_assoc()) {
        // Se usa para extraer, por ejemplo: de OW-000012, "000012" y convertirlo a numero
        $ultimoNumero = intval(substr($fila['codigoMulta'], strlen($prefijo)));
        $nuevoNumero = $ultimoNumero + 1;//Al ultimo número se le aumenta 1 para que se cree el nuevo numero que ira despues del prefijo
    } else {
        //Si no hay registros, pues se empieza con 1
        $nuevoNumero = 1;
    }
    // Como se ocupan x cantidad de digitos, pues con esto llena lo que sobre con 0
    $codigoMulta = $prefijo . str_pad($nuevoNumero, 8, "0", STR_PAD_LEFT);
    return $codigoMulta;
    }

function obtenerPkPrestamoPorCodigo($codigoPrestamo) {

    $codigoPrestamo = mysqli_real_escape_string($this->conexion, $codigoPrestamo);

    $consulta = "SELECT pkPrestamo 
                 FROM prestamo 
                 WHERE codigoPrestamo = '$codigoPrestamo' 
                 LIMIT 1";

    $resultado = $this->conexion->query($consulta);

    if ($fila = $resultado->fetch_assoc()) {
        return $fila['pkPrestamo'];
    }

    return null;  // No existe ese código
} 

// Evitamos ejecutar muchas consultas cada que entramos a ciertas pantallas
    public function generarMultasAutomaticas(){
        // Obtener la fecha actual
        $hoy = date('Y-m-d');
        // Revisa la ultima revision
        $consulta = "SELECT valor FROM configuracion WHERE clave = 'ultima_revision_multas'";
        // Guarda resultado de la consulta
        $resultado = $this->conexion->query($consulta);
        // Desglosa el arreglo
        $fila = $resultado->fetch_assoc();
        // Obtener el ultimo valor guardado(es una fecha)
        $ultimaRevision = $fila['valor'];

        // Si ya se ejecuto ese dia, ahi la dejamos
        if ($ultimaRevision == $hoy) {
            return;
        }

        // Sino, generame una multa por retraso muajaja
        $this->generarMultasRetraso(); // <-- Esta es tu función que genera multas por retraso

        // Actualizar la fecha en el campo valor para validar al dia siguinet(en realidad, cuando alguien entre al sistema)
        $consultaConfi = "UPDATE configuracion 
                      SET valor = '$hoy' 
                      WHERE clave = 'ultima_revision_multas'";
        $this->conexion->query($consultaConfi);
    }


// Generar multas automaticas por RETRASO
    function generarMultasRetraso() {
    $codigoMulta = $this->generarCodigoMulta();
    $hoy = date('Y-m-d');

    $consultaPrestamos = "SELECT pkPrestamo
                          FROM prestamo
                          WHERE estatus = 'EnProceso'
                            AND fechaLimite < '$hoy'";
    $resultadoPrestamos = $this->conexion->query($consultaPrestamos);

    if ($resultadoPrestamos && $resultadoPrestamos->num_rows > 0) {
        while ($prestamo = $resultadoPrestamos->fetch_assoc()) {
            $pkPrestamo = $prestamo['pkPrestamo'];

            $consultaExiste = "SELECT 1 
                               FROM multa 
                               WHERE fkPrestamo = $pkPrestamo 
                                 AND tipoMulta IN ('Retraso','Perdido')";
            $resExistente = $this->conexion->query($consultaExiste);

            if ($resExistente && $resExistente->num_rows === 0) {
                
                $insertar = "INSERT INTO multa (codigoMulta, tipoMulta, montoMulta, fechaRegistro, fkPrestamo, estatus)
                             VALUES ('$codigoMulta', 'Retraso', 0, '$hoy', $pkPrestamo, 'A')";
                $this->conexion->query($insertar);
            }
        }
    }
}


    function obtenerMultasPrestamo($pkPrestamo) {
    $consulta = "SELECT tipoMulta FROM multa WHERE fkPrestamo = $pkPrestamo AND estatus = 'A'";
    $resultado = $this->conexion->query($consulta);

    $multas = [];
    if ($resultado) {
        while ($fila = $resultado->fetch_assoc()) {
            $multas[] = $fila['tipoMulta'];
        }
    }

    return $multas;
}




}
?>


