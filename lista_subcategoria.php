<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>
    <h2>lista subcategorias:</h2>
    	<?php 
include('clases/subcategoria.php');
$clase = new Subcategoria();
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
			<td><?=$fila["nombreSubCategoria"]?></td>
			<td>(proximamente...)</td>
		</tr>
	<?php endforeach; 
    ?>
</table>
    
</body>
</html>