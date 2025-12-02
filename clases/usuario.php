<?php
class Usuario {
    private $conexion;

    function __construct() {
        require_once("conexion.php");
        $this->conexion = new Conexion();
    }
    public function contarMultasPendiente($pkUsuario){
        $consulta = "SELECT COUNT(*) AS total 
                     FROM multa m 
                     INNER JOIN prestamo p ON m.fkPrestamo = p.pkPrestamo
                     WHERE p.fkUsuarioSolicita = {$pkUsuario} AND m.estatus = 'A'";

        $resultado = $this->conexion->query($consulta);
        $fila = $resultado->fetch_assoc();
        return (int)$fila['total'];
    }


    // Atualizar el estatusPrestamista
    public function actualizarEstatusPrestamista($pkUsuario){
        $multasPendientes = $this->contarMultasPendiente($pkUsuario);

        if ($multasPendientes >= 3) {
            $estatus = 'V'; // Vetado
        } else {
            $estatus = 'A'; // Activo
        }

        $consulta = "UPDATE usuario 
                     SET estatusPrestamista = '{$estatus}'
                     WHERE pkUsuario = {$pkUsuario}";

        return $this->conexion->query($consulta);
    }


    // Registrar
    function guardar( $nombres, $apaterno, $amaterno, $curp, $fechaNac, $sexo, $pass, $correo, $fotoNombre, $rol) {
        //mando a llamar la funcion para generar números automaticos para credenciales
        $numCredencial = $this->generarNumCredencial();
        $consulta = "INSERT INTO usuario 
        (numCredencial, nombres, apaterno, amaterno, curp, fechaNac, sexo, pass, correo, foto, rol, fechaRegistro)
        VALUES 
        ('{$numCredencial}', '{$nombres}', '{$apaterno}', '{$amaterno}', '{$curp}', '{$fechaNac}', '{$sexo}', '{$pass}', '{$correo}', '{$fotoNombre}', '{$rol}', NOW())";
        $resultado = $this->conexion->query($consulta);
        return $resultado;
    }

    // Dar baja
    function desactivar($pkUsuario) {
        $consulta = "UPDATE usuario 
                     SET estatus = 'I' 
                     WHERE pkUsuario = '{$pkUsuario}'";
        $resultado = $this->conexion->query($consulta);
        return $resultado;
    }

    // Dar alta
    function activar($pkUsuario) {
        $consulta = "UPDATE usuario 
                     SET estatus = 'A' 
                     WHERE pkUsuario = '{$pkUsuario}'";
        $resultado = $this->conexion->query($consulta);
        return $resultado;
    }
    // ver
    function detalles($pkUsuario) {
        $consulta = "SELECT *, CONCAT(nombres, ' ', apaterno, ' ', COALESCE(amaterno, ' ')) AS nombreCompleto FROM usuario 
                     WHERE pkUsuario = '{$pkUsuario}'";
        $resultado = $this->conexion->query($consulta);
        return $resultado;
    }

    // Para validad al guardar
    function existeCurpTipo($curp, $rol) {
    if ($rol == 'L') {
        $consulta = "SELECT * FROM usuario WHERE curp = '$curp' AND rol = 'L'";
    } else {
        $consulta = "SELECT * FROM usuario WHERE curp = '$curp' AND rol IN ('A', 'B')";
    }
    $resultado = $this->conexion->query($consulta);
    return ($resultado->num_rows > 0); 
    }

    // Para validad al actualizar
    function existeCurpTipoActualizar($curp, $rol, $pkUsuario) {
    if ($rol == 'L') {
        $consulta = "SELECT * FROM usuario WHERE curp = '{$curp}' AND rol = 'L' AND pkUsuario != '{$pkUsuario}'";
    } else {
        $consulta = "SELECT * FROM usuario WHERE curp = '{$curp}' AND rol IN ('A','B') AND pkUsuario != '{$pkUsuario}'";
    }
    $resultado = $this->conexion->query($consulta);
    return ($resultado->num_rows > 0);
    }

    // Generar codigo-número
    function generarNumCredencial() {
    // Prefijo: Es la parte que se mantendra igual en todos los numCredenciales
    $prefijo = "OW-";
    // Se consulta el ultimo número que se registro, LIKE(busca los registros que se paresca al dato siguiente. $prefijo%(%se usa para indicar que solo busque registros que inicien con lo que se indica, en este caso OW-)
    //ORDER BY numCredencial DESC LIMIT 1: busca el ultimo registro, o sea el más alto, y con LIMIT 1 se indica que solo se quiere ese
    $consulta = "SELECT numCredencial FROM usuario WHERE numCredencial LIKE '{$prefijo}%' ORDER BY numCredencial DESC LIMIT 1";
    $resultado = $this->conexion->query($consulta);
    if ($fila = $resultado->fetch_assoc()) {
        // Se usa para extraer, por ejemplo: de OW-000012, "000012" y convertirlo a numero
        $ultimoNumero = intval(substr($fila['numCredencial'], strlen($prefijo)));
        $nuevoNumero = $ultimoNumero + 1;//Al ultimo número se le aumenta 1 para que se cree el nuevo numero que ira despues del prefijo
    } else {
        //Si no hay registros, pues se empieza con 1
        $nuevoNumero = 1;
    }
    // Como se ocupan x cantidad de digitos, pues con esto llena lo que sobre con 0
    $numCredencial = $prefijo . str_pad($nuevoNumero, 6, "0", STR_PAD_LEFT);
    return $numCredencial;
    }

