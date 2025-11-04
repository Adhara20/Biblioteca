<?php
$nombre = $_POST['nombre'];
$iconoSubCategoria = $_FILES['IconoSubCategoria']['name']; 
$ruta = $_FILES['IconoSubCategoria']['tmp_name'];
move_uploaded_file($ruta, '../imagenes/subcategorias/'.$iconoSubCategoria);
$abreviatura = $_POST['abreviatura'];
$fkCategoria = $_POST['fkCategoria'];
include('../clases/subcategoria.php');
$clase = new Subcategoria();
$resultado = $clase->guardar($nombre, $iconoSubCategoria, $abreviatura, $fkCategoria);
    if ($resultado) {
        header("Location: ../vistas/lista_subcategoria.php?success=Subcategoría registrada correctamente");
        exit;
    } else {
        header("Location: ../vistas/formulario_subcategoria.php?error=Error al registrar Subcategoría");
        exit;
    }
?>