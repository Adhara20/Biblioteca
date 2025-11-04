<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>
        <!-- Recivir el mensaje de error o de que se registro desde inserta -->
    <?php if (isset($_GET['error'])){ ?>
        <div style="color: red; font-weight: bold;">
            <?= htmlspecialchars($_GET['error']) ?>
        </div>
    <?php }?>
    <form action="../controladores/insertar_estanterias.php" method="POST" enctype="multipart/form-data";>
        <h2>Registrar estanteria:</h2>
        <label>Pasillo:</label>
        <br>
        <input type="text" name="pasillo" maxlength="1">
        <br>
        <label>Piso:</label>
        <br>
        <input type="number" name="piso">
        <br>
        <label>Niveles:</label>
        <br>
        <input type="number" name="niveles">
        <br>
        <label>Descripcion:</label>
        <br>
        <textarea name="descripcion"></textarea>
        <br>
        <br>
        <input type="submit" value="Guardar">
    </form>
    
</body>
</html>