
<?php
session_start();
include_once('../clases/prestamo.php');

$clase = new Prestamo();

// DATOS DE SESIÓN
$pkUsuarioLog = $_SESSION['pkUsuarioLog'] ?? null;
$rol = $_SESSION['rol'] ?? null;

// FILTROS
$buscar = $_GET['buscar'] ?? '';
$estatus = $_GET['estatus'] ?? '';
$estatusDevolucion = $_GET['estatusDevolucion'] ?? '';
$fechaRegistro = $_GET['fechaRegistro'] ?? '';

$resultado = [];

// ==========================
//      LECTOR (solo ve los suyos)
// ==========================
if ($rol === 'L') {

    // Sin filtros → ver todos sus préstamos
    if ($buscar === '' && $estatus === '' && $estatusDevolucion === '' && $fechaRegistro === '') {
        
        $resultado = $clase->verPrestamoUsuario($pkUsuarioLog);

    } else {

        // Con filtros
        $resultado = $clase->filtrarUsuario(
            $pkUsuarioLog,
            $buscar,
            $estatus,
            $estatusDevolucion,
            $fechaRegistro
        );
    }

// ==========================
//      ADMIN/BIBLIOTECARIO
// ==========================
} else {

    // Sin filtros → ver todos
    if ($buscar === '' && $estatus === '' && $estatusDevolucion === '' && $fechaRegistro === '') {

        $resultado = $clase->verPrestamo();

    } else {

        // Con filtros
        $resultado = $clase->filtrar(
            $buscar,
            $estatus,
            $estatusDevolucion,
            $fechaRegistro
        );
    }
}

?>