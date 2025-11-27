<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Revisar si hay sesión
if (!isset($_SESSION['pkUsuarioLog'])) {
    // Redirigir a login si no hay sesión
    header("Location: login.php?error=Debes iniciar sesión");
    exit();
}

// Restringir por Rol
$rol = $_SESSION['rol'] ?? null;
// Solo admin y bibliotecario acceden
if (!in_array($rol, ['A','B'])) {
    header("Location: index.php?error=No tienes permisos");
    exit();
}
?>
