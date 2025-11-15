<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Lista de urls</title>
	<link rel="stylesheet" href="../css/bootstrap.css">
	<link rel="stylesheet" href="../css/copias.css">
</head>
<?php
include('../includes/header.php');
?>

<body>
	<?php
	include('../clases/url.php');
	$clase = new URL();
	$resultado = $clase->listaURLs();
	include('../includes/menu.php');
	?>
	<div class="px-10 mb-4">
		<h1 class="titulos">Registro de urls</h1>
		<hr class="linea-separadora-listas">
	</div>
	<div class="tabla-copias-container">
		<table class="table-copias">
			<th>URL</th>
			<th>Libro</th>
			</tr>
			<?php
			foreach ($resultado as $fila):
			?>
				<tr>

					<td><?= $fila["url"] ?></td>
					<td><?= $fila["fkLibro"] ?></td>

				</tr>
			<?php endforeach;
			?>
		</table>
	</div>
</body>

</html>