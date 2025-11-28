<!-- incluir Header y Menu-->
<?php 
include('../includes/header.php');
?>
<body class="bg-gray-100 text-gray-900">
  <?php include('../includes/menu.php'); ?>

  <!-- obtener datos de la copia -->
  <?php
  include('../clases/multa.php');
  $claseMulta = new Multa();
  include('../clases/prestamo.php');//Incluyes la clase
  $clase = new Prestamo();//creas instacia
  $pkPrestamo = $_GET['pkPrestamo'] ?? null;
  //Obtienes la pk 
  if (!$pkPrestamo) {
      echo "<p>No se especificó el préstamo.</p>";
      exit;
  }


  //Mandas a llamar la clase de detalles en la variable $resultado
  //Revicen en mi clase Libro como esta la funcion de detalles
  $resultado = $clase->detalles($pkPrestamo);
  

  if ($resultado && $resultado->num_rows > 0) {
      $fila = $resultado->fetch_assoc();
  } else {
      echo "<p>No se encontró el préstamo.</p>";
      exit;
  }
  // Llamar la clase para validar que multas tiene el prestamo
  $multas = $claseMulta->obtenerMultasPrestamo($pkPrestamo);

  $botonMulta = true;

  // no permitir si el prestamo NO está en proceso
  if ($fila['estatus'] !== 'EnProceso') {
      $botonMulta = false;
  }

  // no permitir si tiene multa de daño o perdido
  foreach ($multas as $multa) {
      if ($multa === "Daño" || $multa === "Perdido") {
          $botonMulta = false;
          break;
      }
  }
  ?>
  <!--  Título principal -->
  <div class="w-full flex flex-col items-start px-8 mt-8">
    <div class="w-full max-w-4xl mx-auto">
      <h1 class="titulos">Detalles del Préstamo</h1><!--Nomas le cambian por lo que vayan a mostrar--> 
      <hr class="linea-separadora mb-6">
    </div>
  </div>

  <!--  Contenedor principal: Contenido -->
   <!-- <div class="w-full max-w-5xl bg-white shadow-lg rounded-2xl p-8 border border-gray-300 mb-12 mx-auto flex flex-col md:flex-row gap-8"> -->
  <div class="w-full max-w-5xl bg-white shadow-lg rounded-2xl p-8 border border-gray-300 mb-12 mx-auto flex flex-col md:flex-row-reverse gap-8">

    <!--  Datos de la copia. (Aqui lo cambian por los datos de lo que les tocó) -->
    <div class="flex-1">
      <div class="mb-6 text-center md:text-left">
        <h2 class="text-2xl font-semibold text-[#4F0087]"><?= $fila['codigoPrestamo'] ?></h2><!--El nombre o codigo de lo que les tocó. En algunos casos, dependiendo, pueden omitirlo--> 
        <p class="text-gray-600">Información General</p><!--Lo dejan igual--> 
      </div>

      <div class="border-t border-gray-300 pt-4">
        <dl class="divide-y divide-gray-200">
          <!--  Estos son los datos-->
          <div class="py-3 grid grid-cols-3 gap-4">
            <dt class="font-medium text-gray-700">Fecha Registro:</dt>
            <dd class="col-span-2 text-gray-800"><?= $fila['fechaRegistro'] ?></dd>
          </div>

          <div class="py-3 grid grid-cols-3 gap-4">
            <dt class="font-medium text-gray-700">Fecha Limite:</dt>
            <dd class="col-span-2 text-gray-800"><?= $fila['fechaLimite'] ?></dd>
          </div>

          <div class="py-3 grid grid-cols-3 gap-4">
            <dt class="font-medium text-gray-700">Fecha Entrega:</dt>
            <dd class="col-span-2 text-gray-800"><?= $fila['fechaEntrega'] ?></dd>
          </div>

          <div class="py-3 grid grid-cols-3 gap-4">
            <dt class="font-medium text-gray-700">Folio Contrato:</dt>
            <dd class="col-span-2 text-gray-800"><?= $fila['folioContrato'] ?></dd>
          </div>

          <div class="py-3 grid grid-cols-3 gap-4">
            <dt class="font-medium text-gray-700">Contracto:</dt>
            <dd class="col-span-2 text-gray-800"><?= $fila['archivoContrato'] ?></dd>
          </div>

          <div class="py-3 grid grid-cols-3 gap-4">
            <dt class="font-medium text-gray-700">ISBN Copia:</dt>
            <dd class="col-span-2 text-gray-800"><?= $fila['isbnCopia'] ?></dd>
          </div>

          <div class="py-3 grid grid-cols-3 gap-4">
            <dt class="font-medium text-gray-700">Folio Copia:</dt>
            <dd class="col-span-2 text-gray-800"><?= $fila['folioCopia'] ?></dd>
          </div>

          <div class="py-3 grid grid-cols-3 gap-4">
            <dt class="font-medium text-gray-700">Usuario Solicitante:</dt>
            <dd class="col-span-2 text-gray-800"><?= $fila['numSolicitante'] ?></dd>
          </div>

          <div class="py-3 grid grid-cols-3 gap-4">
            <dt class="font-medium text-gray-700">Usuario Autorizante:</dt>
            <dd class="col-span-2 text-gray-800"><?= $fila['numAutorizante'] ?></dd>
          </div>

        </dl>
      </div>

      <div class="py-3 grid grid-cols-3 gap-4">
                <dt class="font-medium text-gray-700">Estatus:</dt>
                <?php
                if($fila['estatus'] == 'EnProceso'){
                    $estatus ='En Proceso';
                    $color= 'text-blue-500 font-semibold [text-shadow:0_2px_4px_rgba(0,0,0,.3)]';
                }else if($fila['estatus'] == 'Cancelado'){
                    $estatus ='Cancelado';
                    $color= 'text-red-400 font-semibold [text-shadow:0_2px_4px_rgba(0,0,0,.3)]';
                }else if($fila['estatus'] == 'Completado'){
                    $estatus ='Completado';
                    $color= 'text-emerald-400 font-semibold [text-shadow:0_2px_4px_rgba(0,0,0,.3)]';
                }
                ?>
                <dd class="col-span-2 <?= $color ?>"><?= $estatus ?></dd>
            </div>

          <div class="py-3 grid grid-cols-3 gap-4">
                <dt class="font-medium text-gray-700">Estatus De Devolucion:</dt>
                <?php
                $hoy = date('Y-m-d');

                if($fila['estatus'] == 'EnProceso'){
                    if ($hoy > $fila['fechaLimite']) {
                        $estatusDevolucion = 'Vencido';
                        $colorDevolucion = 'text-amber-600 font-semibold [text-shadow:0_2px_4px_rgba(0,0,0,.3)]';
                    } elseif ($hoy <= $fila['fechaLimite']) {
                        $estatusDevolucion = 'A Tiempo';
                        $colorDevolucion = 'text-green-500 font-semibold [text-shadow:0_2px_4px_rgba(0,0,0,.3)]';
                    }
                    }else{
        if($fila['estatusDevolucion'] == 'ATiempo'){
                    $estatusDevolucion ='A Tiempo';
                    $colorDevolucion= 'text-green-500 font-semibold [text-shadow:0_2px_4px_rgba(0,0,0,.3)]';
                }else if($fila['estatusDevolucion'] == 'Vencido'){
                    $estatusDevolucion ='Vencido';
                    $colorDevolucion= 'text-amber-600 font-semibold [text-shadow:0_2px_4px_rgba(0,0,0,.3)]';
                }
    }
                ?>
                <dd class="col-span-2 <?= $colorDevolucion ?>"><?= $estatusDevolucion ?></dd>
            </div>
      <!-- Solo admins/Blibliotecarios< -->
       <?php if($rol != 'L'): ?>
      <!-- Botones de acción | Se queda igual | Reemplazar con nueva actualizacion... -->
      <div class="flex justify-end gap-3 mt-8">
        <a href="editar_prestamo.php?pkPrestamo=<?= $fila['pkPrestamo'] ?>" 
        class="px-4 py-2.5 rounded-md font-medium transition border border-[#5780B5] text-[#5780B5] bg-blue-200 
          hover:bg-[#5780B5] hover:text-blue-200  shadow-sm">
          Editar
        </a>
        <?php if($botonMulta): ?>
        <a href="formulario_multa.php?codigoPrestamo=<?= $fila['codigoPrestamo'] ?>" 
        class="px-4 py-2.5 rounded-md text-white font-medium transition bg-[#5780B5] hover:bg-[#6b92c2] shadow-sm">
          Multar
        </a>
        <?php endif; ?>
        <?php
          if($fila['estatus'] == 'EnProceso'){
        ?>
          <a href="../controladores/cancelar_prestamo.php?pkPrestamo=<?= $fila['pkPrestamo'] ?>" class="px-4 py-2.5 rounded-md text-white font-medium transition bg-[#B55780] hover:bg-[#c46b93] shadow-sm">
          Cancelar
          </a>
          <a href="../controladores/Completar_prestamo.php?pkPrestamo=<?= $fila['pkPrestamo'] ?>" class="px-4 py-2.5 rounded-md text-white font-medium transition bg-[#57b589] hover:bg-[#80d692] shadow-sm">
          Completar
          </a>
        <?php
          }
        ?>
        
      </div>
      <!-- >Solo admin/Bibliotecarios -->
       <?php endif; ?>
    </div>
  </div>
       
  <?php include('../includes/footer.php'); ?>
</body>
</html>
