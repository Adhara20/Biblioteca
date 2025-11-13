<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Editoriales</title>
</head>

<body>
    <h2>Lista Editoriales:</h2>
    <form action="../controladores/buscar_editorial.php" method="GET">
        <h3>Buscar Editorial</h3>
        <input type="text" name="buscador" placeholder="Nombre de la editorial..." required>
        <button type="submit">Buscar</button>
    </form>
    <br>

    <?php
    include('../clases/editorial.php');
    $clase = new Editorial();
    $resultado = $clase->listaEditoriales();
    ?>
    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Nombre Editorial</th>
            <th>Nacionalidad</th>
        </tr>
        <?php foreach ($resultado as $fila): ?>
            <tr>
                <td><?= $fila["pkEditorial"] ?></td>
                <td><?= $fila["nombreEditorial"] ?></td>
                <td><?= $fila["nacionalidad"] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>