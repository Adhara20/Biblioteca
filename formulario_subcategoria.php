<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>
    <?php
include('clases/categoria.php');
$categoria = new Categoria();
$resultado = $categoria->mostrar(); // Trae todas las categorías
?>
    <form action="controladores/insertar_subcategoria.php" method="POST" enctype="multipart/form-data">
        <label>Nombre subcategoria:</label>
        <br>
        <input type="text" name="nombre">
        <br>
        <label>Icono de la subcategoria:</label>
        <input type="text" name="nombreIconoSubCategoria">
        <br>
        <label>Abreviatura:</label>
        <br>
        <input type="text" name="abreviatura">
        <br>
        <label>Categoria:</label>
        <br>
        <select name="fkCategoria" required>
        <option value="">Seleccione una categoria</option>
                <?php foreach ($resultado as $fila): ?>
            <option value="<?= $fila['pkCategoria'] ?>">
                <?= $fila['nombreCategoria'] ?>
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