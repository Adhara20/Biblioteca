<?php
session_start(); // ← SIEMPRE

// QUIÉN ESTÁ EDITANDO
$rolEditor = $_SESSION['rol'] ?? null;
$pkEditor  = $_SESSION['pkUsuario'] ?? null;

$pkUsuario = $_POST['pkUsuario'];
$nombres   = strtoupper($_POST['nombres']);
$apaterno  = strtoupper($_POST['apaterno']);
$amaterno  = strtoupper($_POST['amaterno']);
$curp      = strtoupper($_POST['curp']);
$fechaNac  = $_POST['fechaNac'];
$sexo      = $_POST['sexo'];
$pass      = $_POST['pass'];
$correo    = $_POST['correo'];
$rol       = $_POST['rol'];  // Solo editable si es admin

$fotoActual = $_POST['fotoActual'];

include('../clases/usuario.php');
$usuario = new Usuario();

// VALIDAR CURP ÚNICA POR ROL (solo si es admin)
if ($rolEditor == 'A') {
    if ($usuario->existeCurpTipoActualizar($curp, $rol, $pkUsuario)) {
        header("Location: ../vistas/editar_usuario.php?pkUsuario=$pkUsuario&error=Esta CURP ya pertenece a otro Usuario con ese Rol");
        exit;
    }
}

// VALIDAR FOTO
if (!isset($_FILES['foto']) || $_FILES['foto']['error'] !== 0) {
    $foto = $fotoActual;
} else {
    $fotoNueva = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];
    move_uploaded_file($tmp, '../imagenes/usuarios/' . $fotoNueva);
    $foto = $fotoNueva;
}

// DECIDIR QUÉ ACTUALIZACIÓN USAR: COMPLETA O BÁSICA
if ($rolEditor == 'A') {
    // ADMIN → puede editar todo
    $resultado = $usuario->actualizarCompleto(
        $pkUsuario,
        $nombres,
        $apaterno,
        $amaterno,
        $curp,
        $fechaNac,
        $sexo,
        $pass,
        $correo,
        $rol,
        $foto
    );

} else {
    // USUARIO NORMAL → solo puede editar datos básicos
    $resultado = $usuario->actualizarBasico(
        $pkUsuario,
        $nombres,
        $apaterno,
        $amaterno,
        $pass,
        $correo,
        $foto
    );
}

// REDIRECCIÓN
if ($resultado) {
    header("Location: ../vistas/detalle_usuario.php?pkUsuario=$pkUsuario&success=Usuario actualizado correctamente");
} else {
    header("Location: ../vistas/editar_usuario.php?pkUsuario=$pkUsuario&error=Error al actualizar");
}

exit;
?>
