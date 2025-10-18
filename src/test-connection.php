<?php
require __DIR__ . '/includes/db.php';

try {
    $pdo = get_db_connection();
    echo "✅ Conexión exitosa a MySQL<br>";
    echo "Base de datos: " . getenv('DB_NAME') . "<br>";
    
    // Verificar tabla
    $stmt = $pdo->query("SHOW TABLES LIKE 'respuestas'");
    if ($stmt->rowCount() > 0) {
        echo "✅ Tabla 'respuestas' existe<br>";
        
        $count = $pdo->query("SELECT COUNT(*) FROM respuestas")->fetchColumn();
        echo "Registros: " . $count;
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}