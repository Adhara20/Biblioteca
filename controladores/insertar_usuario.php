<?php
// Datos de usuario
//Elimine: $numCredencial = $_POST['numCredencial'];
$nombres = strtoupper($_POST['nombres']);//strtoupper (se lo ponen a todo lo que sea texto que no afecte que no tenga minusculas)
$apaterno = strtoupper($_POST['apaterno']);//Es para que el dato se guarde como MAYUSCULAS
$amaterno = strtoupper($_POST['amaterno']);
$curp = strtoupper($_POST['curp']);
$fechaNac = $_POST['fechaNac'];
$sexo = $_POST['sexo'];
$pass = $_POST['pass'];
$correo = $_POST['correo'];
$foto = $_FILES['foto']['name']; 
$ruta = $_FILES['foto']['tmp_name'];
move_uploaded_file($ruta, '../imagenes/usuarios/'.$foto);
$rol = $_POST['rol'];
//Incluir la clase
include('../clases/usuario.php');
//Instancia
$clase = new Usuario();
// Validar si ya existe esa CURP con ese tipo
if ($clase->existeCurpTipo($curp, $rol)) {
    header("Location: ../vistas/formulario_usuario.php?error=Ya existe un usuario con esa CURP y ese tipo de cuenta");

    exit;
} else {                        //Elimine $numCredencial
    $resultado = $clase->guardar($nombres, $apaterno, $amaterno, $curp, $fechaNac, $sexo, $pass, $correo, $foto, $rol);
    if ($resultado) {
        header("Location: ../vistas/lista_usuarios.php?success=Usuario registrado correctamente");
        exit;
    } else {
        header("Location: ../vistas/formulario_usuario.php?error=Error al registrar el usuario");
        exit;
    }
}

