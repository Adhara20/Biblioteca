<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>
    <?php //Para usuario?
    // include('');
    // $clase = new
    // $resultado = $clase ->
    ?>
    <form action="controladores/insertar_prestamo.php" method="POST" enctype="multipart/form-data">
    <label>codigoPrestamo</label>
    <input type="text" name="codigoPrestamo" required>
    <br>
    <label>Fecha Limite</label>
    <input type="date" name="fechaLimite" required>
    <br>
    <label>Folio Contracto</label>
    <input type="text" name="folioContrato" required>
    <br>
    <label>Contracto</label>
    <input type="file" name="archivoContrato">
    <br>
    <label>Folio Copia</label>
    <input type="text" name="folio">
    <br> 
    <label>Usuario Solicitante</label>
    <input type="text" name="numCredS">
    <br>
    <label>Usuario Autorizante</label>
    <input type="text" name="numCredA">
    <br>    
        <input type="submit" value="Guardar">
    </form>
</body>
</html>