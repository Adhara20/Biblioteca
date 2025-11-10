<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="../css/bootstrap.css">
</head>
<form action="../controladores/buscar_copia.php">
  <h3>Buscar</h3>
  <input type="text" name="buscador" required> 
  <button type="submit">Buscar</button>
</form>
<body>
      <?php 
		include('../clases/copia.php');
		$clase = new Copia();
		$resultado = $clase->lista();
	?>

    <table class="table table-responsive">
    <tr>
        <th>ISBN</th>
        <th>Folio</th>
        <th>Título</th>
        <th>Subcategoría</th>
        <th>Estantería</th>
    </tr>
    <?php foreach ($resultado as $fila) { ?>
        <tr>
            <td><?=$fila["isbn"]?></td>
            <td><?=$fila["folio"]?></td>
            <td><?=$fila["titulo"]?></td>
            <td><?=$fila["nombreSubCategoria"]?></td>
            <td><?=$fila["codigoEstanteria"]?></td>
        </tr>
    <?php } ?>
</table>
</body>
</html>