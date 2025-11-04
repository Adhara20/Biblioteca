<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
</head>
<body>
    <?php
    include('../clases/usuario.php');
    $clase = new Usuario();
    ?>
    <div>
        <section>
            <h1>Lista Usuarios Activos</h1>
    <?php 
    
    $resultadoA = $clase->listaActivos();
    ?>
    <!-- Mostrar que se guardó el usuario -->
    <?php if (isset($_GET['success'])){ ?>
        <div style="color: green; font-weight: bold;">
            <?= htmlspecialchars($_GET['success']) ?>
        </div>
    <?php }
    ?>

        <table>
            <tr>
                <th>Núm. Credencial</th>
                <th>CURP</th>
                <th>Rol</th>
                <th>Nombre Completo</th>
                <th>Fecha de Nacimiento</th>
                <th>Edad</th>
                <th>Acciones</th>
            </tr>
            <?php
    foreach($resultadoA as $fila){
        //Traducir Rol. "match" es como un Switch Case mas corto(se puede usar Switch o if)
        $rolTraducido = match($fila["rol"]) {
            'A' => 'Administrador',
            'B' => 'Bibliotecario',
            'L' => 'Lector',
        };
    ?>
        <tr>
            <td><?=$fila["numCredencial"]?></td>
            <td><?=$fila["curp"]?></td>
            <td><?=$rolTraducido?></td>
            <td><?=$fila["nombreCompleto"]?></td>
            <td><?=$fila["fechaNac"]?></td>
            <td><?= $clase->obtenerEdad($fila["fechaNac"]) ?></td>
            <td>(proximamente...)</td>
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

        $resultadoI = $clase->listaInactivos();
        ?>
        <table>
            <tr>
                <th>Núm. Credencial</th>
                <th>CURP</th>
                <th>Rol</th>
                <th>Nombre Completo</th>
                <th>Fecha de Nacimiento</th>
                <th>Edad</th>
                <th>Acciones</th>
            </tr>
            <?php
    foreach($resultadoI as $fila){
        //Traducir Rol
    $rolTraducido = match($fila["rol"]) {
        'A' => 'Administrador',
        'B' => 'Bibliotecario',
        'L' => 'Lector',
        default => 'Desconocido'
    };
    ?>
        <tr>
            <td><?=$fila["numCredencial"]?></td>
            <td><?=$fila["curp"]?></td>
            <td><?=$rolTraducido?></td>
            <td><?=$fila["nombreCompleto"]?></td>
            <!-- <td><?=$fila["fechaNac"]?></td> -->
            <td><?= $clase->obtenerEdad($fila["fechaNac"]) ?></td>
            <td>(proximamente...)</td>
        </tr>
    <?php
    }
    ?>
        </table>
            </section>
        </div>
</body>
</html>