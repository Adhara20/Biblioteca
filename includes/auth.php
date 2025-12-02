<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1 Validar sesión activa
if (!isset($_SESSION['pkUsuarioLog'])) {
    header("Location: ../loguin.php?error=Debes iniciar sesión");
    exit();
}

// 2 Datos en sesión
$pkUsuarioLog = $_SESSION['pkUsuarioLog'] ?? null;
$rol          = $_SESSION['rol'] ?? null;
$estatusLog   = $_SESSION['estatusLog'] ?? null;

// 3 Función para restringir por rol
function requireRole($rolesPermitidos) {
    global $rol;
    if (!in_array($rol, $rolesPermitidos)) {
        header("Location: ../index.php?error=No tienes permisos");
        exit();
    }
}
