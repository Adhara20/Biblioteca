<?php
require_once('../includes/auth.php');

// Solo Admin y Bibliotecario
requireRole(['A', 'B']);
?>

<?php
    $pkPrestamo=$_GET['pkPrestamo'];

    include('../clases/prestamo.php');
    $clase= new Prestamo();

    $resultado = $clase->completar($pkPrestamo);

    if($resultado == 'MultasPendientes'){
        header('Location: ../vistas/lista_prestamos.php?error=No se puede completar el prestamo, el Usuario tiene multas pendientes');
        exit;
    }
    
    if($resultado){
        header('Location: ../vistas/lista_prestamos.php?success=Prestamo completado con Exito');
        exit;
    }else{
        header('Location: ../vistas/lista_prestamos.php?error=Error al completar Prestamo');
        exit;
    }

?>