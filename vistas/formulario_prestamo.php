<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>
    <?php
    //not yet
    ?>

    <form action="../controladores/insertar_prestamo.php" method="POST" enctype="multipart/form-data">
    <label>Codigo Prestamo</label>
    <input type="text" name="codigo" required>
    <br>
    <label>Fecha Limite</label>
    <input type="date" name="fechaLimite" required>
    <br>
    <label>Folio Contracto</label>
    <input type="text" name="folio" required>
    <br>
    <label>Contracto</label>
    <input type="file" name="contracto">
    <br> 
    <label>Usuario Solicitante</label>
    <input type="text" name="solicita">
    <br>
    <label>Usuario Autorizante</label>
    <input type="text" name="autoriza">
    <br>    
        <input type="submit" value="Guardar">
    </form>
</body>
</html>