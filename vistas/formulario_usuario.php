<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registrar Usuario</title>
</head>
<body>
    <!-- Recivir el mensaje de error o de que se registro desde inserta -->
<?php if (isset($_GET['error'])){ ?>
    <div style="color: red; font-weight: bold;">
        <?= htmlspecialchars($_GET['error']) ?>
    </div>
<?php }?>

  <form action="../controladores/insertar_usuario.php" method="POST" enctype="multipart/form-data">
    <h1>Registrar Usuario</h1>
    <!-- Despues hacer que el número se autorellene(ej. OB-0000001) -->
    <!-- Ya se auto completa, se eliminó -->
    <label>Nombre(s):</label>
    <input type="text" name="nombres" placeholder="Nombre(s)" required>
    <label>Apellido Paterno</label>
    <input type="text" name="apaterno" placeholder="Apellido Paterno" required>
    <label>Apellido Materno</label>
    <input type="text" name="amaterno" placeholder="Apellido Materno">
    <label>CURP:</label>
    <input type="text" name="curp" placeholder="CURP" required>
    <label>Fecha de Nacimiento</label>
    <input type="date" name="fechaNac" required>
    <!-- Despues quitar este campo y buscar la forma de que se calcule con la fecha actual y la de nacimiento(ya!) -->
    <label>Sexo:</label>
    <select name="sexo" required>
        <option value="M">Masculino</option>
        <option value="F">Femenino</option>
    </select>
    <label>Contraseña</label>
    <input type="password" name="pass" placeholder="De 8 a 20 caracteres" minlength="8" maxlength="20" required>
    <label>Correo</label>
    <input type="email" name="correo" placeholder="correo electronico" required>
    <label>Rol</label>
    <label for="foto">Foto de Usuario</label>
    <input type="file" name="foto">
    <select name="rol" required>
        <option value="L">Lector</option>
        <option value="B">Bibliotecario</option>
        <option value="A">Admin</option>
    </select>
    
    <button type="submit">Guardar</button>
  </form>
</body>
</html>
