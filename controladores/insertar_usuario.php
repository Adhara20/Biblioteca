<?php
session_start(); // "Iniciar sesión" (nuevo)

// Recibir datos del formulario 
$nombres   = strtoupper($_POST['nombres']);
$apaterno  = strtoupper($_POST['apaterno']);
$amaterno  = strtoupper($_POST['amaterno']);
$curp      = strtoupper($_POST['curp']);
$fechaNac  = $_POST['fechaNac'];
$sexo      = $_POST['sexo'];
$pass      = $_POST['pass'];
$correo    = $_POST['correo'];
$rol       = $_POST['rol'];

// Guardar los datos en sesión en caso de error para mandarlos al formulario (nuevo)
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

// --- Validar la foto, pues es obligartoa ---(nuevo: solo si tienen imagen)
if (!isset($_FILES['foto']) || $_FILES['foto']['error'] !== 0) {
    header("Location: ../vistas/formulario_usuario.php?error=Debes subir una foto de usuario");
    exit;
}

// --- Preparar a foto pero sin subirla aun en caso de error (Nuevo)---
// Sino utilizan foto, quiten esto
$fotoNombre = $_FILES['foto']['name'];
$fotoTmp    = $_FILES['foto']['tmp_name'];
$destino    = '../imagenes/usuarios/' . $fotoNombre;

// Incluir la clase
include('../clases/usuario.php');

// Instancia
$clase = new Usuario();

// Validar si ya existe un usuario con esa CURP y ese tipo
if ($clase->existeCurpTipo($curp, $rol)) {
    header("Location: ../vistas/formulario_usuario.php?error=Ya existe un usuario con esa CURP y ese tipo de cuenta");
    exit;
}
//Esto
// --- Si todo esta bien, subir la foto ---Nuevo
move_uploaded_file($fotoTmp, $destino);

// Guardar en BD
$resultado = $clase->guardar($nombres, $apaterno, $amaterno, $curp, $fechaNac, $sexo, $pass, $correo, $fotoNombre, $rol);

if ($resultado) {
    // Limpiar la sesión si todo salió bien con "unset" (Nuevo)
    unset($_SESSION['form_usuario']);

    header("Location: ../vistas/lista_usuarios.php?success=Usuario registrado correctamente");
    exit;
} else {
    header("Location: ../vistas/formulario_usuario.php?error=Error al registrar el usuario");
    exit;
}
?>
