<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Lista URLs</title>
</head>

<body>
	<h2>Lista de URLs:</h2>
	<?php
	include('../clases/url.php');

	$clase = new URL();
	$resultado = $clase->listaURLs();
	?>
	<table border="1" cellpadding="5">
		<th>ID</th>
		<th>URL</th>
		<th>Libro</th>
		</tr>
		<?php
		foreach ($resultado as $fila):
		?>
			<tr>
				<td><?= $fila["pkUrl"] ?></td>
				<td><?= $fila["url"] ?></td>
				<td><?= $fila["fkLibro"] ?></td>
				<td>(proximamente...)</td>
			</tr>
		<?php endforeach;
		?>
	</table>

</body>

</html>