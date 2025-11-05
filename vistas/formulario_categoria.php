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
    <form action="../controladores/insertar_categoria.php" method="POST" enctype="multipart/form-data">
        <h2>Regristro Categoria</h2>
        <label>Nombre categoria:</label>
        <br>
        <input type="text" name="nombre" require>
        <br>
        <label>Icono de la categoria:</label>
        <input type="file" name="IconoCategoria" require>
        <br>
        <br>
        <input type="submit" value="Guardar">

    </form>
    
</body>
</html>