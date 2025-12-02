<?php
require_once('../includes/auth.php');

// Solo Admin y Bibliotecario
requireRole(['A', 'B']);
?>

<?php
session_start();

// Recibir datos
$nombreNaci = mb_strtoupper($_POST['nombreNaci'], 'UTF-8');

// Guardar datos en sesión por si hay error
$_SESSION['form_nacionalidad'] = [
    'nombreNaci' => $_POST['nombreNaci']
];

// Incluir clase
include('../clases/nacionalidad.php');

$clase = new Nacionalidad();

// Guardar
$resultado = $clase->guardar($nombreNaci);

if ($resultado) {
    // Quitar valores guardados
    unset($_SESSION['form_nacionalidad']);

    // REDIRIGIR A LA LISTA EN LUGAR DEL FORMULARIO
    header("Location: ../vistas/lista_nacionalidades.php?success=Nacionalidad registrada correctamente");
    exit;
} else {
    header("Location: ../vistas/formulario_nacionalidad.php?error=Error al registrar la nacionalidad");
    exit;
}

