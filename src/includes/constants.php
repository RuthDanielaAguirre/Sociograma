<?php
/**
 * Constantes con valores ENUM y SET permitidos
 * Centraliza todos los valores posibles para validación y formularios
 * 
 * @author Ruth Daniela Aguirre <ruthdanielaaguirre@gmail.com>
 * @version 1.0
 */

// ============================================
// IDENTIFICACIÓN
// ============================================

const GRUPOS_VALIDOS = ['DAW1', 'DAW2'];

// ============================================
// ROL Y HABILIDADES
// ============================================

const ROLES_VALIDOS = [
    'frontend',
    'backend',
    'fullstack',
    'devops'
];

const LENGUAJES_VALIDOS = [
    'PHP',
    'JavaScript',
    'Python',
    'Java',
    'otro'
];

// ============================================
// DINÁMICA Y COMUNICACIÓN
// ============================================

const COMUNICACION_VALIDA = [
    'sincrona',
    'asincrona',
    'mixta'
];

const HERRAMIENTAS_VALIDAS = [
    'GitHub',
    'Discord',
    'Slack',
    'Trello',
    'Otras'
];

// ============================================
// ORGANIZACIÓN Y BIENESTAR
// ============================================

const GESTION_TIEMPO_VALIDA = [
    'baja',
    'media',
    'alta'
];

const PREFERENCIA_ESPACIO_VALIDA = [
    'silencio',
    'ruido_blanco',
    'musica'
];

// ============================================
// LOGÍSTICA
// ============================================

const DISPOSITIVOS_VALIDOS = [
    'portatil',
    'sobremesa'
];

const SO_VALIDOS = [
    'Windows',
    'macOS',
    'Linux'
];

// ============================================
// LÍMITES NUMÉRICOS
// ============================================

const EXPERIENCIA_MIN = 0;
const EXPERIENCIA_MAX = 50;

const ESTRES_MIN = 1;
const ESTRES_MAX = 5;

// ============================================
// LÍMITES DE TEXTO
// ============================================

const NOMBRE_MIN_LENGTH = 3;
const NOMBRE_MAX_LENGTH = 100;

const EMAIL_MAX_LENGTH = 100;

const MOTIVO_MAX_LENGTH = 300;

const COMENTARIOS_MAX_LENGTH = 1000;