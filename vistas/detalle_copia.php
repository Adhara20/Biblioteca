<!-- incluir Header y Menu-->
<?php 
include('../includes/header.php');
?>
<body class="bg-gray-100 text-gray-900">
  <?php include('../includes/menu.php'); ?>

  <!-- obtener datos de la copia -->
  <?php
  include('../clases/copia.php');//Incluyes la clase
  $clase = new Copia();//creas instacia
  $pkCopiaF = $_GET['pkCopiaF'] ?? null;
  //Obtienes la pk 
  if (!$pkCopiaF) {
      echo "<p>No se especificó la copia.</p>";
      exit;
  }
  //Mandas a llamar la clase de detalles en la variable $resultado
  //Revicen en mi clase Libro como esta la funcion de detalles
  $resultado = $clase->detalles($pkCopiaF);

  if ($resultado && $resultado->num_rows > 0) {
      $fila = $resultado->fetch_assoc();
  } else {
      echo "<p>No se encontró la copia.</p>";
      exit;
  }

  // Mostrar Imagen (usa placeholder si no hay)
  $imgRuta = !empty($fila['portada'])
      ? "../imagenes/portadas/{$fila['portada']}"
      : "../imagenes/portadas/placeholder.png";
  ?>
  <!--  Título principal -->
  <div class="w-full flex flex-col items-start px-8 mt-8">
    <div class="w-full max-w-4xl mx-auto">
      <h1 class="titulos">Detalles de la Copia</h1><!--Nomas le cambian por lo que vayan a mostrar--> 
      <hr class="linea-separadora mb-6">
    </div>
  </div>

  <!--  Contenedor principal: Contenido -->
   <!-- <div class="w-full max-w-5xl bg-white shadow-lg rounded-2xl p-8 border border-gray-300 mb-12 mx-auto flex flex-col md:flex-row gap-8"> -->
  <div class="w-full max-w-5xl bg-white shadow-lg rounded-2xl p-8 border border-gray-300 mb-12 mx-auto flex flex-col md:flex-row-reverse gap-8">


    <!--  Portada del libro (Si es algo que no lleve imagen, pueden omitirla)-->
    <div class="flex-shrink-0 w-full md:w-1/3 flex justify-center items-start">
      <img 
        src="<?= $imgRuta ?>" 
        alt="Portada de <?= htmlspecialchars($fila['portada']) ?>" 
        class="rounded-xl shadow-md border border-gray-200 object-cover w-64 h-96 bg-gray-50"
      >
    </div>

    <!--  Datos de la copia. (Aqui lo cambian por los datos de lo que les tocó) -->
    <div class="flex-1">
      <div class="mb-6 text-center md:text-left">
        <h2 class="text-2xl font-semibold text-[#4F0087]"><?= $fila['titulo'] ?></h2><!--El nombre o codigo de lo que les tocó. En algunos casos, dependiendo, pueden omitirlo--> 
        <p class="text-gray-600">Información General</p><!--Lo dejan igual--> 
      </div>

      <div class="border-t border-gray-300 pt-4">
        <dl class="divide-y divide-gray-200">
          <!--  Estos son los datos-->
          <div class="py-3 grid grid-cols-3 gap-4">
            <dt class="font-medium text-gray-700">ISBN:</dt>
            <dd class="col-span-2 text-gray-800"><?= $fila['isbn'] ?></dd>
          </div>

          <div class="py-3 grid grid-cols-3 gap-4">
            <dt class="font-medium text-gray-700">Folio:</dt>
            <dd class="col-span-2 text-gray-800"><?= $fila['folio'] ?></dd>
          </div>

          <div class="py-3 grid grid-cols-3 gap-4">
            <dt class="font-medium text-gray-700">Titulo:</dt>
            <dd class="col-span-2 text-gray-800"><?= $fila['titulo'] ?></dd>
          </div>

          <div class="py-3 grid grid-cols-3 gap-4">
            <dt class="font-medium text-gray-700">Subcategoría:</dt>
            <dd class="col-span-2 text-gray-800"><?= $fila['nombreSubCategoria'] ?></dd>
          </div>

          <div class="py-3 grid grid-cols-3 gap-4">
            <dt class="font-medium text-gray-700">Observaciones:</dt>
            <dd class="col-span-2 text-gray-700 text-justify"><?= $fila['observaciones'] ?></dd>
          </div>

        </dl>
      </div>

      <div class="py-3 grid grid-cols-3 gap-4">
                <dt class="font-medium text-gray-700">Estatus:</dt>
                <?php
                if($fila['estatus'] == 'A'){
                    $estatus ='ACTIVO';
                    $color= 'text-green-500 font-semibold [text-shadow:0_2px_4px_rgba(0,0,0,.3)]';
                }else{
                    $estatus ='INACTIVO';
                    $color= 'text-red-400 font-semibold [text-shadow:0_2px_4px_rgba(0,0,0,.3)]';
                }
                ?>
                <dd class="col-span-2 <?= $color ?>"><?= $estatus ?></dd>
            </div>

        <div class="py-3 grid grid-cols-3 gap-4">
                <dt class="font-medium text-gray-700">Disponibilidad:</dt>
                <?php
                if($fila['disponibilidad'] == 'Disponible'){
                    $estatus ='Disponible';
                    $color= 'text-blue-500 font-semibold [text-shadow:0_2px_4px_rgba(0,0,0,.3)]';
                }else{
                    $estatus ='Prestado';
                    $color= 'text-amber-600 font-semibold [text-shadow:0_2px_4px_rgba(0,0,0,.3)]';
                }
                ?>
                <dd class="col-span-2 <?= $color ?>"><?= $estatus ?></dd>
            </div>

      <!-- Botones de acción | Se queda igual -->
      <div class="flex justify-end gap-3 mt-8">
        <a href="editar_copia.php?pkCopiaF=<?= $fila['pkCopiaF'] ?>" 
        class="px-4 py-2.5 rounded-md font-medium transition border border-[#5780B5] text-[#5780B5] bg-blue-200 
          hover:bg-[#5780B5] hover:text-blue-200  shadow-sm">
          Editar
        </a>
        <?php
          if($fila['estatus'] == 'A'){
        ?>
          <a href="../controladores/desactivar_copia.php?pkCopiaF=<?= $fila['pkCopiaF'] ?>" class="px-4 py-2.5 rounded-md text-white font-medium transition bg-[#B55780] hover:bg-[#c46b93] shadow-sm">
          Dar de baja
        </a>
        <?php
          }
        ?>
        
      </div>
    </div>
  </div>
       
  <?php include('../includes/footer.php'); ?>
</body>
</html>
