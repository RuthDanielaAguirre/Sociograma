<?php
/**
 * Procesar formulario del sociograma
 * Valida datos y guarda en base de datos
 * 
 * @author Ruth Daniela Aguirre <ruthdanielaaguirre@gmail.com>
 * @version 1.0
 */

session_start();

echo "POST recibido:<br>";
echo "<pre>";
print_r($_POST);
echo "</pre>";
die("Debug - Detener aquí");

require_once __DIR__ . '/includes/constants.php';
require_once __DIR__ . '/includes/validation.php';
require_once __DIR__ . '/includes/db.php';

// ============================================
// VERIFICAR MÉTODO POST
// ============================================
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

// ============================================
// ARRAY PARA ERRORES
// ============================================
$errores = [];

// ============================================
// VALIDAR CAMPOS OBLIGATORIOS
// ============================================

// 1. NOMBRE (obligatorio, longitud)
if (!validate_required($_POST['nombre'] ?? '')) {
    $errores[] = 'El nombre es obligatorio';
} elseif (!validate_length($_POST['nombre'], NOMBRE_MIN_LENGTH, NOMBRE_MAX_LENGTH)) {
    $errores[] = 'El nombre debe tener entre ' . NOMBRE_MIN_LENGTH . ' y ' . NOMBRE_MAX_LENGTH . ' caracteres';
}

// 2. GRUPO (obligatorio, enum)
if (!validate_required($_POST['grupo'] ?? '')) {
    $errores[] = 'El grupo es obligatorio';
} elseif (!validate_enum($_POST['grupo'], GRUPOS_VALIDOS)) {
    $errores[] = 'El grupo seleccionado no es válido';
}

// 3. EMAIL (opcional, pero si está debe ser válido)
if (!empty($_POST['email'])) {
    if (!validate_email($_POST['email'])) {
        $errores[] = 'El email no es válido';
    } elseif (!validate_length($_POST['email'], 0, EMAIL_MAX_LENGTH)) {
        $errores[] = 'El email es demasiado largo';
    }
}

// 4. FECHA RESPUESTA (obligatoria, formato válido)
if (!validate_required($_POST['fecha_respuesta'] ?? '')) {
    $errores[] = 'La fecha de respuesta es obligatoria';
} elseif (!validate_date($_POST['fecha_respuesta'])) {
    $errores[] = 'La fecha de respuesta no es válida';
}

// ============================================
// VALIDAR CAMPOS OPCIONALES (si tienen valor)
// ============================================

// PREFERENCIAS (longitud si están presentes)
if (!empty($_POST['preferido_1']) && strlen($_POST['preferido_1']) > 100) {
    $errores[] = 'El nombre del compañero preferido 1 es demasiado largo';
}
if (!empty($_POST['preferido_2']) && strlen($_POST['preferido_2']) > 100) {
    $errores[] = 'El nombre del compañero preferido 2 es demasiado largo';
}
if (!empty($_POST['evitar_1']) && strlen($_POST['evitar_1']) > 100) {
    $errores[] = 'El nombre del compañero a evitar es demasiado largo';
}

// MOTIVO (longitud máxima)
if (!empty($_POST['motivo_preferencia']) && strlen($_POST['motivo_preferencia']) > MOTIVO_MAX_LENGTH) {
    $errores[] = 'El motivo de preferencia no puede superar ' . MOTIVO_MAX_LENGTH . ' caracteres';
}

// ROL HABITUAL (enum si está presente)
if (!empty($_POST['rol_habitual']) && !validate_enum($_POST['rol_habitual'], ROLES_VALIDOS)) {
    $errores[] = 'El rol seleccionado no es válido';
}

// LENGUAJE (enum si está presente)
if (!empty($_POST['lenguaje_fuerte']) && !validate_enum($_POST['lenguaje_fuerte'], LENGUAJES_VALIDOS)) {
    $errores[] = 'El lenguaje seleccionado no es válido';
}

// EXPERIENCIA PROYECTOS (rango si está presente)
if (!empty($_POST['experiencia_proyectos'])) {
    $experiencia = (int)$_POST['experiencia_proyectos'];
    if (!validate_range($experiencia, EXPERIENCIA_MIN, EXPERIENCIA_MAX)) {
        $errores[] = 'El número de proyectos debe estar entre ' . EXPERIENCIA_MIN . ' y ' . EXPERIENCIA_MAX;
    }
}

