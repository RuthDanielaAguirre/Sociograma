<?php
require __DIR__ . '/includes/functions.php';

try {
    // Test 1: Guardar datos
    $datos = [
        ['nombre' => 'Ana', 'grupo' => 'DAW1'],
        ['nombre' => 'Luis', 'grupo' => 'DAW2']
    ];
    
    save_json('data/test.json', $datos);
    echo "✅ Datos guardados correctamente\n";
    
    // Test 2: Cargar datos
    $cargados = load_json('data/test.json');
    echo "✅ Datos cargados: " . count($cargados) . " registros\n";
    print_r($cargados);
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}