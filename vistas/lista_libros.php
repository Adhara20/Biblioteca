<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
</head>
<body>
    <?php
    include('../clases/libro.php');
    $clase = new Libro();
    ?>
    <div>
        <section>
            <h1>Lista Libros</h1>
    <?php 
    
    $resultado = $clase->listaLibrosActivos();
    ?>
    <table>
        <tr>
            <th>Titulo</th>
            <th>ISBN</th>
            <th>Autor</th>
            <th>Edicion</th>
            <th>Año de Publicacion</th>
            <th>Editorial</th>
            <th>Subcategoria</th>
            <th>Categoria</th>
        </tr>
        <?php
            foreach($resultado as $fila){
        ?>
            <tr>
                <td style="text-center"><?=$fila["titulo"]?></td>
                <td style="text-center"><?=$fila["isbn"]?></td>
                <td style="text-center"><?=$fila["nombreAutor"]?></td>
                <td style="text-center"><?=$fila["edicion"]?></td>
                <td style="text-center"><?=$fila["añoPublicacion"]?></td>
                <td style="text-center"><?=$fila["nombreEditorial"]?></td>
                <td style="text-center"><?=$fila["nombreSubCategoria"]?></td>
                <td style="text-center"><?=$fila["nombreCategoria"]?></td>
                <td style="text-center">(proximamente...)</td>
            </tr>
        <?php
            }
        ?>
    </table>
        </section>
    </div>
    <br>
</body>
</html>