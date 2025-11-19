<?php
$isbn = $_POST['isbn'];
$fkEstanteria = $_POST['fkEstanteria'];

include('../clases/copia.php');


$clase = new Copia();

$resultado = $clase ->guardar($isbn, $fkEstanteria);

if ($resultado) {
        header("Location: ../vistas/lista_copias.php?success=Copia Física registrada correctamente");
        exit;
    } else {
        header("Location: ../vistas/formulario_copia.php?error=Error al registrar Copia Física");
        exit;
    }
?>