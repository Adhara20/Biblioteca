<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/prestamos.css">
</head>
<?php 
  include('../includes/header.php');
?>

<body>
  <?php 
    include('../clases/prestamo.php');
    $clase = new prestamo();
    $resultado = $clase->verPrestamo();
    include('../includes/menu.php');
  ?>

  <div class="px-10 mb-4">
    <h1 class="titulos">Registro de Préstamos</h1>
    <hr class="linea-separadora-listas">
  </div>

  <div class="tabla-prestamos-container">
    <table class="table-prestamos">
      <thead>
        <tr>
          <th>Código</th>
          <th>Fecha Registro</th>
          <th>Fecha Límite</th>
          <th>Fecha Entrega</th>
          <th>Folio Contrato</th>
          <th>Contrato</th>
          <th>Copia</th>
          <th>Solicitante</th>
          <th>Autorizante</th>
          <th>Estatus</th>
          <th>Devolución</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($resultado as $fila): ?>
          <tr>
            <td data-label="Código"><?= htmlspecialchars($fila["codigoPrestamo"]) ?></td>
            <td data-label="Fecha Registro"><?= htmlspecialchars($fila["fechaRegistro"]) ?></td>
            <td data-label="Fecha Límite"><?= htmlspecialchars($fila["fechaLimite"]) ?></td>
            <td data-label="Fecha Entrega"><?= htmlspecialchars($fila["fechaEntrega"]) ?></td>
            <td data-label="Folio Contrato"><?= htmlspecialchars($fila["folioContrato"]) ?></td>
            <td data-label="Contrato"><?= htmlspecialchars($fila["archivoContrato"]) ?></td>
            <td data-label="Copia"><?= htmlspecialchars($fila["isbnCopia"]) ?></td>
            <td data-label="Solicitante"><?= htmlspecialchars($fila["numSolicitante"]) ?></td>
            <td data-label="Autorizante"><?= htmlspecialchars($fila["numAutorizante"]) ?></td>
            <td data-label="Estatus"><?= htmlspecialchars($fila["estatus"]) ?></td>
            <td data-label="Devolución"><?= htmlspecialchars($fila["estatusDevolucion"]) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <?php include('../includes/footer.php'); ?>
</body>
</html>