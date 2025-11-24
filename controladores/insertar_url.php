<?php
session_start(); // Iniciar sesión

// Recibir datos del formulario
$url     = $_POST['url'];
$fkLibro = $_POST['fkLibro'] ?? null;

// Guardar los datos en sesión por si ocurre un error
$_SESSION['form_url'] = [
    'url'     => $url,
    'fkLibro' => $fkLibro
];

// Incluir clase de URL
include('../clases/url.php');

// Crear instancia de la clase
$clase = new URL();

// Guardar la URL en la BD
$resultado = $clase->guardar($url, $fkLibro);

if ($resultado) {
    // Limpiar datos de sesión
    unset($_SESSION['form_url']);

    // Redirigir a la lista con mensaje de éxito
    header("Location: ../vistas/lista_urls.php?success=URL registrada correctamente");
    exit;
} else {
    // Redirigir a la lista con mensaje de error
    header("Location: ../vistas/lista_urls.php?error=Error al registrar la URL");
    exit;
}
?>
