<?php
/**
 * Formulario del sociograma DAW
 * Con header/footer, rehidratación de datos y validación
 * 
 * @author Ruth Daniela Aguirre <ruthdanielaaguirre@gmail.com>
 * @version 1.0
 */

session_start();

require_once __DIR__ . '/includes/constants.php';
require_once __DIR__ . '/includes/helpers.php';

$oldData = $_SESSION['form_data'] ?? [];
$errores = $_SESSION['errores'] ?? [];
unset($_SESSION['form_data'], $_SESSION['errores']);

require_once __DIR__ . '/includes/header.php';
?>


<div class="container mx-auto px-4 py-8">
    <main class="max-w-5xl mx-auto px-6 py-12 glass text-left">

        
        <h1 class="text-3xl font-bold text-white mb-2">Sociograma DAW</h1>
        <p class="text-white mb-8">Cuestionario sobre preferencias de colaboración en el aula</p>
        
        <?php if (!empty($errores)): ?>
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-6">
            <strong class="font-bold">⚠️ Errores de validación:</strong>
            <ul class="list-disc list-inside mt-2">
                <?php foreach ($errores as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
        
        <form action="procesar.php" method="POST" class="space-y-8">
        
            <!-- SECCIÓN 1: IDENTIFICACIÓN -->

            <div class="border-b pb-6">
                <h2 class="text-xl font-semibold text-white mb-4">1. Identificación</h2>
                
                <!-- Nombre -->
                <div class="mb-4">
                    <label for="nombre" class="block text-sm font-medium text-white mb-2">
                        Nombre completo <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="nombre" 
                        name="nombre" 
                        required 
                        minlength="<?= NOMBRE_MIN_LENGTH ?>"
                        maxlength="<?= NOMBRE_MAX_LENGTH ?>"
                        value="<?= oldField('nombre', $oldData) ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Ej: Ana García López"
                    >
                </div>
                
                <!-- Grupo -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-white mb-2">
                        Grupo <span class="text-red-500">*</span>
                    </label>
                    <div class="flex gap-6">
                        <?php foreach (GRUPOS_VALIDOS as $grupo): ?>
                        <label class="flex items-center cursor-pointer">
                            <input 
                                type="radio" 
                                name="grupo" 
                                value="<?= $grupo ?>" 
                                required 
                                class="mr-2"
                                <?= oldRadio('grupo', $grupo, $oldData) ?>
                            >
                            <span><?= $grupo ?></span>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-white mb-2">
                        Email
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email"
                        maxlength="<?= EMAIL_MAX_LENGTH ?>"
                        value="<?= oldField('email', $oldData) ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="tu@email.com"
                    >
                </div>
            </div>
            
            <!-- SECCIÓN 2: PREFERENCIAS DE COLABORACIÓN -->

            <div class="border-b pb-6">
                <h2 class="text-xl font-semibold text-white mb-4">2. Preferencias de Colaboración</h2>
                
                <!-- Preferido 1 -->
                <div class="mb-4">
                    <label for="preferido_1" class="block text-sm font-medium text-white mb-2">
                        Compañero/a preferido/a 1
                    </label>
                    <input 
                        type="text" 
                        id="preferido_1" 
                        name="preferido_1"
                        maxlength="100"
                        value="<?= oldField('preferido_1', $oldData) ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Nombre del compañero/a"
                    >
                </div>
                
                <!-- Preferido 2 -->
                <div class="mb-4">
                    <label for="preferido_2" class="block text-sm font-medium text-white mb-2">
                        Compañero/a preferido/a 2
                    </label>
                    <input 
                        type="text" 
                        id="preferido_2" 
                        name="preferido_2"
                        maxlength="100"
                        value="<?= oldField('preferido_2', $oldData) ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Nombre del compañero/a"
                    >
                </div>
                
                <!-- Evitar -->
                <div class="mb-4">
                    <label for="evitar_1" class="block text-sm font-medium text-white mb-2">
                        Compañero/a a evitar
                    </label>
                    <input 
                        type="text" 
                        id="evitar_1" 
                        name="evitar_1"
                        maxlength="100"
                        value="<?= oldField('evitar_1', $oldData) ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Nombre del compañero/a"
                    >
                </div>
                
                <!-- Motivo -->
                <div class="mb-4">
                    <label for="motivo_preferencia" class="block text-sm font-medium text-white mb-2">
                        Motivo de tu preferencia
                    </label>
                    <textarea 
                        id="motivo_preferencia" 
                        name="motivo_preferencia"
                        rows="3"
                        maxlength="<?= MOTIVO_MAX_LENGTH ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                        placeholder="Explica brevemente por qué prefieres trabajar con esas personas..."
                    ><?= oldField('motivo_preferencia', $oldData) ?></textarea>
                    <p class="text-xs text-gray-500 mt-1">Máximo <?= MOTIVO_MAX_LENGTH ?> caracteres</p>
                </div>
            </div>
          
            <!-- SECCIÓN 3: ROL Y HABILIDADES -->

            <div class="border-b pb-6">
                <h2 class="text-xl font-semibold text-white mb-4">3. Rol y Habilidades</h2>
                
                <!-- Rol habitual -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-white mb-2">
                        Rol habitual en proyectos
                    </label>
                    <div class="grid grid-cols-2 gap-3">
                        <?php foreach (ROLES_VALIDOS as $rol): ?>
                        <label class="flex items-center cursor-pointer">
                            <input 
                                type="radio" 
                                name="rol_habitual" 
                                value="<?= $rol ?>" 
                                class="mr-2"
                                <?= oldRadio('rol_habitual', $rol, $oldData) ?>
                            >
                            <span><?= ucfirst($rol) ?></span>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <!-- Lenguaje fuerte -->
                <div class="mb-4">
                    <label for="lenguaje_fuerte" class="block text-sm font-medium text-white mb-2">
                        Lenguaje más fuerte
                    </label>
                    <select 
                        id="lenguaje_fuerte" 
                        name="lenguaje_fuerte"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                        <option value="">Selecciona un lenguaje</option>
                        <?php foreach (LENGUAJES_VALIDOS as $lenguaje): ?>
                            <option value="<?= $lenguaje ?>" <?= (oldField('lenguaje_fuerte', $oldData) === $lenguaje) ? 'selected' : '' ?>>
                                <?= $lenguaje ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <!-- Experiencia proyectos -->
                <div class="mb-4">
                    <label for="experiencia_proyectos" class="block text-sm font-medium text-white mb-2">
                        Número de proyectos realizados (<?= EXPERIENCIA_MIN ?>-<?= EXPERIENCIA_MAX ?>)
                    </label>
                    <input 
                        type="number" 
                        id="experiencia_proyectos" 
                        name="experiencia_proyectos"
                        min="<?= EXPERIENCIA_MIN ?>"
                        max="<?= EXPERIENCIA_MAX ?>"
                        value="<?= oldField('experiencia_proyectos', $oldData) ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="5"
                    >
                </div>
            </div>

            <!-- SECCIÓN 4: DINÁMICA Y COMUNICACIÓN -->

            <div class="border-b pb-6">
                <h2 class="text-xl font-semibold text-white mb-4">4. Dinámica y Comunicación</h2>
                
                <!-- Tipo de comunicación -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-white mb-2">
                        Tipo de comunicación preferida
                    </label>
                    <div class="space-y-2">
                        <?php 
                        $comunicacion_labels = [
                            'sincrona' => 'Síncrona (videollamadas, presencial)',
                            'asincrona' => 'Asíncrona (mensajes, correo)',
                            'mixta' => 'Mixta'
                        ];
                        foreach (COMUNICACION_VALIDA as $comunicacion): 
                        ?>
                        <label class="flex items-center cursor-pointer">
                            <input 
                                type="radio" 
                                name="comunicacion" 
                                value="<?= $comunicacion ?>" 
                                class="mr-2"
                                <?= oldRadio('comunicacion', $comunicacion, $oldData) ?>
                            >
                            <span><?= $comunicacion_labels[$comunicacion] ?></span>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <!-- Herramientas (checkboxes) -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-white mb-2">
                        Herramientas que usas (puedes marcar varias)
                    </label>
                    <div class="space-y-2">
                        <?php foreach (HERRAMIENTAS_VALIDAS as $herramienta): ?>
                        <label class="flex items-center cursor-pointer">
                            <input 
                                type="checkbox" 
                                name="herramientas[]" 
                                value="<?= $herramienta ?>" 
                                class="mr-2"
                                <?= oldCheckbox('herramientas', $herramienta, $oldData) ?>
                            >
                            <span><?= $herramienta ?></span>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <!-- Disponibilidad horaria -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="disponibilidad_hora_inicio" class="block text-sm font-medium text-white mb-2">
                            Disponibilidad desde
                        </label>
                        <input 
                            type="time" 
                            id="disponibilidad_hora_inicio" 
                            name="disponibilidad_hora_inicio"
                            value="<?= oldField('disponibilidad_hora_inicio', $oldData) ?>"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                    </div>
                    <div>
                        <label for="disponibilidad_hora_fin" class="block text-sm font-medium text-white mb-2">
                            Disponibilidad hasta
                        </label>
                        <input 
                            type="time" 
                            id="disponibilidad_hora_fin" 
                            name="disponibilidad_hora_fin"
                            value="<?= oldField('disponibilidad_hora_fin', $oldData) ?>"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                    </div>
                </div>
            </div>

            <!-- SECCIÓN 5: ORGANIZACIÓN Y BIENESTAR -->
            <div class="border-b pb-6">
                <h2 class="text-xl font-semibold text-white mb-4">5. Organización y Bienestar</h2>
                
                <!-- Gestión del tiempo -->
                <div class="mb-4">
                    <label for="gestion_tiempo" class="block text-sm font-medium text-white mb-2">
                        Capacidad de gestión del tiempo
                    </label>
                    <select 
                        id="gestion_tiempo" 
                        name="gestion_tiempo"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                        <option value="">Selecciona una opción</option>
                        <?php foreach (GESTION_TIEMPO_VALIDA as $gestion): ?>
                            <option value="<?= $gestion ?>" <?= (oldField('gestion_tiempo', $oldData) === $gestion) ? 'selected' : '' ?>>
                                <?= ucfirst($gestion) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <!-- Nivel de estrés (range) -->
                <div class="mb-4">
                    <label for="estres_proyecto" class="block text-sm font-medium text-white mb-2">
                        Nivel de estrés en proyectos (<?= ESTRES_MIN ?>=bajo, <?= ESTRES_MAX ?>=alto)
                    </label>
                    <input 
                        type="range" 
                        id="estres_proyecto" 
                        name="estres_proyecto"
                        min="<?= ESTRES_MIN ?>"
                        max="<?= ESTRES_MAX ?>"
                        value="<?= oldField('estres_proyecto', $oldData) ?: 3 ?>"
                        class="w-full"
                        oninput="this.nextElementSibling.textContent = this.value"
                    >
                    <div class="text-center text-sm font-medium text-white mt-2"><?= oldField('estres_proyecto', $oldData) ?: 3 ?></div>
                </div>
                
                <!-- Preferencia espacio -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-white mb-2">
                        Preferencia de espacio de trabajo
                    </label>
                    <div class="space-y-2">
                        <?php 
                        $espacio_labels = [
                            'silencio' => 'Silencio absoluto',
                            'ruido_blanco' => 'Ruido blanco',
                            'musica' => 'Música'
                        ];
                        foreach (PREFERENCIA_ESPACIO_VALIDA as $espacio): 
                        ?>
                        <label class="flex items-center cursor-pointer">
                            <input 
                                type="radio" 
                                name="preferencia_espacio" 
                                value="<?= $espacio ?>" 
                                class="mr-2"
                                <?= oldRadio('preferencia_espacio', $espacio, $oldData) ?>
                            >
                            <span><?= $espacio_labels[$espacio] ?></span>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- SECCIÓN 6: LOGÍSTICA -->
           
            <div class="border-b pb-6">
                <h2 class="text-xl font-semibold text-white mb-4"> 6. Logística</h2>
                
                <!-- Tipo de dispositivo -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-white mb-2">
                        Tipo de dispositivo
                    </label>
                    <div class="flex gap-6">
                        <?php foreach (DISPOSITIVOS_VALIDOS as $dispositivo): ?>
                        <label class="flex items-center cursor-pointer">
                            <input 
                                type="radio" 
                                name="dispositivo" 
                                value="<?= $dispositivo ?>" 
                                class="mr-2"
                                <?= oldRadio('dispositivo', $dispositivo, $oldData) ?>
                            >
                            <span><?= ucfirst($dispositivo) ?></span>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <!-- Sistema operativo -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-white mb-2">
                        Sistema operativo preferido
                    </label>
                    <div class="flex gap-6">
                        <?php foreach (SO_VALIDOS as $so): ?>
                        <label class="flex items-center cursor-pointer">
                            <input 
                                type="radio" 
                                name="so_preferido" 
                                value="<?= $so ?>" 
                                class="mr-2"
                                <?= oldRadio('so_preferido', $so, $oldData) ?>
                            >
                            <span><?= $so ?></span>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <!-- Color equipo -->
                <div class="mb-4">
                    <label for="color_equipo" class="block text-sm font-medium text-white mb-2">
                        Color favorito para identificar tu equipo
                    </label>
                    <input 
                        type="color" 
                        id="color_equipo" 
                        name="color_equipo"
                        value="<?= oldField('color_equipo', $oldData) ?: '#bd2553ff' ?>"
                        class="h-12 w-24 border border-gray-300 rounded-lg cursor-pointer"
                    >
                </div>
            </div>
        
            <!-- SECCIÓN 7: OBSERVACIONES -->
            
            <div class="border-b pb-6">
                <h2 class="text-xl font-semibold text-white mb-4">7. Observaciones</h2>
                
                
                <div class="mb-4">
                    <label for="comentarios" class="block text-sm font-medium text-white mb-2">
                        Comentarios adicionales
                    </label>
                    <textarea 
                        id="comentarios" 
                        name="comentarios"
                        rows="4"
                        maxlength="<?= COMENTARIOS_MAX_LENGTH ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                        placeholder="Cualquier información adicional que quieras compartir..."
                    ><?= oldField('comentarios', $oldData) ?></textarea>
                </div>
                
            
                <div class="mb-4">
                    <label for="fecha_respuesta" class="block text-sm font-medium text-white mb-2">
                        Fecha de respuesta <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="date" 
                        id="fecha_respuesta" 
                        name="fecha_respuesta"
                        required
                        value="<?= oldField('fecha_respuesta', $oldData) ?: date('Y-m-d') ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                </div>
            </div>
            
          
            <button type="submit" class="w-full bg-yellow-700 text-white py-3 px-6 rounded-lg hover:bg-yellow-600 font-medium transition-colors shadow-md hover:shadow-lg">
                Enviar 
            </button>
            
        </form>
        
    </div>
</div>


<?php require_once __DIR__ . '/includes/footer.php'; ?>