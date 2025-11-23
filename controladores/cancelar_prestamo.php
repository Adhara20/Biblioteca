<?php
    $pkPrestamo=$_GET['pkPrestamo'];

    include('../clases/prestamo.php');
    $clase= new Prestamo();

    $resultado = $clase->cancelar($pkPrestamo);
    if($resultado){
        header('Location: ../vistas/lista_prestamos.php?success=Prestamo cancelado con Exito');
        exit;
    }else{
        header('Location: ../vistas/lista_prestamos.php?error=Error al cancelar Prestamo');
        exit;
    }

?>