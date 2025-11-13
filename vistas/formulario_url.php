<?php
ob_start();
include('../clases/libro.php');


$claseLibro = new Libro();
$resultadoLibros = $claseLibro->listaLibrosActivos();


$libros = [];
if ($resultadoLibros) {
    while ($fila = $resultadoLibros->fetch_assoc()) {
        $libros[] = $fila;
    }
}
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
            <?php foreach ($libros as $libro): ?>
                <option value="<?= $libro['pkLibro'] ?>"><?= $libro['titulo'] ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <input type="submit" class="boton" value="Guardar">
    </form>

</body>

</html>