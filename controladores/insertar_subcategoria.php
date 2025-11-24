<?php
session_start(); // Iniciar sesión
$nombreSubCategoria = $_POST['nombreSubCategoria'];
// $iconoSubCategoria = $_FILES['IconoSubCategoria']['name']; 
// $ruta = $_FILES['IconoSubCategoria']['tmp_name'];
// move_uploaded_file($ruta, '../imagenes/subcategorias/'.$iconoSubCategoria);
$abreviatura = $_POST['abreviatura'];
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