<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de editoriales</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/copias.css">
</head>
<?php
include('../includes/header.php');
?>

<body>
    <?php
    include('../clases/Editorial.php');
    $clase = new Editorial();
    $resultado = $clase->listaEditoriales();
    include('../includes/menu.php');
    ?>
    <div class="px-10 mb-4">
        <h1 class="titulos">Registro de editoriales</h1>
        <hr class="linea-separadora-listas">
    </div>
    <div class="tabla-copias-container">
        <table class="table-copias">
            <tr>
                <th>Nombre Editorial</th>
                <th>Nacionalidad</th>
            </tr>
            <?php foreach ($resultado as $fila) { ?>
                <tr>
                    <td><?= $fila["nombreEditorial"] ?></td>
                    <td><?= $fila["nacionalidad"] ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>

</html>