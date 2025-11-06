<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="../css/bootstrap.css">
</head>
<body>
      <?php 
		include('../clases/prestamo.php');
		$clase = new prestamo();
		$resultado = $clase->verPrestamo();
	?>

    <table class="table table-responsive">
    <tr>
        <th>Codigo Prestamo</th>
        <th>Fecha Registro</th>
        <th>Fecha Limite</th>
        <th>Fecha Entrega</th>
        <th>Folio Contracto</th>
        <th>Contracto</th>
        <th>Copia</th>
        <th>Solicitante</th>
        <th>Autorizante</th>
        <th>Estatus</th>
        <th>Estatus De Devolucion</th>
    </tr>
    <?php foreach ($resultado as $fila) { ?>
        <tr>
            <td><?=$fila["codigoPrestamo"]?></td>
            <td><?=$fila["fechaRegistro"]?></td>
            <td><?=$fila["fechaLimite"]?></td>
            <td><?=$fila["fechaEntrega"]?></td>
            <td><?=$fila["folioContrato"]?></td>
            <td><?=$fila["archivoContrato"]?></td>
            <td><?=$fila["isbnCopia"]?></td>
            <td><?=$fila["numSolicitante"]?></td>
            <td><?=$fila["numAutorizante"]?></td>
            <td><?=$fila["estatus"]?></td>
            <td><?=$fila["estatusDevolucion"]?></td>
        </tr>
    <?php } ?>
</table>
</body>
</html>