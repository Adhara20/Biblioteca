<?php
    //require_once("../clases/prestamo.php");
    //$clasePrestamo = new Prestamo();
    //$resultadoPrestamos = $clasePrestamo->listaPrestamosActivos();
    ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Formulario Multa</title>
</head>

<body>
    <form action="../Controladores/insertar_multa.php" method="POST">
        <h3>Registrar Multa</h3>


        <label>Tipo de Multa:</label><br>
        <select name="tipoMulta" required>
            <option value="">Seleccione un tipo</option>
            <option value="Retraso">Retraso</option>
            <option value="Daño">Daño</option>
            <option value="Perdido">Perdido</option>
        </select><br><br>

        <label>Monto:</label><br>
        <input type="number" step="0.01" name="montoMulta" required><br>

        <label>Fecha de Registro:</label><br>
        <input type="date" name="fechaRegistro" required><br>

        <label>Fecha de Pago:</label><br>
        <input type="date" name="fechaPago"><br>

        <label>Préstamo Relacionado:</label><br>
        <input type="text" name="fkPrestamo" placeholder="Escribe el número del préstamo existente" required><br><br>


        <input type="submit" value="Guardar">
    </form>
</body>

</html>