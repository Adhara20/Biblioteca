<?php
session_start();

// Recibir datos del formulario
$nombreEditorial = strtoupper($_POST['nombreEditorial']);
$fkNacionalidad = $_POST['fkNacionalidad'];

// Guardar datos en sesión por si ocurre un error
$_SESSION['form_editorial'] = [
    'nombreEditorial' => $_POST['nombreEditorial'],
    'fkNacionalidad' => $_POST['fkNacionalidad']
];

// Incluir clase de Editorial
include('../clases/editorial.php');
$clase = new Editorial();

// Guardar en la BD
$resultado = $clase->guardar($nombreEditorial, $fkNacionalidad);

if ($resultado) {
    // Limpiar datos en sesión
    unset($_SESSION['form_editorial']);

    // Redirigir a la lista con mensaje de éxito
    header("Location: ../vistas/lista_editoriales.php?success=Editorial registrada correctamente");
    exit;
} else {
    // Redirigir a la lista con mensaje de error
    header("Location: ../vistas/lista_editoriales.php?error=Error al registrar la editorial");
    exit;
}
?>
