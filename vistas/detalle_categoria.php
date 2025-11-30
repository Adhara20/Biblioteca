<!-- incluir Header y Menu-->
<?php 
include('../includes/header.php');
?>
<body class="bg-gray-100 text-gray-900">
  <?php include('../includes/menu.php'); ?>

  <!-- obtener datos del libro -->
  <?php
  include('../clases/categoria.php');//Incluyes la clase
  $clase = new Categoria();//creas instacia
  $pkCategoria = $_GET['pkCategoria'] ?? null;
  //Obtienes la pk de libro
  if (!$pkCategoria) {
      echo "<p>No se especificó la categoria.</p>";
      exit;
  }
  //Mandas a llamar la clase de detalles en la variable $resultado
  //Revicen en mi clase Libro como esta la funcion de detalles
  $resultado = $clase->detalles($pkCategoria);

  if ($resultado && $resultado->num_rows > 0) {
      $fila = $resultado->fetch_assoc();
  } else {
      echo "<p>No se encontró la categoria.</p>";
      exit;
  }

  // Mostrar Imagen (usa placeholder si no hay)
  $imgRuta = !empty($fila['iconoCategoria'])
      ? "../imagenes/categorias/{$fila['iconoCategoria']}"
      : "../imagenes/categorias/placeholder.png";
  ?>
  <!--  Título principal -->
  <div class="w-full flex flex-col items-start px-8 mt-8">
    <div class="w-full max-w-4xl mx-auto">
      <h1 class="titulos">Detalles de la categoría</h1><!--Nomas le cambian por lo que vayan a mostrar--> 
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
        alt="Icono de <?= htmlspecialchars($fila['iconoCategoria']) ?>" 
        class="rounded-xl shadow-md border border-gray-200 object-cover w-64 h-96 bg-gray-50"
      >
    </div>

    <!--  Datos del libro. (Aqui lo cambian por los datos de lo que les tocó) -->
    <div class="flex-1">
      <div class="mb-6 text-center md:text-left">
        <h2 class="text-2xl font-semibold text-[#4F0087]"><?= $fila['nombreCategoria'] ?></h2><!--El nombre o codigo de lo que les tocó. En algunos casos, dependiendo, pueden omitirlo--> 
        <p class="text-gray-600">Información General</p><!--Lo dejan igual--> 
      </div>

      <div class="border-t border-gray-300 pt-4">
        <dl class="divide-y divide-gray-200">
          <!--  Estos son los datos-->
          <div class="py-3 grid grid-cols-3 gap-4">
            <dt class="font-medium text-gray-700">Nombre:</dt>
            <dd class="col-span-2 text-gray-800"><?= $fila['nombreCategoria'] ?></dd>
          </div>
          <!-- !!!!! -->
          <!-- Agregen esto al final pero antes de los botones, cpien y peguen tal cual ->> -->
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
            <!-- <<- -->

        </dl>
      </div>

      <!-- Botones de acción | Se queda igual -->
      <div class="flex justify-end gap-3 mt-8">
        <a href="editar_categoria.php?pkCategoria=<?= $fila['pkCategoria'] ?>" 
        class="px-4 py-2.5 rounded-md text-white font-medium transition bg-[#5780B5] hover:bg-[#6b92c2] shadow-sm">
          Editar
        </a>
        <!-- !!!!!! -->
        <!-- Copian de aquí: -->
        <!-- Validar Estatus para mostrar Botón -->
        <?php
          if($fila['estatus'] == 'A'){
        ?>
          <a href="../controladores/desactivar_categoria.php?pkCategoria=<?= $fila['pkCategoria'] ?>" class="px-4 py-2.5 rounded-md text-white font-medium transition bg-[#B55780] hover:bg-[#c46b93] shadow-sm">
          Dar de baja
        </a>
        <?php
          }
        ?>
        <!-- : Hasta acá y reemplazan el botón de Dar de Baja -->
      </div>
    </div>
  </div>

  <?php include('../includes/footer.php'); ?>
</body>
</html>
