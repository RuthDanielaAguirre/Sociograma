<?php
/**
 * Página de éxito tras enviar el formulario
 * 
 * @author Ruth Daniela Aguirre <ruthdanielaaguirre@gmail.com>
 * @version 1.0
 */

session_start();

// Si no hay mensaje de éxito, redirigir al formulario
if (!isset($_SESSION['mensaje_exito'])) {
    header('Location: index.php');
    exit;
}

$mensaje = $_SESSION['mensaje_exito'];
unset($_SESSION['mensaje_exito']);

require_once __DIR__ . '/includes/header.php';
?>

<div class="container mx-auto px-4 py-16">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-8 text-center">
        
        <!-- Icono de éxito -->
        <div class="mb-6">
            <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-green-100">
                <svg class="h-16 w-16 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
        </div>
        
        <!-- Mensaje de éxito -->
        <h1 class="text-3xl font-bold text-gray-800 mb-4">¡Formulario Enviado!</h1>
        
        <p class="text-lg text-gray-600 mb-8">
            <?= htmlspecialchars($mensaje) ?>
        </p>
        
        <div class="border-t border-gray-200 pt-6">
            <p class="text-sm text-gray-500 mb-6">
                Tu respuesta ha sido registrada correctamente en el sistema del sociograma DAW.
            </p>
            
            <!-- Botones de acción -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a 
                    href="index.php" 
                    class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 transition-colors"
                >
                    📝 Volver al inicio
                </a>
                
                <a 
                    href="api.php" 
                    class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors"
                >
                    📊 Ver todas las respuestas (JSON)
                </a>
            </div>
        </div>
        
        <!-- Información adicional -->
        <div class="mt-8 text-xs text-gray-400">
            <p>Respuesta registrada el <?= date('d/m/Y H:i:s') ?></p>
        </div>
        
    </div>
</div>


<?php require_once __DIR__ . '/includes/footer.php'; ?>