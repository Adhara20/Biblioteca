<?php
session_start(); // Iniciar sesión
$nombreAutor = $_POST['nombreAutor'];
$fkNacionalidad = $_POST['fkNacionalidad'];
$_SESSION['form_autor'] = [
    'nombreAutor' => $_POST['nombreAutor'],
    'fkNacionalidad' => $_POST['fkNacionalidad'],
];
include('../clases/autor.php');
$clase = new Autor();
$resultado = $clase->guardar($nombreAutor, $fkNacionalidad);
if ($resultado) {
        header("Location: ../vistas/lista_autor.php?success=Autor registrado correctamente");
        exit;
    } else {
        header("Location: ../vistas/formulario_autor.php?error=Error al registrar Autor");
        exit;
    }
?>