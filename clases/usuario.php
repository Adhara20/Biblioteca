<?php
class Usuario {
    private $conexion;

    function __construct() {
        require_once("conexion.php");
        $this->conexion = new Conexion();
    }
                    //Dejo de recivir y mandar $numCredencia como parametro
    function guardar( $nombres, $apaterno, $amaterno, $curp, $fechaNac, $sexo, $pass, $correo, $foto, $rol) {
        //mando a llamar la funcion para generar números autoatisco para credenciales
        $numCredencial = $this->generarNumCredencial();

        $consulta = "INSERT INTO usuario 
                     (numCredencial, nombres, apaterno, amaterno, curp, fechaNac, sexo, pass, correo, foto, rol, fechaRegistro)
                     VALUES 
                     ('{$numCredencial}', '{$nombres}', '{$apaterno}', '{$amaterno}', '{$curp}', '{$fechaNac}', '{$sexo}', '{$pass}', '{$correo}', '{$foto}', '{$rol}', NOW())";
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

    function existeCurpTipo($curp, $rol) {
    if ($rol == 'L') {
        $consulta = "SELECT * FROM usuario WHERE curp = '$curp' AND rol = 'L'";
    } else {
        $consulta = "SELECT * FROM usuario WHERE curp = '$curp' AND rol IN ('A', 'B')";
    }
    $resultado = $this->conexion->query($consulta);
    return ($resultado->num_rows > 0); 
}
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

    function login($numCredencial, $pass) {
        $numCredencial = $this->conexion->real_escape_string($numCredencial);
        $password = $this->conexion->real_escape_string($password);
        $consulta = "SELECT pkUsuario, numCredencial, rol FROM usuario WHERE numCredencial = '{$numCredencial}' AND pass = '{$pass}' AND estatus = 'A'";
        return $this->conexion->query($consulta);
    }
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
                OR curp LIKE '%$buscar%' 
                OR correo LIKE '%$buscar%')";
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



}
?>
