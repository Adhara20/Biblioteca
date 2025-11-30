<?php
session_start(); // Iniciar sesión
$nombreCategoria = strtoupper($_POST['nombreCategoria']);
// $iconoCategoria = $_FILES['IconoCategoria']['name']; 
// $ruta = $_FILES['IconoCategoria']['tmp_name'];
// move_uploaded_file($ruta, '../imagenes/categorias/'.$iconoCategoria);
$_SESSION['form_categoria'] = [
    'nombreCategoria' => $_POST['nombreCategoria'],

];
// --- Validar la portada obligatoria ---
if (!isset($_FILES['iconoCategoria']) || $_FILES['iconoCategoria']['error'] !== 0) {
    header("Location: ../vistas/formulario_categoria.php?error=Debes subir el icono de la categoria");
    exit;
}
// Preparar la portada (sin moverla todavía)
$iconoCategoria = $_FILES['iconoCategoria']['name'];
$iconoCategoriaTmp    = $_FILES['iconoCategoria']['tmp_name'];
$ruta   = '../imagenes/categorias/' . $iconoCategoria;
move_uploaded_file($iconoCategoriaTmp, $ruta);
include('../clases/categoria.php');
$clase = new Categoria();
$resultado = $clase->guardar($nombreCategoria, $iconoCategoria);
if ($resultado) {
        header("Location: ../vistas/lista_categoria.php?success=Categoría registrada correctamente");
        exit;
    } else {
        header("Location: ../vistas/formulario_categoria.php?error=Error al registrar categoría");
        exit;
    }
?>