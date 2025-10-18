<?php
/**
 * Configuración y conexión a MySQL
 * Las variables vienen del archivo .env vía docker-compose
 */

/**
 * Obtener conexión PDO a MySQL
 * @return PDO
 * @throws Exception si falla la conexión
 */
function get_db_connection(): PDO
{
    // Leer variables de entorno (vienen del .env)
    $db_host = getenv('DB_HOST');
    $db_name = getenv('DB_NAME');
    $db_user = getenv('DB_USER');
    $db_password = getenv('DB_PASSWORD');
    
    // Verificar que existan las variables
    if (!$db_host || !$db_name || !$db_user || !$db_password) {
        throw new Exception("Faltan variables de entorno de BD. Verifica tu archivo .env");
    }
    
    try {
        $dsn = "mysql:host={$db_host};dbname={$db_name};charset=utf8mb4";
        
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        
        return new PDO($dsn, $db_user, $db_password, $options);
        
    } catch (PDOException $e) {
        error_log("Error conexión MySQL: " . $e->getMessage());
        throw new Exception("No se pudo conectar a la base de datos");
    }
}