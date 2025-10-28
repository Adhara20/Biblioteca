<?php
include('clases/nacionalidad.php');
$clase = new Nacionalidad();
$resultado = $clase->listaNacionalidades();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<form action="controladores/insertar_autor.php" method="POST"> 
    <h2>Registrar Autor</h2>

    <label>Nombre Autor:</label>
    <input type="text" name="nombreAutor" required>
    <br><br>

    <label>Nacionalidad:</label>
    <select name="fkNacionalidad" required>
        <option value="">Seleccione una opción</option>
        <?php foreach ($resultado as $fila){ ?>
            <option value="<?=$fila['pkNacionalidad']?>"><?=$fila['nombreNaci']?></option>
        <?php } ?>
    </select>
    <br><br>

    <input type="submit" value="Guardar">
</form>
</body>
</html>