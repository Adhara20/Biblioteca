<?php
require_once('../includes/auth.php');

// Solo Admin y Bibliotecario
requireRole(['A', 'B']);
?>

<?php
session_start(); // Iniciar sesión
$nombreAutor = mb_strtoupper($_POST['nombreAutor'], 'UTF-8');
$fkNacionalidad = $_POST['fkNacionalidad'];
$_SESSION['form_autor'] = [
    'nombreAutor' => $_POST['nombreAutor'],
    'fkNacionalidad' => $_POST['fkNacionalidad'],
];
if (!isset($_FILES['iconoAutor']) || $_FILES['iconoAutor']['error'] !== 0) {
    header("Location: ../vistas/formulario_autor.php?error=Debes subir la foto del autor");
    exit;
}
$iconoAutor = $_FILES['iconoAutor']['name'];
$iconoAutorTmp    = $_FILES['iconoAutor']['tmp_name'];
$ruta   = '../imagenes/autores/' . $iconoAutor;
move_uploaded_file($iconoAutorTmp, $ruta);
include('../clases/autor.php');
$clase = new Autor();
$resultado = $clase->guardar($nombreAutor, $iconoAutor, $fkNacionalidad);
if ($resultado) {
        header("Location: ../vistas/lista_autor.php?success=Autor registrado correctamente");
        exit;
    } else {
        header("Location: ../vistas/formulario_autor.php?error=Error al registrar Autor");
        exit;
    }
?>