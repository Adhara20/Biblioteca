<?php
include('../clases/multa.php');
$clase = new Multa();
$resultado = $clase->listaMultas();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Multas</title>
</head>

<body>
    <h2>Lista de Multas:</h2>

    <form action="../controladores/buscar_multa.php" method="GET">
        <h3>Buscar Multa</h3>
        <input type="text" name="buscador" required placeholder="Ejemplo: código, tipo o monto">
        <button type="submit">Buscar</button>
    </form>
    <br>
    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
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
                <td><?= $fila["pkMulta"] ?></td>
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
</body>

</html>