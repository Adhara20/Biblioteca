<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>
     <?php
include('clases/estanterias.php');
$estanteria = new Estanterias();
$estanteriaRe = $estanteria->listaActivos(); // Trae todas las categorías

include('clases/subcategoria.php');
$subcategorias = new Subcategoria();
$subCategoriaRe = $subcategorias->listaActivo(); // Trae todas las categorías
?>
    <form action="controladores/insertar_estantes.php" method="POST" enctype="multipart/form-data">
        <h2>Registrar estante:</h2>
        <br>
        <label>Nivel:</label>
        <br>
        <input type="number" name="nivel">
        <br>
        <label>Estanteria:</label>
        <br>
            <select name="fkEstanteria" required>
        <option value="">Seleccione una estanteria</option>
                <?php foreach ($estanteriaRe as $fila): ?>
            <option value="<?= $fila['pkEstanteria'] ?>">
                <?= $fila['codigoEstanteria'] ?>
            </option>
            <?php endforeach; ?>
        </select>
        <br>
        <label>Subcategoria:</label>
        <br>
            <select name="fkSubCategoria" required>
        <option value="">Seleccione una subcategoria:</option>
                <?php foreach ($subCategoriaRe as $fila): ?>
            <option value="<?= $fila['pkSubCategoria'] ?>">
                <?= $fila['nombreSubCategoria'] ?>
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