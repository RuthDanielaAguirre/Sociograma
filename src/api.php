<?php
/**
 * API REST para obtener respuestas del sociograma
 * Devuelve todas las respuestas en formato JSON
 * 
 * @author Ruth Daniela Aguirre <ruthdanielaaguirre@gmail.com>
 * @version 1.0
 */

// Headers para JSON y CORS
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

require_once __DIR__ . '/includes/db.php';

try {
    // Conectar a la base de datos
    $pdo = get_db_connection();
    
    // Query para obtener todas las respuestas
    $sql = "SELECT 
        id,
        nombre,
        grupo,
        email,
        preferido_1,
        preferido_2,
        evitar_1,
        motivo_preferencia,
        rol_habitual,
        lenguaje_fuerte,
        experiencia_proyectos,
        comunicacion,
        herramientas,
        disponibilidad_hora_inicio,
        disponibilidad_hora_fin,
        gestion_tiempo,
        estres_proyecto,
        preferencia_espacio,
        dispositivo,
        so_preferido,
        color_equipo,
        comentarios,
        fecha_respuesta,
        created_at
    FROM respuestas
    ORDER BY created_at DESC";
    
    $stmt = $pdo->query($sql);
    $respuestas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Procesar herramientas (convertir string CSV a array)
    foreach ($respuestas as &$respuesta) {
        if (!empty($respuesta['herramientas'])) {
            $respuesta['herramientas'] = explode(',', $respuesta['herramientas']);
        } else {
            $respuesta['herramientas'] = [];
        }
    }
    
    // Respuesta exitosa
    $response = [
        'success' => true,
        'total' => count($respuestas),
        'data' => $respuestas
    ];
    
    echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    
} catch (PDOException $e) {
    // Error de base de datos
    http_response_code(500);
    
    $response = [
        'success' => false,
        'error' => 'Error al obtener los datos',
        'message' => $e->getMessage()
    ];
    
    echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}