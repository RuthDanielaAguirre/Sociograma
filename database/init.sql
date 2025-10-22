-- database/init.sql
-- Script de inicialización con ENUMS y restricciones según el formulario

CREATE TABLE IF NOT EXISTS respuestas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    
    -- 1. IDENTIFICACIÓN (obligatorios)
    nombre VARCHAR(100) NOT NULL CHECK (CHAR_LENGTH(nombre) >= 3),
    grupo ENUM('DAW1', 'DAW2') NOT NULL,
    email VARCHAR(100),
    
    -- 2. PREFERENCIAS DE COLABORACIÓN
    preferido_1 VARCHAR(100),
    preferido_2 VARCHAR(100),
    evitar_1 VARCHAR(100),
    motivo_preferencia TEXT CHECK (CHAR_LENGTH(motivo_preferencia) <= 300),
    
    -- 3. ROL Y HABILIDADES
    rol_habitual ENUM('frontend', 'backend', 'fullstack', 'devops'),
    lenguaje_fuerte ENUM('PHP', 'JavaScript', 'Python', 'Java', 'otro'),
    experiencia_proyectos INT CHECK (experiencia_proyectos >= 0 AND experiencia_proyectos <= 50),
    
    -- 4. DINÁMICA Y COMUNICACIÓN
    comunicacion ENUM('sincrona', 'asincrona', 'mixta'),
    herramientas SET('GitHub', 'Discord', 'Slack', 'Trello', 'Otras'),
    disponibilidad_hora_inicio TIME,
    disponibilidad_hora_fin TIME,
    
    -- 5. ORGANIZACIÓN Y BIENESTAR
    gestion_tiempo ENUM('baja', 'media', 'alta'),
    estres_proyecto INT CHECK (estres_proyecto >= 1 AND estres_proyecto <= 5),
    preferencia_espacio ENUM('silencio', 'ruido_blanco', 'musica'),
    
    -- 6. LOGÍSTICA
    dispositivo ENUM('portatil', 'sobremesa'),
    so_preferido ENUM('Windows', 'macOS', 'Linux'),
    color_equipo VARCHAR(7) CHECK (color_equipo REGEXP '^#[0-9A-Fa-f]{6}$'),
    
    -- 7. OBSERVACIONES
    comentarios TEXT,
    fecha_respuesta DATE NOT NULL,
    
    -- METADATA
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    -- INDICES para búsquedas rápidas
);
CREATE INDEX idx_nombre ON respuestas (nombre);
CREATE INDEX idx_grupo ON respuestas (grupo);
CREATE INDEX idx_fecha ON respuestas (fecha_respuesta);

-- Dato de ejemplo para testing (cumple todas las restricciones)
INSERT INTO respuestas (
    nombre, 
    grupo, 
    email, 
    preferido_1, 
    evitar_1, 
    motivo_preferencia,
    rol_habitual, 
    lenguaje_fuerte,
    experiencia_proyectos,
    comunicacion,
    herramientas,
    gestion_tiempo,
    estres_proyecto,
    preferencia_espacio,
    dispositivo,
    so_preferido,
    color_equipo,
    fecha_respuesta
) VALUES (
    'Ana García López',
    'DAW1',
    'ana@daw.com',
    'María Torres',
    'Juan Pérez',
    'Me organizo mejor con María porque es muy metódica',
    'fullstack',
    'JavaScript',
    5,
    'mixta',
    'GitHub,Discord,Slack',
    'alta',
    3,
    'musica',
    'portatil',
    'macOS',
    '#3b82f6',
    CURDATE()
);