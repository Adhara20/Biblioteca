<?php
$nombre = $_POST['nombre'];
$iconoCategoria = $_FILES['IconoCategoria']['name']; 
$ruta = $_FILES['IconoCategoria']['tmp_name'];
move_uploaded_file($ruta, '../imagenes/categorias/'.$iconoCategoria);
include('../clases/categoria.php');
$clase = new Categoria();
$resultado = $clase->guardar($nombre, $iconoCategoria);
if ($resultado) {
        header("Location: ../vistas/lista_categoria.php?success=Categoria registrada correctamente");
        exit;
    } else {
        header("Location: ../vistas/formulario_categoria.php?error=Error al registrar Categoria");
        exit;
    }
?>