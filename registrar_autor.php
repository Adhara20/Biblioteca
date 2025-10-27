<?php
include('clases/autor.php');
$autor = new Autor();
$nacionalidades = $autor->obtenerNacionalidades();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<form action="insertar_autor.php" method="POST">
    <h2>Registrar Autor</h2>
    <br>
    <label>Nombre Autor:</label>
    <br>
    <input type="text" name="nombre" required><br>
    <label>Nacionalidad:</label>
    <br>
    <select name="fkNacionalidad" required>
        <option value="">Seleccione una opcion</option>
        <?php foreach ($nacionalidades as $nac): ?>
            <option value="<?= $nac['pkNacionalidad'] ?>">
                <?= $nac['nombreNacionalidad'] ?>
        </option>
        <?php endforeach; ?>
    </select>
    <br>
    <label>Estatus:</label>
    <br>
    <select name="estatus">
    <option value="A">Activo</option>
    <option value="I">Inactivo</option>
    </select>
    <br>
    <input type="submit" value="Guardar">
</form>
</body>
</html>