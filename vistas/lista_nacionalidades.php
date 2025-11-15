<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Lista de nacionalidades</title>
	<link rel="stylesheet" href="../css/bootstrap.css">
	<link rel="stylesheet" href="../css/copias.css">
</head>
<?php
include('../includes/header.php');
?>

<body>
	<?php
	include('../clases/nacionalidad.php');
	$nac = new Nacionalidad();
	$resultado = $nac->listaNacionalidades();
	include('../includes/menu.php');
	?>
	<div class="px-10 mb-4">
		<h1 class="titulos">Registro de Copias</h1>
		<hr class="linea-separadora-listas">
	</div>
	<div class="tabla-copias-container">
		<table class="table-copias">
			<tr>

				<th>Nacionalidad</th>
			</tr>
			<?php while ($fila = $resultado->fetch_assoc()): ?>
				<tr>

					<td><?= $fila['nombreNaci'] ?></td>
				</tr>
			<?php endwhile; ?>
		</table>
	</div>
</body>

</html>