    // Calcular edad
    function obtenerEdad($fechaNac){
        // DateTime sirve para convertir la fecha(que se guarda como texto aunque sea date) a un objeto para realizar calculos
        $nacimiento = new DateTime($fechaNac);
        // Se crea una variable con la fecha actual
        $hoy = new DateTime();
        // diff es la diferencia(resta) de la de hoy-fecNac
        $edad = $hoy->diff($nacimiento);
        // $edad contiene tanto días, meses y años de diferencia, con "y" toma solo años
        return $edad->y;
    }

    // Iniciar sesión
    function login($numCredencial, $pass) {
        $numCredencial = $this->conexion->real_escape_string($numCredencial);
        $pass = $this->conexion->real_escape_string($pass);
        $consulta = "SELECT pkUsuario, numCredencial, rol, estatus, CONCAT(nombres, ' ', apaterno, ' ') AS nombreCompleto FROM usuario WHERE numCredencial = '{$numCredencial}' AND pass = '{$pass}' AND estatus = 'A'";
        return $this->conexion->query($consulta);
    }
    // filtrar y mostrar listas
    function filtrar($buscar = '', $rol = '', $estatus = '', $vetado = '', $sexo = '', $fechaRegistro = '') {
       $consulta = "SELECT *,
                CONCAT(
                    COALESCE(nombres, ''), ' ',
                    COALESCE(apaterno, ''), ' ',
                    COALESCE(amaterno, '')
                ) AS nombreCompleto
             FROM usuario
             WHERE 1=1";
        // Barra de Busqueda
        if (!empty($buscar)) {
            $buscar = mysqli_real_escape_string($this->conexion, $buscar);
            $buscar = mysqli_real_escape_string($this->conexion, $buscar);
            $consulta .= " AND (
                numCredencial LIKE '%$buscar%' 
                OR nombres LIKE '%$buscar%' 
                OR apaterno LIKE '%$buscar%' 
                OR amaterno LIKE '%$buscar%' 
                OR CONCAT(
                    COALESCE(nombres, ''), ' ',
                    COALESCE(apaterno, ''), ' ',
                    COALESCE(amaterno, '')
                ) LIKE '%$buscar%'
                OR curp LIKE '%$buscar%')";
        }
        // Select Rol
        if (!empty($rol)) {
            $categoria = mysqli_real_escape_string($this->conexion, $rol);
            $consulta .= " AND rol = '$rol'";
        }
        // Select Estatus
        if (!empty($estatus)) {
            $estatus = mysqli_real_escape_string($this->conexion, $estatus);
            $consulta .= " AND estatus = '$estatus'";
        }else {
        // Si no se elige estatus, por defecto muestra los activos
        $consulta .= " AND estatus = 'A'";
        }
        // Select EstatusPrestamista
        if (!empty($vetado)) {
            $estatus = mysqli_real_escape_string($this->conexion, $vetado);
            $consulta .= " AND estatusPrestamista = '$vetado'";
        }
        // Select Genero
        if (!empty($sexo)) {
            $estatus = mysqli_real_escape_string($this->conexion, $sexo);
            $consulta .= " AND sexo = '$sexo'";
        }
        // Select Fecha de Registro
        if (!empty($fechaRegistro)) {
            $estatus = mysqli_real_escape_string($this->conexion, $fechaRegistro);
            $consulta .= " AND fechaRegistro = '$fechaRegistro'";
        }
        $resultado = mysqli_query($this->conexion, $consulta);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    }

    function actualizarCompleto( $pkUsuario, $nombres, $apaterno, $amaterno, $curp, $fechaNac, $sexo, $pass, $correo, $rol, $foto){
       $consulta = "UPDATE usuario SET 
                   nombres      = '{$nombres}',
                   apaterno     = '{$apaterno}',
                   amaterno     = '{$amaterno}',
                   curp         = '{$curp}',
                   fechaNac     = '{$fechaNac}',
                   sexo         = '{$sexo}',
                   pass         = '{$pass}',
                   correo       = '{$correo}',
                   rol          = '{$rol}',
                   foto         = '{$foto}'
               WHERE pkUsuario = '{$pkUsuario}'";

       return $this->conexion->query($consulta);
    }
    function actualizarBasico( $pkUsuario, $nombres, $apaterno, $amaterno, $pass, $correo, $foto) {
    $consulta = "UPDATE usuario SET 
                nombres  = '{$nombres}',
                apaterno = '{$apaterno}',
                amaterno = '{$amaterno}',
                pass     = '{$pass}',
                correo   = '{$correo}',
                foto     = '{$foto}'
            WHERE pkUsuario = '{$pkUsuario}'";
    return $this->conexion->query($consulta);
}

function mostrar(){
    $consulta = "SELECT pkUsuario, numCredencial FROM usuario WHERE estatus = 'A' AND estatusPrestamista = 'A' AND rol = 'L'";
    $resultado = $this->conexion->query($consulta);
    return $resultado;
}




}
?>
