<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
</head>
<body>
    <?php
    include('clases/usuario.php');
    $clase = new Usuario();
    ?>
    <div>
        <section>
            <h1>Lista Usuarios Activos</h1>
    <?php 
    
    $resultadoA = $clase->listaUsuarioActivos();
    ?>
    <table>
        <tr>
            <th>Núm. Credencial</th>
            <th>username</th>
            <th>CURP</th>
            <th>Rol</th>
            <th>Nombre Completo</th>
            <th>Acciones</th>
        </tr>
        <?php
            foreach($resultadoA as $fila){
        ?>
            <tr>
                <td style="text-center"><?=$fila["numCredencial"]?></td>
                <td style="text-center"><?=$fila["username"]?></td>
                <td style="text-center"><?=$fila["curp"]?></td>
                <td style="text-center"><?=$fila["rol"]?></td>
                <td style="text-center"><?=$fila["nombreCompleto"]?></td>
                <td style="text-center">(proximamente...)</td>
            </tr>
        <?php
            }
        ?>
    </table>
        </section>
    </div>
    <br>
    <div>
        <section>
            <h1>Lista Usuarios Inactivos</h1>
    <?php 
    
    $resultadoA = $clase->listaUsuarioInactivos();
    ?>
    <table>
        <tr>
            <th>Núm. Credencial</th>
            <th>username</th>
            <th>CURP</th>
            <th>Rol</th>
            <th>Nombre Completo</th>
            <th>Acciones</th>
        </tr>
        <?php
            foreach($resultadoA as $fila){
        ?>
            <tr>
                <td style="text-center"><?=$fila["numCredencial"]?></td>
                <td style="text-center"><?=$fila["username"]?></td>
                <td style="text-center"><?=$fila["curp"]?></td>
                <td style="text-center"><?=$fila["rol"]?></td>
                <td style="text-center"><?=$fila["nombreCompleto"]?></td>
                <td style="text-center">(proximamente...)</td>
            </tr>
        <?php
            }
        ?>
    </table>
        </section>
    </div>
</body>
</html>