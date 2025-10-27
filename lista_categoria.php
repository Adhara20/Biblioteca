<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>
    <h2>lista categorias:</h2>
    	<?php 
include('clases/categoria.php');
$clase = new Categoria();
$resultado = $clase->mostrar();
?>
<table border="1" cellpadding="5" >
		<th>Nombre</th>
		<th>Acciones</th>
	</tr>
	<?php
	foreach ($resultado as $fila):
		?>
		<tr>
			<td><?=$fila["nombreCategoria"]?></td>
			<td>(proximamente...)</td>
		</tr>
	<?php endforeach; 
    ?>
</table>
    
</body>
</html>