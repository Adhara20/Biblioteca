<?php
include('../clases/nacionalidad.php');

if (isset($_GET['buscador'])) {
    $busqueda = $_GET['buscador'];
    $nac = new Nacionalidad();
    $resultado = $nac->buscarNacionalidad($busqueda);
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
    <a href="../vistas/lista_nacionalidades.php"> Volver a la lista completa</a>

    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Nacionalidad</th>
        </tr>
        <?php if ($resultado && $resultado->num_rows > 0): ?>
            <?php while ($fila = $resultado->fetch_assoc()): ?>
                <tr>
                    <td><?= $fila['pkNacionalidad'] ?></td>
                    <td><?= $fila['nombreNaci'] ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="2">No se encontraron resultados.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>
