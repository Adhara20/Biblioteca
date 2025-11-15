<?php
include('../clases/multa.php');

if (isset($_GET['buscador'])) {
    $busqueda = $_GET['buscador'];
    $multa = new Multa();
    $resultado = $multa->buscarMulta($busqueda);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Resultados de búsqueda</title>
</head>

<body>
    <h2>Resultados de búsqueda para: <?= htmlspecialchars($busqueda) ?></h2>
    <a href="../vistas/lista_multas.php">Volver a la lista completa</a>
    <br><br>

    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Código Multa</th>
            <th>Tipo</th>
            <th>Monto</th>
            <th>Fecha Registro</th>
            <th>Fecha Pago</th>
            <th>Préstamo</th>
            <th>Usuario Solicitante</th> <!-- ✅ Nueva columna -->
        </tr>
        <?php if ($resultado && $resultado->num_rows > 0): ?>
            <?php while ($fila = $resultado->fetch_assoc()): ?>
                <tr>
                    <td><?= $fila['pkMulta'] ?></td>
                    <td><?= $fila['codigoMulta'] ?></td>
                    <td><?= $fila['tipoMulta'] ?></td>
                    <td><?= $fila['montoMulta'] ?></td>
                    <td><?= $fila['fechaRegistro'] ?></td>
                    <td><?= $fila['fechaPago'] ?></td>
                    <td><?= $fila['fkPrestamo'] ?></td>
                    <td><?= $fila['usuarioSolicita'] ?></td> <!-- ✅ Nuevo dato -->
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="8">No se encontraron resultados.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>

</html>