<?php
$numCredencial = $_POST['numCredencial'];
$pass = $_POST['pass'];

include('../clases/usuario.php');
$clase = new Usuario();
$resultado = $clase-> login($numCredencial, $pass);

// validar si hay registros
if (mysqli_num_rows($resultado) > 0) {
    $datos = mysqli_fetch_assoc($resultado);
    session_start();

    // Variables de sesión
    $_SESSION['pkUsuarioLog'] = $datos['pkUsuario'];
    $_SESSION['numCredencial'] = $datos['numCredencial'];
    $_SESSION['nombre'] = $datos['nombre'];
    $_SESSION['rol'] = $datos['rol']; 
    
    header('Location: ../index.php');
    exit;
} else {
    header('Location: ../vistas/login.php?error=Credenciales incorrectas');
    exit;
}
?>
