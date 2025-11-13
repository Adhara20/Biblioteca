<?php
include('../clases/editorial.php');

$busqueda = $_GET['buscador'];

$clase = new Editorial();
$resultado = $clase->buscarEditorial($busqueda);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de búsqueda</title>
</head>

<body>
    <h2>Resultados de la búsqueda:</h2>
    <a href="../vistas/lista_editoriales.php"> Volver a la lista completa</a>
    <br><br>

    <?php if (empty($resultado)): ?>
        <p>No se encontraron resultados para "<strong><?= htmlspecialchars($busqueda) ?></strong>".</p>
    <?php else: ?>
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
    <?php endif; ?>
</body>

</html>