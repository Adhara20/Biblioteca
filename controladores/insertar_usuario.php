<?php
require_once('../includes/auth.php');

// Solo Admin y Bibliotecario
requireRole(['A']);
?>

<?php
session_start();
// Recivir datos del formulario
$nombres   = mb_strtoupper($_POST['nombres'], 'UTF-8');
$apaterno  = mb_strtoupper($_POST['apaterno'], 'UTF-8');
$amaterno  = mb_strtoupper($_POST['amaterno'], 'UTF-8');
$curp      = strtoupper($_POST['curp']);
$fechaNac  = $_POST['fechaNac'];
$sexo      = $_POST['sexo'];
$correo    = $_POST['correo'];
$rol       = $_POST['rol'];

// Guardar los datos en variables de sesion para recargarlos en el form en caso de error
// Solo esos se recargaran
$_SESSION['form_usuario'] = [
    'nombres'  => $_POST['nombres'],
    'apaterno' => $_POST['apaterno'],
    'amaterno' => $_POST['amaterno'],
    'curp'     => $_POST['curp'],
    'fechaNac' => $_POST['fechaNac'],
    'sexo'     => $_POST['sexo'],
    'correo'   => $_POST['correo'],
    'rol'      => $_POST['rol']
];

// Validad que la contraseña sea igual a su confirmacion
if ($_POST['pass'] !== $_POST['confirmarPass']) {
    // Mandar aviso en caso de que sean diferentes
    header("Location: ../vistas/formulario_usuario.php?error=Las contraseñas no coinciden");
    exit;
}

// Guardar la contraseña en una variable
$pass = $_POST['pass'];

// Validad que haya foto
if (!isset($_FILES['foto']) || $_FILES['foto']['error'] !== 0) {
    // mandar mensaje en caso de que no
    header("Location: ../vistas/formulario_usuario.php?error=Debes subir una foto de usuario");
    exit;
}

// Preparar la foto antes de guardar
$fotoNombre = $_FILES['foto']['name'];
$fotoTmp    = $_FILES['foto']['tmp_name'];

// evitar nombres repetidos
$extension = pathinfo($fotoNombre, PATHINFO_EXTENSION);//Obtiene la extencion del archivo(tipo de archivo)
$fotoNombre = uniqid('usr_') . "." . $extension;//uniqid crea un nombre nuevo para la imagen y la concatena con el resto
//variable                   Prefijo          Extenxion

// Ruta
$ruta = '../imagenes/usuarios/' . $fotoNombre;

// Clase
include('../clases/usuario.php');
$clase = new Usuario();

// Validad que no se repita CURP con el mismo rol
if ($clase->existeCurpTipo($curp, $rol)) {
    header("Location: ../vistas/formulario_usuario.php?error=Ya existe un usuario con esa CURP y ese tipo de cuenta");
    exit;
}

// Si todo estaba bien y llego hasta aca, se sube la foto
if (!move_uploaded_file($fotoTmp, $ruta)) {
    header("Location: ../vistas/formulario_usuario.php?error=No se pudo guardar la foto");
    exit;
}

// Se usa la funcion, Wiii
$resultado = $clase->guardar( $nombres, $apaterno, $amaterno, $curp, $fechaNac, $sexo, $pass, $correo, $fotoNombre, $rol);

// Validad que se haya guarado y mandar respectivis mensajitos
if ($resultado) {
    unset($_SESSION['form_usuario']);
    header("Location: ../vistas/lista_usuarios.php?success=Usuario registrado correctamente");
    exit;
} else {
    header("Location: ../vistas/formulario_usuario.php?error=Error al registrar el usuario");
    exit;
}
?>