// COMUNICACIÓN (enum si está presente)
if (!empty($_POST['comunicacion']) && !validate_enum($_POST['comunicacion'], COMUNICACION_VALIDA)) {
    $errores[] = 'El tipo de comunicación seleccionado no es válido';
}

// HERRAMIENTAS (array de enums)
if (!empty($_POST['herramientas']) && is_array($_POST['herramientas'])) {
    foreach ($_POST['herramientas'] as $herramienta) {
        if (!validate_enum($herramienta, HERRAMIENTAS_VALIDAS)) {
            $errores[] = 'Una de las herramientas seleccionadas no es válida';
            break;
        }
    }
}

// GESTIÓN TIEMPO (enum si está presente)
if (!empty($_POST['gestion_tiempo']) && !validate_enum($_POST['gestion_tiempo'], GESTION_TIEMPO_VALIDA)) {
    $errores[] = 'La capacidad de gestión del tiempo seleccionada no es válida';
}

// ESTRÉS PROYECTO (rango si está presente)
if (!empty($_POST['estres_proyecto'])) {
    $estres = (int)$_POST['estres_proyecto'];
    if (!validate_range($estres, ESTRES_MIN, ESTRES_MAX)) {
        $errores[] = 'El nivel de estrés debe estar entre ' . ESTRES_MIN . ' y ' . ESTRES_MAX;
    }
}

// PREFERENCIA ESPACIO (enum si está presente)
if (!empty($_POST['preferencia_espacio']) && !validate_enum($_POST['preferencia_espacio'], PREFERENCIA_ESPACIO_VALIDA)) {
    $errores[] = 'La preferencia de espacio seleccionada no es válida';
}

// DISPOSITIVO (enum si está presente)
if (!empty($_POST['dispositivo']) && !validate_enum($_POST['dispositivo'], DISPOSITIVOS_VALIDOS)) {
    $errores[] = 'El tipo de dispositivo seleccionado no es válido';
}

// SO PREFERIDO (enum si está presente)
if (!empty($_POST['so_preferido']) && !validate_enum($_POST['so_preferido'], SO_VALIDOS)) {
    $errores[] = 'El sistema operativo seleccionado no es válido';
}

// COLOR EQUIPO (formato hexadecimal)
if (!empty($_POST['color_equipo']) && !preg_match('/^#[0-9A-Fa-f]{6}$/', $_POST['color_equipo'])) {
    $errores[] = 'El color seleccionado no es válido';
}

// COMENTARIOS (longitud máxima)
if (!empty($_POST['comentarios']) && strlen($_POST['comentarios']) > COMENTARIOS_MAX_LENGTH) {
    $errores[] = 'Los comentarios no pueden superar ' . COMENTARIOS_MAX_LENGTH . ' caracteres';
}

// ============================================
// SI HAY ERRORES, VOLVER AL FORMULARIO
// ============================================
if (!empty($errores)) {
    $_SESSION['errores'] = $errores;
    $_SESSION['form_data'] = $_POST;
    header('Location: index.php');
    exit;
}

// ============================================
// PREPARAR DATOS PARA INSERCIÓN
// ============================================

// Convertir herramientas array a string separado por comas
$herramientas = !empty($_POST['herramientas']) && is_array($_POST['herramientas']) 
    ? implode(',', $_POST['herramientas']) 
    : null;

