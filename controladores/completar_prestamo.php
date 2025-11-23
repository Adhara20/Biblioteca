<?php
    $pkPrestamo=$_GET['pkPrestamo'];

    include('../clases/prestamo.php');
    $clase= new Prestamo();

    $resultado = $clase->completar($pkPrestamo);
    if($resultado){
        header('Location: ../vistas/lista_prestamos.php?success=Prestamo completado con Exito');
        exit;
    }else{
        header('Location: ../vistas/lista_prestamos.php?error=Error al completar Prestamo');
        exit;
    }

?>