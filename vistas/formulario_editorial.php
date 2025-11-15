<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrar Editorial</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <?php

    include('../clases/nacionalidad.php');

    // Crear objeto de la clase Nacionalidad para mostrar las opciones del select
    $clase = new Nacionalidad();
    $resultado = $clase->listaNacionalidades();
    ?>

    <form id="form" action="../Controladores/insertar_editorial.php" method="POST">
        <h3>Formulario Editorial</h3>

        <label>Nombre de la Editorial:</label><br>
        <input class="inp" type="text" name="nombreEditorial" required><br>

        <label>Nacionalidad:</label><br>
        <select name="fkNacionalidad" required>
            <option value="">Seleccione una nacionalidad</option>
            <?php
            foreach ($resultado as $fila) {
            ?>
                <option value="<?= $fila['pkNacionalidad'] ?>"><?= $fila['nombreNaci'] ?></option>
            <?php
            }
            ?>
        </select><br><br>

        <input type="submit" class="boton" value="Guardar">
    </form>
</body>

</html>