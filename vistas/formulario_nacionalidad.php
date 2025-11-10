<!DOCTYPE html> 
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrar Nacionalidad</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <!-- Recivir el mensaje de error o de que se registro desde inserta -->
    <?php if (isset($_GET['error'])){ ?>
        <div style="color: red; font-weight: bold;">
            <?= htmlspecialchars($_GET['error']) ?>
        </div>
    <?php }?>
    <?php 
    include('../clases/nacionalidad.php');
    ?>

    <form id="form" action="../controladores/insertar_nacionalidad.php" method="POST">
        <h3>Formulario Nacionalidad</h3>

        <label>Nombre de la Nacionalidad:</label><br>
        <input class="inp" type="text" name="nombreNaci" required><br><br>

        <input type="submit" class="boton" value="Guardar">
    </form>
</body>
</html>
