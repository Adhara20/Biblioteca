<?php
require_once('../includes/auth.php');

// Solo Admin y Bibliotecario
requireRole(['A', 'B', 'L']);
?>

<?php

include('../clases/usuario.php');
$usuario = new Usuario();

// Datos principales
$pkUsuario = $_POST['pkUsuario'];
$nombres   = mb_strtoupper($_POST['nombres'], 'UTF-8');
$apaterno  = mb_strtoupper($_POST['apaterno'], 'UTF-8');
$amaterno  = mb_strtoupper($_POST['amaterno'], 'UTF-8');
$correo    = $_POST['correo'];

$rolLog = $_SESSION['rol'];
$pkUsuarioLog = $_SESSION['pkUsuario'];


// Foto
$fotoActual = $_POST['fotoActual'];

if (!isset($_FILES['foto']) || $_FILES['foto']['error'] !== 0) {
    $foto = $fotoActual;
} else {
    $fotoNueva = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];
    move_uploaded_file($tmp, '../imagenes/usuarios/' . $fotoNueva);
    $foto = $fotoNueva;
}


// Contraseñas
$passActual     = $_POST['pass_actual']     ?? null;
$passNueva      = $_POST['pass_nueva']      ?? null;
$passConfirmar  = $_POST['pass_confirmar']  ?? null;

$cambiarPass = false;

// ¿Quiere cambiar contraseña?
if (!empty($passNueva) || !empty($passConfirmar)) {

    // 1 Validar si coinciden
    if ($passNueva !== $passConfirmar) {
        header("Location: ../vistas/editar_usuario.php?pkUsuario=$pkUsuario&error=Las contraseñas no coinciden");
        exit;
    }

    // 2 Si esta editando SU propio perfil -> validar contraseña actual
    if ($pkUsuarioLog == $pkUsuario) {
        $datos = $usuario->detalles($pkUsuario)->fetch_assoc();
        if ($datos['pass'] !== $passActual) {
            header("Location: ../vistas/editar_usuario.php?pkUsuario=$pkUsuario&error=La contraseña actual es incorrecta");
            exit;
        }
    }

    $cambiarPass = true;
}


// Opción 1: Un admin puede editar el perfil de los demas usuario(menos el suyos)
if ($rolLog == 'A' && $pkUsuarioLog != $pkUsuario) {

    $curp = strtoupper($_POST['curp']);
    $fechaNac = $_POST['fechaNac'];
    $sexo = $_POST['sexo'];
    $rolNuevo    = $_POST['rol'] ?? null; // admin sí puede cambiar rol

    $passParaGuardar = $cambiarPass ? $passNueva : ($_POST['pass_actual_bd'] ?? null);


    // Ejecutar actualización total
    $resultado = $usuario->actualizarCompleto(
        $pkUsuario,
        $nombres,
        $apaterno,
        $amaterno,
        $curp,
        $fechaNac,
        $sexo,
        $passParaGuardar,
        $correo,
        $rolNuevo,
        $foto
    );

    $redirectS = "../vistas/detalle_usuario.php?pkUsuario=$pkUsuario";
    $redirectE = "../vistas/editar_usuario.php?pkUsuario=$pkUsuario";

    if ($resultado) {
        header("Location: $redirectS&success=Perfil actualizado correctamente");
    } else {
        header("Location: $redirectE&error=Error al actualizar");
    }
    exit;

}


// Opción 2: Cualquier usuario puede editar su propio Perfil
$passParaGuardar = $cambiarPass ? $passNueva : null;

// Obtener contraseña actual si no se cambia
if (!$passParaGuardar) {
    $datos = $usuario->detalles($pkUsuario)->fetch_assoc();
    $passParaGuardar = $datos['pass'];
}

$resultado = $usuario->actualizarBasico(
    $pkUsuario,
    $nombres,
    $apaterno,
    $amaterno,
    $passParaGuardar,
    $correo,
    $foto
);

    $redirectS = "../vistas/detalle_usuario.php?pkUsuario=$pkUsuario";
    $redirectE = "../vistas/editar_usuario.php?pkUsuario=$pkUsuario";

    if ($resultado) {
        header("Location: $redirectS&success=Perfil actualizado correctamente");
    } else {
        header("Location: $redirectE&error=Error al actualizar");
    }
    exit;


?>
