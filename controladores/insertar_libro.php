<?php
// Recibir los datos del formulario
$isbn = $_POST['isbn'];
$titulo = $_POST['titulo'];
$edicion = $_POST['edicion'];
$numPaginas = $_POST['numPaginas'];
$añoPublicacion = $_POST['añoPublicacion'];
$idioma = $_POST['idioma'];
$sinopsis = $_POST['sinopsis'];
$fkAutor = $_POST['fkAutor'];
$fkEditorial = $_POST['fkEditorial'];
$fkSubcategoria = $_POST['fkSubCategoria'];
$portada = $_FILES['portada']['name'];
$ruta = $_FILES['portada']['tmp_name'];
move_uploaded_file($ruta, '../imagenes/portadas/'.$portada);

// Incluir la clase y registrar
include('../clases/libro.php');
$libro = new Libro();

$resultado = $libro->registrarLibro( $isbn, $titulo, $edicion, $numPaginas, $añoPublicacion, $idioma, $sinopsis, $fkAutor, $fkEditorial, $fkSubcategoria, $portada
);

if ($resultado) {
        header("Location: ../vistas/lista_libros.php?success=Libro registrado correctamente");
        exit;
    } else {
        header("Location: ../vistas/formulario_libro.php?error=Error al registrar Libro");
        exit;
    }
?>
