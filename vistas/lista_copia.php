<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/copias.css">
</head>
<?php 
        include('../includes/header.php');
	?>
<body>
      <?php 
		include('../clases/copia.php');
		$clase = new Copia();
		$resultado = $clase->lista();
        include('../includes/menu.php');
	?>
    <div class="px-10 mb-4">
    <h1 class="titulos">Registro de Copias</h1>
    <hr class="linea-separadora-listas">
    </div>
    <div class="tabla-copias-container">
    <table class="table-copias">
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
</div>
</body>
</html>