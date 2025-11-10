<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!-- Recivir el mensaje de error o de que se registro desde inserta -->
    <?php if (isset($_GET['error'])){ ?>
        <div style="color: red; font-weight: bold;">
            <?= htmlspecialchars($_GET['error']) ?>
        </div>
    <?php }?>
    <?php 
    
    include('../clases/libro.php');
    include('../clases/autor.php');
    include('../clases/editorial.php');
    include('../clases/subcategoria.php');
    // Obtener autores, editoriales y categorías desde sus clases
    $autor = new Autor();
    $editorial = new Editorial();
    $subcategoria = new Subcategoria();

    $listaAutores = $autor->mostrar();
    $listaEditoriales = $editorial->listaEditoriales();
    $listaCategorias = $subcategoria->listaActivo();
    ?>
    <form action="../controladores/insertar_libro.php" method="POST" enctype="multipart/form-data">
        <h3>Registrar Libro</h3>

        <label for="isbn">ISBN</label>
        <input type="text" name="isbn" placeholder="ISBN" required>

        <label for="titulo">Título</label>
        <input type="text" name="titulo" placeholder="Título del libro" required>
        <br>

        <label for="autor">Autor</label>
        <select name="fkAutor" required>
            <option value="">Seleccione el autor</option>
            <?php foreach ($listaAutores as $fila) { ?>
                <option value="<?=$fila['pkAutor']?>"><?=$fila['nombreAutor']?></option>
            <?php } ?>
        </select>

        <label for="edicion">Edición</label>
        <input type="text" name="edicion" placeholder="Ej. 3ra Edición">

        <label for="fkEditorial">Editorial</label>
        <select name="fkEditorial" required>
            <option value="">Seleccione la editorial</option>
            <?php foreach ($listaEditoriales as $fila) { ?>
                <option value="<?=$fila['pkEditorial']?>"><?=$fila['nombreEditorial']?></option>
            <?php } ?>
        </select>
        <br>

        <label for="portada">Portada</label>
        <input type="file" name="portada" accept="imagenes/portadas/">

        <label for="numPaginas">Número de Páginas</label>
        <input type="number" name="numPaginas" required>

        <label for="añoPublicacion">Año de Publicación</label>
        <input type="number" name="añoPublicacion" required>

        <label for="idioma">Idioma</label>
        <input type="text" name="idioma" placeholder="Ej. Español, Inglés" required>
        <br>

        <label for="fksubCategoria">Subategoría</label>
        <select name="fkSubCategoria" required>
            <option value="">Seleccione una categoría</option>
            <?php foreach ($listaCategorias as $fila) { ?>
                <option value="<?=$fila['pkSubCategoria']?>"><?=$fila['nombreSubCategoria']?></option>

            <?php } ?>
        </select>
        <br>

        <label for="sinopsis">Sinopsis</label><br>
        <textarea name="sinopsis" rows="4" cols="50" placeholder="Breve descripción del libro"></textarea>
        <br><br>

        <input type="submit" value="Registrar">
    </form>
</body>
</html>