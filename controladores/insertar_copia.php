<?php
require_once('../includes/auth.php');

// Solo Admin y Bibliotecario
requireRole(['A', 'B']);
?>

<?php
$isbn = $_POST['isbn'];
$observaciones = empty($_POST['observaciones']) ? null : $_POST['observaciones'];
// $observaciones = $_POST['observaciones'];
include('../clases/copia.php');


$clase = new Copia();

$resultado = $clase ->guardar($isbn, $observaciones);

if ($resultado) {
        header("Location: ../vistas/lista_copias.php?success=Copia Física registrada correctamente");
        exit;
    } else {
        header("Location: ../vistas/formulario_copia.php?error=Error al registrar Copia Física");
        exit;
    }
?>