<?php
require_once('../includes/auth.php');

// Solo Admin y Bibliotecario
requireRole(['A', 'B']);
?>

<?php
session_start(); // Iniciar sesión
$nombreSubCategoria = mb_strtoupper($_POST['nombreSubCategoria'], 'UTF-8');
// $iconoSubCategoria = $_FILES['IconoSubCategoria']['name']; 
// $ruta = $_FILES['IconoSubCategoria']['tmp_name'];
// move_uploaded_file($ruta, '../imagenes/subcategorias/'.$iconoSubCategoria);

$abreviatura = mb_strtoupper($_POST['abreviatura'], 'UTF-8');
$fkCategoria = $_POST['fkCategoria'];
$_SESSION['form_subcategoria'] = [
    'nombreSubCategoria' => $_POST['nombreSubCategoria'],
    'abreviatura' => $_POST['abreviatura'],
    'fkCategoria' => $_POST['fkCategoria'],
];
// --- Validar la portada obligatoria ---
if (!isset($_FILES['iconoSubCategoria']) || $_FILES['iconoSubCategoria']['error'] !== 0) {
    header("Location: ../vistas/formulario_subcategoria.php?error=Debes subir el icono de la subcategoria");
    exit;
}

// Preparar la portada (sin moverla todavía)
$iconoSubCategoria = $_FILES['iconoSubCategoria']['name'];
$iconoSubCategoriaTmp    = $_FILES['iconoSubCategoria']['tmp_name'];
$ruta   = '../imagenes/subcategorias/' . $iconoSubCategoria;
move_uploaded_file($iconoSubCategoriaTmp, $ruta);
include('../clases/subcategoria.php');
$clase = new Subcategoria();
$resultado = $clase->guardar($nombreSubCategoria, $iconoSubCategoria, $abreviatura, $fkCategoria);
    if ($resultado) {
        header("Location: ../vistas/lista_subcategoria.php?success=Subcategoría registrada correctamente");
        exit;
    } else {
        header("Location: ../vistas/formulario_subcategoria.php?error=Error al registrar Subcategoría");
        exit;
    }
?>