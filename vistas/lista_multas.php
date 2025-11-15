<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de multas</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/copias.css">
</head>
<?php
include('../includes/header.php');
?>

<body>
    <?php
    include('../clases/Multa.php');
    $clase = new Multa();
    $resultado = $clase->listaMultas();
    include('../includes/menu.php');
    ?>
    <div class="px-10 mb-4">
        <h1 class="titulos">Registro de multas</h1>
        <hr class="linea-separadora-listas">
    </div>
    <div class="tabla-copias-container">
        <table class="table-copias">
            <tr>

                <th>Código Multa</th>
                <th>Tipo</th>
                <th>Usuario</th>
                <th>Monto</th>
                <th>Fecha Registro</th>
                <th>Fecha Pago</th>
                <th>Préstamo</th>

            </tr>
            <?php foreach ($resultado as $fila): ?>
                <tr>
                    <td><?= $fila["codigoMulta"] ?></td>
                    <td><?= $fila["tipoMulta"] ?></td>
                    <td><?= $fila["usuarioSolicita"] ?></td>
                    <td><?= $fila["montoMulta"] ?></td>
                    <td><?= $fila["fechaRegistro"] ?></td>
                    <td><?= $fila["fechaPago"] ?></td>
                    <td><?= $fila["fkPrestamo"] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>

</html>