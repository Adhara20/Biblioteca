<!-- Recibir los mensajes enviados desde los controladores -->
<!-- success = mensaje de exito | error = mensaje de error -->
<?php if (isset($_GET['success']) || isset($_GET['error'])): ?>

<?php
// Guardar el texto del mensaje (usa success si existe, si no usa error)
$texto = $_GET['success'] ?? $_GET['error'];

// Identificar qué tipo de mensaje es
$tipo  = isset($_GET['success']) ? 'success' : 'error';

// Colores segun el tipo de mensaje (Tailwind)
$colores = [
    'success' => 'bg-green-100 text-green-700',
    'error'   => 'bg-red-100 text-red-700'
];
?>
<!-- Notificación flotante (estructura y diseño) -->
<!-- opacity-0 = empieza invisible -->
<div id="notificacion"
     class="mb-4 px-4 py-3 rounded-md font-medium shadow opacity-0 transition-opacity duration-500 z-50 <?= $colores[$tipo] ?>">
     
    <!-- Mostrar el texto del mensaje -->
    <?= htmlspecialchars($texto) ?>

</div>

<script>
    // Guardar el DIV de la notificación en una variable
    const n = document.getElementById('notificacion');

    // 1️ Mostrar la notificación (quitar opacity-0)
    // Se hace después de 100ms para que la animación alcance a funcionar (sacado de internet)
    setTimeout(() => n.classList.remove('opacity-0'), 100);

    // 2️ Volver a ocultarla despues de 3.5 segundos 
    setTimeout(() => n.classList.add('opacity-0'), 3500);

    // 3️ Eliminarla del documento despues de que termine la animación
    setTimeout(() => n.remove(), 4000);
</script>

<?php endif; ?>