// Preparar valores (NULL si están vacíos)
$nombre = trim($_POST['nombre']);
$grupo = $_POST['grupo'];
$email = !empty($_POST['email']) ? trim($_POST['email']) : null;
$preferido_1 = !empty($_POST['preferido_1']) ? trim($_POST['preferido_1']) : null;
$preferido_2 = !empty($_POST['preferido_2']) ? trim($_POST['preferido_2']) : null;
$evitar_1 = !empty($_POST['evitar_1']) ? trim($_POST['evitar_1']) : null;
$motivo_preferencia = !empty($_POST['motivo_preferencia']) ? trim($_POST['motivo_preferencia']) : null;
$rol_habitual = !empty($_POST['rol_habitual']) ? $_POST['rol_habitual'] : null;
$lenguaje_fuerte = !empty($_POST['lenguaje_fuerte']) ? $_POST['lenguaje_fuerte'] : null;
$experiencia_proyectos = !empty($_POST['experiencia_proyectos']) ? (int)$_POST['experiencia_proyectos'] : null;
$comunicacion = !empty($_POST['comunicacion']) ? $_POST['comunicacion'] : null;
$disponibilidad_hora_inicio = !empty($_POST['disponibilidad_hora_inicio']) ? $_POST['disponibilidad_hora_inicio'] : null;
$disponibilidad_hora_fin = !empty($_POST['disponibilidad_hora_fin']) ? $_POST['disponibilidad_hora_fin'] : null;
$gestion_tiempo = !empty($_POST['gestion_tiempo']) ? $_POST['gestion_tiempo'] : null;
$estres_proyecto = !empty($_POST['estres_proyecto']) ? (int)$_POST['estres_proyecto'] : null;
$preferencia_espacio = !empty($_POST['preferencia_espacio']) ? $_POST['preferencia_espacio'] : null;
$dispositivo = !empty($_POST['dispositivo']) ? $_POST['dispositivo'] : null;
$so_preferido = !empty($_POST['so_preferido']) ? $_POST['so_preferido'] : null;
$color_equipo = !empty($_POST['color_equipo']) ? $_POST['color_equipo'] : null;
$comentarios = !empty($_POST['comentarios']) ? trim($_POST['comentarios']) : null;
$fecha_respuesta = $_POST['fecha_respuesta'];

// ============================================
// INSERTAR EN BASE DE DATOS
// ============================================
try {
    $pdo = get_db_connection();
    
    $sql = "INSERT INTO respuestas (
        nombre, grupo, email, 
        preferido_1, preferido_2, evitar_1, motivo_preferencia,
        rol_habitual, lenguaje_fuerte, experiencia_proyectos,
        comunicacion, herramientas, disponibilidad_hora_inicio, disponibilidad_hora_fin,
        gestion_tiempo, estres_proyecto, preferencia_espacio,
        dispositivo, so_preferido, color_equipo,
        comentarios, fecha_respuesta
    ) VALUES (
        :nombre, :grupo, :email,
        :preferido_1, :preferido_2, :evitar_1, :motivo_preferencia,
        :rol_habitual, :lenguaje_fuerte, :experiencia_proyectos,
        :comunicacion, :herramientas, :disponibilidad_hora_inicio, :disponibilidad_hora_fin,
        :gestion_tiempo, :estres_proyecto, :preferencia_espacio,
        :dispositivo, :so_preferido, :color_equipo,
        :comentarios, :fecha_respuesta
    )";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nombre' => $nombre,
        ':grupo' => $grupo,
        ':email' => $email,
        ':preferido_1' => $preferido_1,
        ':preferido_2' => $preferido_2,
        ':evitar_1' => $evitar_1,
        ':motivo_preferencia' => $motivo_preferencia,
        ':rol_habitual' => $rol_habitual,
        ':lenguaje_fuerte' => $lenguaje_fuerte,
        ':experiencia_proyectos' => $experiencia_proyectos,
        ':comunicacion' => $comunicacion,
        ':herramientas' => $herramientas,
        ':disponibilidad_hora_inicio' => $disponibilidad_hora_inicio,
        ':disponibilidad_hora_fin' => $disponibilidad_hora_fin,
        ':gestion_tiempo' => $gestion_tiempo,
        ':estres_proyecto' => $estres_proyecto,
        ':preferencia_espacio' => $preferencia_espacio,
        ':dispositivo' => $dispositivo,
        ':so_preferido' => $so_preferido,
        ':color_equipo' => $color_equipo,
        ':comentarios' => $comentarios,
        ':fecha_respuesta' => $fecha_respuesta
    ]);
    
    // Éxito: guardar mensaje y redirigir
    $_SESSION['mensaje_exito'] = '¡Cuestionario enviado correctamente! Gracias por tu participación.';
    header('Location: exito.php');
    exit;
    
} catch (PDOException $e) {
    // Error de base de datos
    $_SESSION['errores'] = ['Error al guardar en la base de datos: ' . $e->getMessage()];
    $_SESSION['form_data'] = $_POST;
    header('Location: index.php');
    exit;
}