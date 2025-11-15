<?php
ob_start();
include('../clases/libro.php');

$claseLibro = new Libro();

// Obtener todos los libros activos con la función filtrar()
$libros = $claseLibro->filtrar('', '', 'A');

ob_end_clean();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrar URL</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

    <form id="form" action="../controladores/insertar_url.php" method="POST">

        <h3>Formulario URL</h3>

        <label>URL:</label><br>
        <input class="inp" type="text" name="url" required><br>

        <label>Libro:</label><br>
        <select name="fkLibro" required>
            <option value="">Seleccione un libro</option>

            <?php if (!empty($libros)): ?>
                <?php foreach ($libros as $libro): ?>
                    <option value="<?= $libro['pkLibro'] ?>">
                        <?= $libro['titulo'] ?>
                    </option>
                <?php endforeach; ?>
            <?php else: ?>
                <option value="">No hay libros activos</option>
            <?php endif; ?>

        </select><br><br>

        <input type="submit" class="boton" value="Guardar">
    </form>

</body>

</html>