<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<title>Lista Nacionalidades</title>
</head>

<body>
	<h2>Lista de Nacionalidades:</h2>
    <form action="../controladores/buscar_nacionalidad.php" method="GET">
		<h3>Buscar Nacionalidad</h3>
		<input type="text" name="buscador" required placeholder="Ejemplo: Mexicana">
		<button type="submit">Buscar</button>
	</form>

	<?php
	include('../clases/nacionalidad.php');
	$nac = new Nacionalidad();
	$resultado = $nac->listaNacionalidades();
	?>
	<table border="1" cellpadding="5">
		<tr>
			<th>ID</th>
			<th>Nacionalidad</th>
		</tr>
		<?php while ($fila = $resultado->fetch_assoc()): ?>
			<tr>
				<td><?= $fila['pkNacionalidad'] ?></td>
				<td><?= $fila['nombreNaci'] ?></td>
			</tr>
		<?php endwhile; ?>
	</table>
</body>

</html>