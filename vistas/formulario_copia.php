<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>
      <!-- Recivir el mensaje de error o de que se registro desde inserta -->
  <?php if (isset($_GET['error'])){ ?>
      <div style="color: red; font-weight: bold;">
          <?= htmlspecialchars($_GET['error']) ?>
      </div>
  <?php }?>
  <?php
    include('../clases/estanterias.php');

    $clase = new Estanterias();
    $resultado = $clase ->  listaActivos();
  ?>
    <form action="../controladores/insertar_copia.php" method="POST">
  <h2>Registrar Copia</h2>

  <label>ISBN</label>
  <input type="text" name="isbn" required>
    <br>
  <label>Estanteria</label>
  <select name="fkEstanteria">
			<option>Seleccione un estante</option>
			<?php 
				foreach ($resultado as $fila) {
			?>
				<option value="<?=$fila['pkEstanteria']?>"><?=$fila['codigoEstanteria']?> </option>	
			<?php
				}
		     ?>
    </select> <br>  
  <input type="submit" value="Guardar">
</form> 
</body>
</html>