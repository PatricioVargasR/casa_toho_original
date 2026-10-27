<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="icon" type="image/png" href="./../../public/images/logo/isotipo.ico">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Promocional.</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            overflow: hidden;
            background: #000;
            cursor: none;
        }

        .carousel-container {
            position: relative;
            width: 100vw;
            height: 100vh;
            background-color: #000;
        }

        .carousel-slide {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 1s ease-in-out;
            background-color: #000;
            visibility: hidden;
        }

        .carousel-slide.active {
            opacity: 1;
            visibility: visible;
        }

        .carousel-container.loading .carousel-slide {
            visibility: hidden;
            opacity: 0;
        }

        .carousel-slide img,
        .carousel-slide video {
            max-width: 100vw;
            max-height: 100vh;
            object-fit: contain;
            background-color: #000;
        }

        .video-error-message {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #fff;
            font-size: 18px;
            text-align: center;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            z-index: 10;
            display: none;
            padding: 20px;
            background: rgba(0, 0, 0, 0.7);
            border-radius: 8px;
        }

        .carousel-slide.video-error .video-error-message {
            display: block;
        }

        .carousel-slide.video-error video {
            opacity: 0.3;
        }

        .loading {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: transparent;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 24px;
            z-index: 1000;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            text-align: center;
        }

        .loading > div:first-child {
            margin-bottom: 30px;
            font-size: 28px;
            font-weight: 500;
            color: #fff;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.8);
        }

        .progress-container {
            margin-top: 30px;
            width: 100%;
            max-width: 500px;
            padding: 0 20px;
        }

        .progress-bar-wrapper {
            width: 100%;
            height: 40px;
            background-color: rgba(255, 255, 255, 0.15);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 20px;
            overflow: hidden;
            margin-bottom: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
        }

        .progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #d8a54a, #e6b84d, #f0c85a);
            transition: width 0.5s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: bold;
            font-size: 16px;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
            box-shadow: 0 0 10px rgba(216, 165, 74, 0.5);
        }

        .progress-text {
            font-size: 18px;
            margin-top: 15px;
            color: #fff;
            font-weight: 400;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.8);
        }

        .error-message {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #fff;
            font-size: 18px;
            text-align: center;
            z-index: 100;
            display: none;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        /* Consola de Debug */
        .debug-console {
            position: fixed;
            bottom: 10px;
            right: 10px;
            width: 400px;
            max-height: 500px;
            background: rgba(0, 0, 0, 0.9);
            border: 2px solid #d8a54a;
            border-radius: 8px;
            padding: 10px;
            font-family: 'Courier New', monospace;
            font-size: 11px;
            color: #fff;
            z-index: 10000;
            display: none;
            flex-direction: column;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
        }

        .debug-console.visible {
            display: flex;
        }

        #debug-logs {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            margin: 5px 0;
            padding-right: 5px;
            min-height: 0;
        }

        #debug-logs::-webkit-scrollbar {
            width: 8px;
        }

        #debug-logs::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }

        #debug-logs::-webkit-scrollbar-thumb {
            background: #d8a54a;
            border-radius: 4px;
        }

        #debug-logs::-webkit-scrollbar-thumb:hover {
            background: #e6b84d;
        }

        .debug-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #d8a54a;
        }

        .debug-title {
            font-weight: bold;
            color: #d8a54a;
            font-size: 14px;
        }

        .debug-buttons {
            display: flex;
            gap: 5px;
        }

        .debug-close, .debug-clear {
            background: #d8a54a;
            color: #000;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            font-size: 11px;
        }

        .debug-close:hover, .debug-clear:hover {
            background: #e6b84d;
        }

        .debug-log {
            margin: 5px 0;
            padding: 5px;
            border-left: 3px solid transparent;
            word-wrap: break-word;
        }

        .debug-log.error {
            border-left-color: #ff4444;
            color: #ff8888;
        }

        .debug-log.warn {
            border-left-color: #ffaa00;
            color: #ffcc88;
        }

        .debug-log.info {
            border-left-color: #44ff44;
            color: #88ff88;
        }

        .debug-log.debug {
            border-left-color: #4488ff;
            color: #88ccff;
        }

        .debug-stats {
            margin-top: 5px;
            padding-top: 5px;
            border-top: 1px solid #444;
            font-size: 10px;
            flex-shrink: 0;
        }

        .debug-stat {
            margin: 3px 0;
            display: flex;
            justify-content: space-between;
        }

        .network-status {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-right: 5px;
        }

        .network-status.online {
            background: #44ff44;
        }

        .network-status.offline {
            background: #ff4444;
        }

    </style>
</head>
<body>
    <div class="loading" id="loading">
        <div style="margin-bottom: 20px;">Cargando...</div>
        <div class="progress-container" id="progress-container">
            <div class="progress-bar-wrapper">
                <div class="progress-bar" id="progress-bar" style="width: 0%;">0%</div>
            </div>
            <div class="progress-text" id="progress-text">Preparando...</div>
        </div>
    </div>
    <div class="error-message" id="error">No se encontraron promociones activas</div>
    
    <!-- Consola de Debug -->
    <div class="debug-console" id="debug-console">
        <div class="debug-header">
            <div class="debug-title">🔧 Consola de Debug</div>
            <div class="debug-buttons">
                <button class="debug-clear" onclick="clearDebugLogs()">Limpiar</button>
                <button class="debug-close" onclick="toggleDebugConsole()">✕</button>
            </div>
        </div>
        <div id="debug-logs"></div>
        <div class="debug-stats" id="debug-stats"></div>
    </div>
    
    <div class="carousel-container" id="carousel">
        <?php if (!empty($promocionales)): ?>
            <?php foreach ($promocionales as $index => $promo): ?>
                <?php
                    $ext = strtolower($promo['extension']);
                    $isVideo = in_array($ext, ['mp4', 'webm', 'ogg']);
                    $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                    // Si no hay duración configurada en BD, se usará 30s por defecto
                    $duracionMs = isset($promo['duracion_ms']) && (int)$promo['duracion_ms'] > 0
                        ? (int)$promo['duracion_ms']
                        : 0;
                ?>
                <?php 
                    // Manejar horarios: si son null o vacíos, usar cadena vacía
                    $horaInicio = isset($promo['hora_inicio']) && $promo['hora_inicio'] !== null && trim($promo['hora_inicio']) !== '' 
                        ? trim($promo['hora_inicio']) 
                        : '';
                    $horaFin = isset($promo['hora_fin']) && $promo['hora_fin'] !== null && trim($promo['hora_fin']) !== '' 
                        ? trim($promo['hora_fin']) 
                        : '';
                ?>
                <div class="carousel-slide <?php echo $index === 0 ? 'active' : ''; ?>" 
                     data-duration="<?php echo $duracionMs > 0 ? $duracionMs : 0; ?>"
                     data-type="<?php echo $isVideo ? 'video' : 'image'; ?>"
                     data-hora-inicio="<?php echo htmlspecialchars($horaInicio, ENT_QUOTES); ?>"
                     data-hora-fin="<?php echo htmlspecialchars($horaFin, ENT_QUOTES); ?>"
                     data-filename="<?php echo htmlspecialchars($promo['nombre_archivo']); ?>"
                     data-size="<?php echo isset($promo['tamano_bytes']) ? (int)$promo['tamano_bytes'] : 0; ?>"
                     data-modified="<?php echo isset($promo['fecha_modificacion']) ? strtotime($promo['fecha_modificacion']) : (isset($promo['fecha_subida']) ? strtotime($promo['fecha_subida']) : time()); ?>">
                    <?php if ($isVideo): ?>
                        <div class="video-status" id="video-status-<?php echo $index; ?>">Cargando...</div>
                        <div class="video-error-message" id="video-error-<?php echo $index; ?>">
                            Error al cargar el video<br>
                            <small>Reintentando...</small>
                        </div>
                        <video 
                            src="<?php echo htmlspecialchars($promo['ruta_archivo']); ?>" 
                            muted
                            playsinline
                            loop
                            preload="<?php echo $index === 0 ? 'auto' : 'metadata'; ?>"
                            style="display: none;"
                            data-original-src="<?php echo htmlspecialchars($promo['ruta_archivo']); ?>"
                            data-slide-index="<?php echo $index; ?>"
                            webkit-playsinline="true"
                            crossorigin="anonymous"
                        ></video>
                    <?php elseif ($isImage): ?>
                        <img 
                            src="<?php echo htmlspecialchars($promo['ruta_archivo']); ?>" 
                            alt="<?php echo htmlspecialchars($promo['nombre_archivo']); ?>"
                            loading="eager"
                            data-original-src="<?php echo htmlspecialchars($promo['ruta_archivo']); ?>"
                        >
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <script>
        (function () {
            let allSlides = Array.from(document.querySelectorAll('.carousel-slide'));
            const loading = document.getElementById('loading');
            const error = document.getElementById('error');
            const carouselContainer = document.getElementById('carousel');
            const debugConsole = document.getElementById('debug-console');
            const debugLogs = document.getElementById('debug-logs');
            const debugStats = document.getElementById('debug-stats');

            // ========== SISTEMA DE LOGGING PERSISTENTE ==========
            const logs = [];
            const MAX_LOGS = 200;
            let isDebugVisible = false;

            function debugLog(message, type = 'info', data = null) {
                const timestamp = new Date().toLocaleTimeString();
                const logEntry = {
                    timestamp,
                    message,
                    type,
                    data
                };
                
                logs.push(logEntry);
                if (logs.length > MAX_LOGS) {
                    logs.shift();
                }
                
                // También loggear en consola del navegador
                const consoleMethod = type === 'error' ? 'error' : type === 'warn' ? 'warn' : 'log';
                console[consoleMethod](`[${timestamp}] ${message}`, data || '');
                
                // Actualizar UI si está visible
                if (isDebugVisible) {
                    updateDebugConsole();
                }
            }

            function updateDebugConsole() {
                if (!debugLogs) return;
                
                debugLogs.innerHTML = '';
                const recentLogs = logs.slice(-50); // Mostrar últimos 50
                
                recentLogs.forEach(log => {
                    const logDiv = document.createElement('div');
                    logDiv.className = `debug-log ${log.type}`;
                    logDiv.innerHTML = `<strong>[${log.timestamp}]</strong> ${log.message}`;
                    if (log.data) {
                        logDiv.innerHTML += `<br><small>${JSON.stringify(log.data, null, 2)}</small>`;
                    }
                    debugLogs.appendChild(logDiv);
                });
                
                debugLogs.scrollTop = debugLogs.scrollHeight;
                updateDebugStats();
            }

            function updateDebugStats() {
                if (!debugStats) return;
                
                // Contar videos cargados exitosamente
                let videosLoaded = 0;
                videoLoadStatus.forEach(status => {
                    if (status.loaded) videosLoaded++;
                });
                
                const stats = {
                    'Total Slides': allSlides.length,
                    'Slides Visibles': slides.length,
                    'Slide Actual': currentIndex + 1,
                    'Red': `<span class="network-status ${navigator.onLine ? 'online' : 'offline'}"></span>${navigator.onLine ? 'Online' : 'Offline'}`,
                    'Videos Cargados': `${videosLoaded}/${videoLoadStatus.size}`,
                    'Reintentos Totales': totalRetries,
                    'Errores': errorCount,
                    'Memoria (MB)': getMemoryUsage(),
                    'Modo TV': isTV ? 'Sí' : 'No'
                };
                
                debugStats.innerHTML = '<strong>Estadísticas:</strong><br>';
                Object.entries(stats).forEach(([key, value]) => {
                    const statDiv = document.createElement('div');
                    statDiv.className = 'debug-stat';
                    statDiv.innerHTML = `<span>${key}:</span> <span>${value}</span>`;
                    debugStats.appendChild(statDiv);
                });
            }

            function getMemoryUsage() {
                if (performance.memory) {
                    return (performance.memory.usedJSHeapSize / 1048576).toFixed(2);
                }
                return 'N/A';
            }

            // Toggle consola de debug con doble click
            function setupDebugConsoleToggle() {
                if (!debugConsole) {
                    console.warn('Consola de debug no encontrada, reintentando...');
                    setTimeout(setupDebugConsoleToggle, 100);
                    return;
                }
                
                document.addEventListener('dblclick', (e) => {
                    // No activar si el click es en la consola misma o sus botones
                    if (debugConsole && debugConsole.contains(e.target)) {
                        return;
                    }
                    // Activar en cualquier parte de la pantalla
                    toggleDebugConsole();
                });
                
                console.log('Evento de doble click registrado para consola de debug');
            }
            
            // Función para manejar el scroll en la consola con flecha hacia abajo
            function setupDebugConsoleScroll() {
                if (!debugConsole || !debugLogs) {
                    setTimeout(setupDebugConsoleScroll, 100);
                    return;
                }
                
                // Listener único para evitar duplicados
                if (window.debugConsoleScrollListener) {
                    document.removeEventListener('keydown', window.debugConsoleScrollListener);
                }
                
                window.debugConsoleScrollListener = (e) => {
                    // Solo actuar si la consola está visible
                    if (!isDebugVisible || !debugConsole.classList.contains('visible')) {
                        return;
                    }
                    
                    // Detectar flecha hacia abajo (ArrowDown o código 40)
                    if (e.key === 'ArrowDown' || e.keyCode === 40) {
                        e.preventDefault(); // Prevenir scroll de la página
                        e.stopPropagation(); // Evitar que otros listeners actúen
                        
                        if (debugLogs) {
                            // Hacer scroll hacia abajo en el contenedor de logs
                            const scrollAmount = 80; // Píxeles a desplazar
                            const currentScroll = debugLogs.scrollTop;
                            const maxScroll = debugLogs.scrollHeight - debugLogs.clientHeight;
                            
                            // Si ya está al final, hacer scroll en la consola principal
                            if (currentScroll >= maxScroll - 10) {
                                if (debugConsole.scrollHeight > debugConsole.clientHeight) {
                                    debugConsole.scrollTop = Math.min(
                                        debugConsole.scrollTop + scrollAmount,
                                        debugConsole.scrollHeight - debugConsole.clientHeight
                                    );
                                }
                            } else {
                                debugLogs.scrollTop = Math.min(currentScroll + scrollAmount, maxScroll);
                            }
                        }
                    }
                    
                    // También soportar flecha hacia arriba para scroll inverso
                    if (e.key === 'ArrowUp' || e.keyCode === 38) {
                        e.preventDefault();
                        e.stopPropagation();
                        
                        if (debugLogs) {
                            const scrollAmount = 80;
                            const currentScroll = debugLogs.scrollTop;
                            
                            // Si está al inicio, hacer scroll en la consola principal
                            if (currentScroll <= 10) {
                                if (debugConsole.scrollHeight > debugConsole.clientHeight) {
                                    debugConsole.scrollTop = Math.max(
                                        debugConsole.scrollTop - scrollAmount,
                                        0
                                    );
                                }
                            } else {
                                debugLogs.scrollTop = Math.max(currentScroll - scrollAmount, 0);
                            }
                        }
                    }
                };
                
                document.addEventListener('keydown', window.debugConsoleScrollListener);
                console.log('Eventos de teclado registrados para scroll de consola de debug');
            }
            
            // Configurar el evento cuando el DOM esté listo
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', () => {
                    setupDebugConsoleToggle();
                    setupDebugConsoleScroll();
                });
            } else {
                setupDebugConsoleToggle();
                setupDebugConsoleScroll();
            }

            function toggleDebugConsole() {
                if (!debugConsole) {
                    console.warn('Consola de debug no encontrada');
                    return;
                }
                
                isDebugVisible = !isDebugVisible;
                if (isDebugVisible) {
                    debugConsole.classList.add('visible');
                    updateDebugConsole();
                    console.log('Consola de debug abierta');
                } else {
                    debugConsole.classList.remove('visible');
                    console.log('Consola de debug cerrada');
                }
            }

            function clearDebugLogs() {
                logs.length = 0;
                updateDebugConsole();
                debugLog('Logs limpiados', 'info');
            }

            // Hacer funciones globales para los botones
            window.toggleDebugConsole = toggleDebugConsole;
            window.clearDebugLogs = clearDebugLogs;

            // ========== MONITOREO DE RED ==========
            let isOnline = navigator.onLine;
            let networkCheckInterval = null;

            function startNetworkMonitoring() {
                window.addEventListener('online', () => {
                    isOnline = true;
                    debugLog('Conexión de red restaurada', 'info');
                    retryFailedVideos();
                });

                window.addEventListener('offline', () => {
                    isOnline = false;
                    debugLog('Conexión de red perdida', 'warn');
                });

                // Verificar red cada 5 segundos
                networkCheckInterval = setInterval(() => {
                    const wasOnline = isOnline;
                    isOnline = navigator.onLine;
                    
                    if (!wasOnline && isOnline) {
                        debugLog('Conexión de red restaurada (verificación)', 'info');
                        retryFailedVideos();
                    } else if (wasOnline && !isOnline) {
                        debugLog('Conexión de red perdida (verificación)', 'warn');
                    }
                }, 5000);
            }

            // ========== GESTIÓN DE VIDEOS CON REINTENTOS ==========
            const videoLoadStatus = new Map();
            const videoRetries = new Map();
            const MAX_RETRIES = 5;
            const RETRY_DELAY = 2000;
            let totalRetries = 0;
            let errorCount = 0;
            const isTV = detectTV();

            function detectTV() {
                // Detectar si es TV basado en características comunes
                const ua = navigator.userAgent.toLowerCase();
                const isSmartTV = /smart-tv|smarttv|googletv|appletv|hbbtv|netcast|roku|viera|bravia|panasonic|samsung|lg|philips|sharp|sony|toshiba/i.test(ua);
                const isLargeScreen = window.screen.width >= 1920 && window.screen.height >= 1080;
                const hasTouch = 'ontouchstart' in window;
                return (isSmartTV || (isLargeScreen && !hasTouch));
            }

            function updateVideoStatus(slideIndex, status, details = '') {
                // Función removida - ya no se muestra el estado del video
            }

            async function loadVideoWithRetry(video, slideIndex, retryCount = 0) {
                // Asegurar que siempre tengamos un src válido
                let videoSrc = video.getAttribute('data-original-src') || video.src || '';
                
                // Si no hay src, intentar obtenerlo del atributo src del elemento
                if (!videoSrc || videoSrc === '') {
                    const srcAttr = video.getAttribute('src');
                    if (srcAttr) {
                        videoSrc = srcAttr;
                        // Asegurar que data-original-src también esté establecido
                        if (!video.getAttribute('data-original-src')) {
                            video.setAttribute('data-original-src', videoSrc);
                        }
                    } else {
                        debugLog(`Error crítico: video ${slideIndex + 1} no tiene src disponible`, 'error');
                        throw new Error('Video sin src disponible');
                    }
                }
                
                // Asegurar que el src del elemento esté establecido
                if (!video.src || video.src === '') {
                    video.src = videoSrc;
                    video.setAttribute('src', videoSrc);
                }
                
                const videoKey = `${slideIndex}-${videoSrc}`;
                
                if (!videoLoadStatus.has(videoKey)) {
                    videoLoadStatus.set(videoKey, {
                        attempts: 0,
                        loaded: false,
                        error: null,
                        lastAttempt: null
                    });
                }

                const status = videoLoadStatus.get(videoKey);
                status.attempts++;
                status.lastAttempt = new Date();
                
                debugLog(`Cargando video ${slideIndex + 1} (intento ${status.attempts}/${MAX_RETRIES + 1})`, 'info', {
                    src: videoSrc,
                    slideIndex
                });

                updateVideoStatus(slideIndex, `Cargando (${status.attempts}/${MAX_RETRIES + 1})`);

                return new Promise((resolve, reject) => {
                    // Limpiar eventos anteriores
                    const cleanup = () => {
                        video.removeEventListener('loadeddata', onLoadedData);
                        video.removeEventListener('canplay', onCanPlay);
                        video.removeEventListener('canplaythrough', onCanPlayThrough);
                        video.removeEventListener('progress', onProgress);
                        video.removeEventListener('error', onError);
                        video.removeEventListener('stalled', onStalled);
                        video.removeEventListener('waiting', onWaiting);
                        video.removeEventListener('suspend', onSuspend);
                    };

                    let timeoutId;
                    let hasResolved = false;

                    const resolveOnce = (success, data) => {
                        if (hasResolved) return;
                        hasResolved = true;
                        cleanup();
                        if (timeoutId) clearTimeout(timeoutId);
                        if (success) {
                            resolve(data);
                        } else {
                            reject(data);
                        }
                    };

                    // Simplificado: aceptar readyState >= 2 (HAVE_CURRENT_DATA) que es suficiente para reproducir
                    // El video puede seguir cargando mientras se reproduce
                    const targetReadyState = 2; // HAVE_CURRENT_DATA - suficiente para empezar
                    const timeoutDuration = isTV ? 60000 : 30000; // Timeout más largo para TVs (60s)

                    const onLoadedData = () => {
                        debugLog(`Video ${slideIndex + 1}: loadeddata (readyState: ${video.readyState})`, 'debug');
                        // Aceptar readyState >= 2 para empezar a reproducir
                        if (video.readyState >= targetReadyState) {
                            resolveOnce(true, { video, readyState: video.readyState });
                        } else if (isTV && video.readyState === 1) {
                            // En TVs, si solo tiene metadata (readyState 1), forzar carga adicional
                            debugLog(`Video ${slideIndex + 1} en TV solo tiene metadata (readyState: 1), forzando carga de datos...`, 'warn');
                            video.load();
                            
                            // Esperar un poco y verificar si mejoró
                            setTimeout(() => {
                                if (video.readyState >= 2 && !hasResolved) {
                                    debugLog(`Video ${slideIndex + 1} mejoró después de forzar carga (readyState: ${video.readyState})`, 'info');
                                    resolveOnce(true, { video, readyState: video.readyState });
                                } else if (video.readyState === 1 && !hasResolved) {
                                    // Si sigue en 1, intentar con cache busting
                                    const videoSrc = video.getAttribute('data-original-src') || video.src;
                                    if (videoSrc && !videoSrc.includes('?t=')) {
                                        const cacheBuster = '?t=' + Date.now();
                                        const newSrc = videoSrc + (videoSrc.includes('?') ? '&' : '?') + cacheBuster;
                                        debugLog(`Video ${slideIndex + 1} aún en readyState 1, recargando con cache busting...`, 'warn');
                                        video.src = newSrc;
                                        video.setAttribute('src', newSrc);
                                        video.load();
                                    }
                                }
                            }, 2000);
                        }
                    };

                    const onCanPlay = () => {
                        debugLog(`Video ${slideIndex + 1}: canplay (readyState: ${video.readyState})`, 'info');
                        // canplay significa que puede empezar a reproducir
                        resolveOnce(true, { video, readyState: video.readyState });
                    };

                    const onCanPlayThrough = () => {
                        debugLog(`Video ${slideIndex + 1}: canplaythrough (readyState: ${video.readyState})`, 'info');
                        resolveOnce(true, { video, readyState: video.readyState });
                    };

                    const onProgress = () => {
                        // Si tiene datos suficientes y aún no se resolvió, resolver
                        if (video.readyState >= targetReadyState && !hasResolved) {
                            debugLog(`Video ${slideIndex + 1}: progreso suficiente (readyState: ${video.readyState})`, 'info');
                            resolveOnce(true, { video, readyState: video.readyState });
                        }
                    };

                    const onError = (e) => {
                        const error = video.error;
                        const errorMsg = error ? `Code: ${error.code}, Message: ${error.message}` : 'Error desconocido';
                        debugLog(`Error al cargar video ${slideIndex + 1}`, 'error', {
                            error: errorMsg,
                            code: error?.code,
                            attempt: status.attempts
                        });
                        errorCount++;
                        resolveOnce(false, { error, attempt: status.attempts });
                    };

                    const onStalled = () => {
                        debugLog(`Video ${slideIndex + 1}: stalled (descarga detenida) - readyState: ${video.readyState}, networkState: ${video.networkState}`, 'warn');
                        updateVideoStatus(slideIndex, 'Descarga detenida', 'Reintentando...');
                        
                        // En TVs, si está stalled y tiene readyState bajo, forzar recarga
                        if (isTV && video.readyState < 2) {
                            debugLog(`Video ${slideIndex + 1} stalled con readyState bajo en TV, forzando recarga...`, 'warn');
                            
                            // Esperar un poco y luego forzar carga
                            setTimeout(() => {
                                if (video.readyState < 2 && !hasResolved) {
                                    const videoSrc = video.getAttribute('data-original-src') || video.src;
                                    if (videoSrc) {
                                        // Agregar cache busting
                                        const cacheBuster = '?t=' + Date.now();
                                        const newSrc = videoSrc + (videoSrc.includes('?') ? '&' : '?') + cacheBuster;
                                        
                                        debugLog(`Recargando video ${slideIndex + 1} con cache busting`, 'info');
                                        video.src = newSrc;
                                        video.setAttribute('src', newSrc);
                                        video.load();
                                    }
                                }
                            }, 1000);
                        }
                    };

                    const onWaiting = () => {
                        debugLog(`Video ${slideIndex + 1}: waiting (buffering)`, 'debug');
                        updateVideoStatus(slideIndex, 'Buffering...');
                    };

                    const onSuspend = () => {
                        debugLog(`Video ${slideIndex + 1}: suspend (descarga suspendida) - readyState: ${video.readyState}`, 'warn');
                        // En TVs, si se suspende y tiene readyState bajo, intentar reanudar
                        if (isTV && video.readyState < 2 && !hasResolved) {
                            setTimeout(() => {
                                if (video.readyState < 2 && !hasResolved) {
                                    debugLog(`Video ${slideIndex + 1} suspendido con readyState bajo, intentando reanudar...`, 'warn');
                                    video.load();
                                }
                            }, 1000);
                        }
                    };

                    video.addEventListener('loadeddata', onLoadedData);
                    video.addEventListener('canplay', onCanPlay);
                    video.addEventListener('canplaythrough', onCanPlayThrough);
                    video.addEventListener('progress', onProgress);
                    video.addEventListener('error', onError);
                    video.addEventListener('stalled', onStalled);
                    video.addEventListener('waiting', onWaiting);
                    video.addEventListener('suspend', onSuspend);

                    // Timeout
                    timeoutId = setTimeout(() => {
                        if (!hasResolved) {
                            debugLog(`Timeout cargando video ${slideIndex + 1} (readyState: ${video.readyState})`, 'warn');
                            resolveOnce(false, { error: 'timeout', readyState: video.readyState });
                        }
                    }, timeoutDuration);

                    // Intentar cargar
                    try {
                        // NUNCA vaciar el src sin tener uno nuevo listo
                        // Solo cambiar el src si es diferente
                        const currentSrc = video.src || video.getAttribute('src') || '';
                        
                        if (currentSrc !== videoSrc) {
                            // Si hay un src actual diferente, primero pausar y resetear
                            if (currentSrc) {
                                video.pause();
                                video.currentTime = 0;
                            }
                            
                            // En TVs, agregar cache busting para evitar problemas de cache
                            let finalSrc = videoSrc;
                            if (isTV && status.attempts > 1) {
                                // En reintentos, agregar cache busting
                                const cacheBuster = '?t=' + Date.now();
                                finalSrc = videoSrc + (videoSrc.includes('?') ? '&' : '?') + cacheBuster;
                                debugLog(`Video ${slideIndex + 1} en TV, usando cache busting en reintento ${status.attempts}`, 'info');
                            }
                            
                            // Establecer el nuevo src directamente (sin vaciar primero)
                            video.src = finalSrc;
                            video.setAttribute('src', finalSrc);
                            
                            // Verificar inmediatamente que el src se estableció
                            if (!video.src || video.src === '') {
                                debugLog(`Error crítico: src vacío después de establecer para video ${slideIndex + 1}`, 'error');
                                resolveOnce(false, { error: 'empty src after setting', videoSrc });
                                return;
                            }
                            
                            video.load();
                            
                            // En TVs, forzar carga más agresiva desde el inicio
                            if (isTV) {
                                // Esperar un poco y verificar si tiene datos
                                setTimeout(() => {
                                    if (video.readyState < 2 && !hasResolved) {
                                        debugLog(`Video ${slideIndex + 1} en TV sin datos suficientes (readyState: ${video.readyState}), forzando carga...`, 'warn');
                                        
                                        // Forzar carga múltiple veces
                                        let loadAttempts = 0;
                                        const maxLoadAttempts = 3;
                                        
                                        const forceLoad = () => {
                                            if (video.readyState < 2 && loadAttempts < maxLoadAttempts && !hasResolved) {
                                                loadAttempts++;
                                                debugLog(`Video ${slideIndex + 1} forzando carga ${loadAttempts}/${maxLoadAttempts}...`, 'debug');
                                                video.load();
                                                
                                                setTimeout(() => {
                                                    if (video.readyState >= 2 && !hasResolved) {
                                                        debugLog(`Video ${slideIndex + 1} mejoró después de forzar carga (readyState: ${video.readyState})`, 'info');
                                                    } else if (loadAttempts < maxLoadAttempts) {
                                                        forceLoad();
                                                    } else if (video.readyState === 1 && !hasResolved) {
                                                        // Si sigue en 1 después de todos los intentos, usar cache busting
                                                        const cacheBuster = '?t=' + Date.now();
                                                        const newSrc = videoSrc + (videoSrc.includes('?') ? '&' : '?') + cacheBuster;
                                                        debugLog(`Video ${slideIndex + 1} aún en readyState 1 después de ${maxLoadAttempts} intentos, usando cache busting...`, 'warn');
                                                        video.src = newSrc;
                                                        video.setAttribute('src', newSrc);
                                                        video.load();
                                                    }
                                                }, 1500);
                                            }
                                        };
                                        
                                        forceLoad();
                                    }
                                }, 2000);
                            }
                        } else {
                            // Si el src ya es correcto, solo cargar si no tiene datos
                            if (video.readyState < 1) {
                                video.load();
                            }
                        }
                    } catch (err) {
                        debugLog(`Excepción al cargar video ${slideIndex + 1}`, 'error', { error: err.message, videoSrc });
                        resolveOnce(false, { error: err.message });
                    }
                }).then((result) => {
                    // Verificación crítica: asegurar que el src nunca esté vacío después de cargar
                    const currentSrc = video.src || video.getAttribute('src') || '';
                    const originalSrc = video.getAttribute('data-original-src') || '';
                    
                    if (!currentSrc || currentSrc === '') {
                        debugLog(`ADVERTENCIA: Video ${slideIndex + 1} tiene src vacío después de cargar, restaurando...`, 'error');
                        if (originalSrc) {
                            video.src = originalSrc;
                            video.setAttribute('src', originalSrc);
                            video.load();
                        } else {
                            debugLog(`ERROR CRÍTICO: No hay src disponible para restaurar video ${slideIndex + 1}`, 'error');
                            throw new Error('Empty src after load - no original src available');
                        }
                    }
                    
                    status.loaded = true;
                    status.error = null;
                    updateVideoStatus(slideIndex, '✓ Cargado', `readyState: ${result.readyState}`);
                    debugLog(`Video ${slideIndex + 1} cargado exitosamente`, 'info', {
                        readyState: result.readyState,
                        duration: video.duration,
                        attempts: status.attempts,
                        src: video.src
                    });
                    return result;
                }).catch(async (error) => {
                    status.error = error;
                    
                    if (status.attempts <= MAX_RETRIES && isOnline) {
                        totalRetries++;
                        const delay = RETRY_DELAY * status.attempts; // Backoff exponencial
                        debugLog(`Reintentando video ${slideIndex + 1} en ${delay}ms (intento ${status.attempts + 1})`, 'warn');
                        updateVideoStatus(slideIndex, `Reintentando... (${status.attempts}/${MAX_RETRIES})`);
                        
                        await new Promise(resolve => setTimeout(resolve, delay));
                        return loadVideoWithRetry(video, slideIndex, status.attempts);
                    } else {
                        updateVideoStatus(slideIndex, '✗ Error', `Después de ${status.attempts} intentos`);
                        debugLog(`Video ${slideIndex + 1} falló después de ${status.attempts} intentos`, 'error', error);
                        throw error;
                    }
                });
            }

            async function retryFailedVideos() {
                debugLog('Reintentando videos fallidos...', 'info');
                const failedVideos = [];
                
                allSlides.forEach((slide, index) => {
                    const video = slide.querySelector('video');
                    if (video) {
                        const videoSrc = video.getAttribute('data-original-src') || video.src;
                        const videoKey = `${index}-${videoSrc}`;
                        const status = videoLoadStatus.get(videoKey);
                        
                        if (status && !status.loaded && status.error) {
                            failedVideos.push({ video, slideIndex: index });
                        }
                    }
                });
                
                for (const { video, slideIndex } of failedVideos) {
                    try {
                        await loadVideoWithRetry(video, slideIndex, 0);
                    } catch (err) {
                        debugLog(`No se pudo cargar video ${slideIndex + 1} después de reintentos`, 'error');
                    }
                }
            }

            // Función para verificar si una promoción debe mostrarse según el horario local
            function shouldShowSlide(slide) {
                const horaInicio = slide.getAttribute('data-hora-inicio');
                const horaFin = slide.getAttribute('data-hora-fin');

                // Limpiar valores vacíos, null, undefined, "null" (string), o solo espacios
                let horaInicioClean = '';
                if (horaInicio && horaInicio.trim() !== '' && horaInicio.trim().toLowerCase() !== 'null') {
                    horaInicioClean = horaInicio.trim();
                }
                
                let horaFinClean = '';
                if (horaFin && horaFin.trim() !== '' && horaFin.trim().toLowerCase() !== 'null') {
                    horaFinClean = horaFin.trim();
                }

                // Si no tiene horario configurado (ambos vacíos), siempre se muestra
                if (horaInicioClean === '' && horaFinClean === '') {
                    return true; // Sin horario = siempre visible
                }

                // Obtener hora local del dispositivo
                const now = new Date();
                const currentHours = now.getHours();
                const currentMinutes = now.getMinutes();
                const currentTime = currentHours * 60 + currentMinutes; // minutos desde medianoche

                // Usar la función timeToMinutes definida más abajo

                const inicioMinutos = horaInicioClean ? timeToMinutes(horaInicioClean) : null;
                const finMinutos = horaFinClean ? timeToMinutes(horaFinClean) : null;

                // Verificar que los valores se convirtieron correctamente
                // Si alguno falló en la conversión pero había valor, no mostrar
                if (horaInicioClean && inicioMinutos === null) {
                    console.warn('Error al convertir hora_inicio:', horaInicioClean);
                    return false; // Si no se puede convertir, no mostrar
                }
                if (horaFinClean && finMinutos === null) {
                    console.warn('Error al convertir hora_fin:', horaFinClean);
                    return false; // Si no se puede convertir, no mostrar
                }

                // Si solo hay hora de inicio (mostrar desde esa hora hasta medianoche)
                if (inicioMinutos !== null && finMinutos === null) {
                    const resultado = currentTime >= inicioMinutos;
                    return resultado;
                }

                // Si solo hay hora de fin (mostrar desde medianoche hasta esa hora, excluyendo la hora de fin)
                if (inicioMinutos === null && finMinutos !== null) {
                    const resultado = currentTime < finMinutos;
                    return resultado;
                }

                // Si hay ambas horas
                if (inicioMinutos !== null && finMinutos !== null) {
                    // Si el horario no cruza medianoche (ej: 09:00 - 18:00)
                    if (inicioMinutos <= finMinutos) {
                        // Incluir inicio (>=) pero excluir fin (<) para que se oculte exactamente a la hora de fin
                        const resultado = currentTime >= inicioMinutos && currentTime < finMinutos;
                        return resultado;
                    } else {
                        // Si el horario cruza medianoche (ej: 22:00 - 06:00)
                        // Incluir desde inicio hasta medianoche, y desde medianoche hasta fin (excluyendo fin)
                        const resultado = currentTime >= inicioMinutos || currentTime < finMinutos;
                        return resultado;
                    }
                }

                // Si llegamos aquí sin retornar, hay un caso no manejado
                // Por seguridad, no mostrar si hay algún horario configurado pero no se cumplió
                return false;
            }

            // Mantener el loading visible hasta que todo esté listo
            let currentIndex = 0;
            let timeoutId = null;
            let currentVersion = null;
            let slides = [];
            let scheduleTimeouts = []; // Array para guardar los timeouts programados
            let videoTimeouts = new Map(); // Para limpiar timeouts de videos
            let versionCheckInterval = null; // Intervalo para verificar versión

            // Función para convertir tiempo a minutos desde medianoche
            // Acepta formatos HH:MM o HH:MM:SS
            function timeToMinutes(timeStr) {
                if (!timeStr || timeStr.trim() === '') {
                    return null;
                }
                
                const trimmed = timeStr.trim();
                const parts = trimmed.split(':');
                
                // Debug: ver qué estamos recibiendo
                if (parts.length !== 2 && parts.length !== 3) {
                    console.warn('[timeToMinutes] Formato inválido - partes:', parts.length, 'valor:', JSON.stringify(timeStr));
                    return null;
                }
                
                const hours = parseInt(parts[0], 10);
                const minutes = parseInt(parts[1], 10);
                
                if (isNaN(hours) || isNaN(minutes)) {
                    console.warn('[timeToMinutes] No se pudieron parsear - horas:', parts[0], 'minutos:', parts[1], 'valor original:', JSON.stringify(timeStr));
                    return null;
                }
                
                if (hours < 0 || hours > 23 || minutes < 0 || minutes > 59) {
                    console.warn('[timeToMinutes] Hora fuera de rango - horas:', hours, 'minutos:', minutes, 'valor original:', JSON.stringify(timeStr));
                    return null;
                }
                
                // Ignorar segundos si existen (parts[2])
                const result = hours * 60 + minutes;
                return result;
            }

            // Función para calcular milisegundos hasta una hora específica
            function getMsUntilTime(targetMinutes) {
                const now = new Date();
                const currentMinutes = now.getHours() * 60 + now.getMinutes();
                const currentSeconds = now.getSeconds();
                const currentMs = now.getMilliseconds();
                
                let minutesUntil = targetMinutes - currentMinutes;
                
                // Si la hora ya pasó hoy, programar para mañana
                if (minutesUntil <= 0) {
                    minutesUntil += 24 * 60; // Sumar 24 horas
                }
                
                // Convertir a milisegundos (restar segundos y ms actuales para ser preciso)
                const totalMs = (minutesUntil * 60 - currentSeconds) * 1000 - currentMs;
                return totalMs;
            }

            // Función para obtener todos los tiempos de entrada y salida de los slides
            function getScheduleTimes() {
                const scheduleTimes = [];
                
                allSlides.forEach(slide => {
                    const horaInicio = slide.getAttribute('data-hora-inicio');
                    const horaFin = slide.getAttribute('data-hora-fin');
                    
                    // Limpiar valores
                    let horaInicioClean = '';
                    if (horaInicio && horaInicio.trim() !== '' && horaInicio.trim().toLowerCase() !== 'null') {
                        horaInicioClean = horaInicio.trim();
                    }
                    
                    let horaFinClean = '';
                    if (horaFin && horaFin.trim() !== '' && horaFin.trim().toLowerCase() !== 'null') {
                        horaFinClean = horaFin.trim();
                    }
                    
                    // Si no tiene horario, no necesita programación
                    if (!horaInicioClean && !horaFinClean) {
                        return;
                    }
                    
                    const inicioMinutos = horaInicioClean ? timeToMinutes(horaInicioClean) : null;
                    const finMinutos = horaFinClean ? timeToMinutes(horaFinClean) : null;
                    
                    if (inicioMinutos !== null) {
                        scheduleTimes.push({
                            time: inicioMinutos,
                            slide: slide,
                            action: 'show',
                            horaStr: horaInicioClean
                        });
                    }
                    
                    if (finMinutos !== null) {
                        scheduleTimes.push({
                            time: finMinutos,
                            slide: slide,
                            action: 'hide',
                            horaStr: horaFinClean
                        });
                        
                        // Si el horario cruza medianoche y tiene hora de fin, también programar la salida de mañana
                        if (inicioMinutos !== null && inicioMinutos > finMinutos) {
                            // El horario cruza medianoche, la hora de fin es de "mañana" en el ciclo
                            // No necesitamos hacer nada especial, ya está programado
                        }
                    }
                });
                
                console.log(`[Horarios] Se encontraron ${scheduleTimes.length} eventos de horario para programar`);
                scheduleTimes.forEach(e => {
                    const horaDisplay = String(Math.floor(e.time / 60)).padStart(2, '0') + ':' + String(e.time % 60).padStart(2, '0');
                    console.log(`  - ${e.action} a las ${horaDisplay} (${e.horaStr})`);
                });
                
                return scheduleTimes;
            }

            // Función para programar cambios de horario
            function scheduleTimeChanges() {
                // Limpiar timeouts anteriores
                scheduleTimeouts.forEach(timeout => clearTimeout(timeout));
                scheduleTimeouts = [];

                const scheduleTimes = getScheduleTimes();
                console.log('[Horarios] Eventos programados encontrados:', scheduleTimes.length);
                
                scheduleTimes.forEach(event => {
                    const msUntil = getMsUntilTime(event.time);
                    const now = new Date();
                    const targetDate = new Date(now.getTime() + msUntil);
                    const horaStr = String(Math.floor(event.time / 60)).padStart(2, '0') + ':' + String(event.time % 60).padStart(2, '0');
                    
                    // Solo programar si es un tiempo válido en el futuro (hasta 24 horas)
                    if (msUntil > 0 && msUntil <= 24 * 60 * 60 * 1000) {
                        console.log(`[Horarios] Programando ${event.action} a las ${horaStr} (en ${Math.round(msUntil / 1000)} segundos)`);
                        
                        const timeout = setTimeout(() => {
                            console.log(`[Horarios] ⏰ Ejecutando evento: ${event.action} a las ${horaStr}`);
                            // Cuando llegue el momento, actualizar los slides
                            updateVisibleSlides();
                            // Reprogramar para el próximo ciclo
                            scheduleTimeChanges();
                        }, msUntil);
                        
                        scheduleTimeouts.push(timeout);
                    } else {
                        console.warn(`[Horarios] ⚠️ No se pudo programar ${event.action} a las ${horaStr} (msUntil: ${msUntil})`);
                    }
                });
            }

            // Función para actualizar qué slides deben mostrarse
            function updateVisibleSlides() {
                console.log('[Actualizar Slides] Iniciando actualización...');
                
                // Re-evaluar todos los slides
                const newSlides = allSlides.filter(slide => {
                    const shouldShow = shouldShowSlide(slide);
                    const horaInicio = slide.getAttribute('data-hora-inicio') || 'sin horario';
                    const horaFin = slide.getAttribute('data-hora-fin') || 'sin horario';
                    console.log(`[Actualizar Slides] Slide "${slide.getAttribute('data-filename')}" - Horario: ${horaInicio} - ${horaFin}, Mostrar: ${shouldShow}`);
                    return shouldShow;
                });
                
                // Actualizar la lista de slides visibles
                slides = newSlides;
                
                // Si no hay slides visibles, mostrar error
                if (slides.length === 0) {
                    console.warn('[Actualizar Slides] No hay slides visibles en este momento');
                    error.style.display = 'block';
                    loading.style.display = 'none';
                    return;
                }
                
                // Si el slide actual ya no es visible, avanzar al siguiente visible
                if (currentIndex >= slides.length || !slides.includes(slides[currentIndex])) {
                    currentIndex = 0;
                }
                
                // Actualizar qué slide está activo
                allSlides.forEach(slide => {
                    slide.classList.remove('active');
                    // Ocultar videos de slides inactivos de forma segura
                    const video = slide.querySelector('video');
                    if (video) {
                        try {
                            if (!video.paused) {
                                video.pause();
                            }
                        } catch (e) {
                            debugLog(`Error al pausar video en updateVisibleSlides: ${e.message}`, 'warn');
                        }
                        video.currentTime = 0;
                        video.style.display = 'none';
                    }
                });
                if (slides.length > 0 && slides[currentIndex]) {
                    slides[currentIndex].classList.add('active');
                    // Mostrar video del slide activo con carga mejorada
                    const activeVideo = slides[currentIndex].querySelector('video');
                    if (activeVideo) {
                        const slideIndex = allSlides.indexOf(slides[currentIndex]);
                        activeVideo.style.display = 'block';
                        // Asegurar que el video esté cargado antes de reproducir
                        const videoSrc = activeVideo.getAttribute('data-original-src') || activeVideo.src;
                        const videoKey = `${slideIndex}-${videoSrc}`;
                        const status = videoLoadStatus.get(videoKey);
                        
                        const tryPlayActiveVideo = async (retries = 3) => {
                            for (let i = 0; i < retries; i++) {
                                try {
                                    // Verificar que el video tenga un src válido
                                    const videoSrc = activeVideo.getAttribute('data-original-src') || activeVideo.src || '';
                                    if (!videoSrc || videoSrc === '') {
                                        debugLog(`Error: video activo no tiene src válido, estableciendo...`, 'error');
                                        const originalSrc = activeVideo.getAttribute('data-original-src');
                                        if (originalSrc) {
                                            activeVideo.src = originalSrc;
                                            activeVideo.setAttribute('src', originalSrc);
                                            activeVideo.load();
                                            await new Promise(resolve => setTimeout(resolve, 500));
                                        } else {
                                            debugLog(`Error: no hay src disponible para video activo`, 'error');
                                            break;
                                        }
                                    }
                                    
                                    // Simplificado: aceptar readyState >= 2
                                    const minReadyState = 2;
                                    
                                    if (activeVideo.readyState < minReadyState) {
                                        await new Promise((resolve) => {
                                            let resolved = false;
                                            const resolveOnce = () => {
                                                if (resolved) return;
                                                resolved = true;
                                                cleanup();
                                                resolve();
                                            };
                                            
                                            const cleanup = () => {
                                                activeVideo.removeEventListener('canplay', onCanPlay);
                                                activeVideo.removeEventListener('canplaythrough', onCanPlayThrough);
                                                activeVideo.removeEventListener('loadeddata', onLoadedData);
                                            };
                                            
                                            const onCanPlay = () => {
                                                debugLog(`Video activo: canplay (readyState: ${activeVideo.readyState})`, 'info');
                                                resolveOnce();
                                            };
                                            
                                            const onCanPlayThrough = () => {
                                                debugLog(`Video activo: canplaythrough (readyState: ${activeVideo.readyState})`, 'info');
                                                resolveOnce();
                                            };
                                            
                                            const onLoadedData = () => {
                                                if (activeVideo.readyState >= minReadyState) {
                                                    debugLog(`Video activo: loadeddata suficiente (readyState: ${activeVideo.readyState})`, 'info');
                                                    resolveOnce();
                                                }
                                            };
                                            
                                            activeVideo.addEventListener('canplay', onCanPlay, { once: true });
                                            activeVideo.addEventListener('canplaythrough', onCanPlayThrough, { once: true });
                                            activeVideo.addEventListener('loadeddata', onLoadedData);
                                            
                                            setTimeout(() => {
                                                if (!resolved) {
                                                    if (activeVideo.readyState >= 2) {
                                                        debugLog(`Video activo: timeout pero tiene readyState ${activeVideo.readyState}, continuando...`, 'warn');
                                                    }
                                                    resolveOnce();
                                                }
                                            }, 5000);
                                            
                                            if (activeVideo.readyState >= minReadyState) {
                                                resolveOnce();
                                            }
                                        });
                                    }
                                    
                                    // Verificar nuevamente que el src esté presente antes de reproducir
                                    if (!activeVideo.src || activeVideo.src === '') {
                                        debugLog(`Error: src vacío antes de reproducir video activo, reintentando...`, 'error');
                                        const originalSrc = activeVideo.getAttribute('data-original-src');
                                        if (originalSrc) {
                                            activeVideo.src = originalSrc;
                                            activeVideo.setAttribute('src', originalSrc);
                                            activeVideo.load();
                                            await new Promise(resolve => setTimeout(resolve, 1000));
                                        } else {
                                            throw new Error('Empty src attribute');
                                        }
                                    }
                                    
                                    activeVideo.currentTime = 0;
                                    
                                    // Reproducir de forma segura - aceptar readyState >= 2
                                    if (activeVideo.paused) {
                                        await new Promise(resolve => setTimeout(resolve, 100));
                                        
                                        if (activeVideo.readyState >= 2 && activeVideo.src) {
                                            const playPromise = activeVideo.play();
                                            if (playPromise !== undefined) {
                                                await playPromise;
                                            }
                                        } else {
                                            throw new Error(`Video activo no está listo (readyState: ${activeVideo.readyState})`);
                                        }
                                    }
                                    debugLog('Video activo reproduciendo', 'info');
                                    return true;
                                } catch (e) {
                                    const errorInfo = {
                                        message: e?.message || 'Error desconocido',
                                        code: activeVideo.error?.code || null,
                                        readyState: activeVideo.readyState,
                                        attempt: i + 1
                                    };
                                    
                                    debugLog(`Error al reproducir video activo (intento ${i + 1}/${retries})`, 'error', errorInfo);
                                    
                                    if (i < retries - 1) {
                                        await new Promise(resolve => setTimeout(resolve, 1000 * (i + 1)));
                                    }
                                }
                            }
                            return false;
                        };
                        
                        if (!status || !status.loaded) {
                            loadVideoWithRetry(activeVideo, slideIndex).then(() => {
                                tryPlayActiveVideo();
                            }).catch(err => {
                                debugLog('No se pudo cargar video activo', 'warn', err);
                            });
                        } else {
                            tryPlayActiveVideo();
                        }
                    }
                }
                
                console.log(`[Actualizar Slides] Actualización completada. ${slides.length} slides visibles, índice actual: ${currentIndex}`);
            }

            // Función para avanzar al siguiente slide
            async function nextSlide() {
                if (slides.length === 0) return;
                
                debugLog(`Avanzando de slide ${currentIndex + 1} a siguiente`, 'info');
                
                // Ocultar slide actual
                if (slides[currentIndex]) {
                    const prevSlide = slides[currentIndex];
                    prevSlide.classList.remove('active');
                    
                    // Limpiar timeout del video anterior
                    const slideIndex = allSlides.indexOf(prevSlide);
                    if (videoTimeouts.has(slideIndex)) {
                        clearTimeout(videoTimeouts.get(slideIndex));
                        videoTimeouts.delete(slideIndex);
                    }
                    
                    // Pausar y ocultar video del slide anterior de forma segura
                    const prevVideo = prevSlide.querySelector('video');
                    if (prevVideo) {
                        // Pausar de forma segura sin interrumpir otras operaciones
                        try {
                            if (!prevVideo.paused) {
                                prevVideo.pause();
                            }
                        } catch (e) {
                            debugLog(`Error al pausar video anterior: ${e.message}`, 'warn');
                        }
                        prevVideo.currentTime = 0;
                        prevVideo.style.display = 'none';
                        // NO liberar src aquí para evitar problemas de recarga
                        // El video se mantiene cargado para mejor rendimiento
                    }
                }
                
                // Avanzar al siguiente
                currentIndex = (currentIndex + 1) % slides.length;
                
                // Mostrar nuevo slide
                if (slides[currentIndex]) {
                    const nextSlide = slides[currentIndex];
                    nextSlide.classList.add('active');
                    
                    // Manejar video con carga mejorada
                    const video = nextSlide.querySelector('video');
                    if (video) {
                        const slideIndex = allSlides.indexOf(nextSlide);
                        
                        // IMPORTANTE: Mostrar el video ANTES de cargar para que el navegador lo cargue completamente
                        // Algunos navegadores/TVs no cargan videos ocultos completamente
                        video.style.display = 'block';
                        
                        // Verificar si el video ya está cargado
                        const videoSrc = video.getAttribute('data-original-src') || video.src;
                        const videoKey = `${slideIndex}-${videoSrc}`;
                        const status = videoLoadStatus.get(videoKey);
                        
                        if (!status || !status.loaded) {
                            updateVideoStatus(slideIndex, 'Cargando...');
                            try {
                                // Pequeño delay para asegurar que el elemento está visible
                                await new Promise(resolve => setTimeout(resolve, 100));
                                await loadVideoWithRetry(video, slideIndex);
                            } catch (err) {
                                debugLog(`No se pudo cargar video ${slideIndex + 1}, usando duración configurada`, 'warn');
                            }
                        } else {
                            // Si ya está cargado pero estaba oculto, verificar y recargar si es necesario
                            if (video.readyState < 2) {
                                debugLog(`Video ${slideIndex + 1} precargado pero con readyState bajo (${video.readyState}), recargando...`, 'warn');
                                // Forzar carga para obtener datos suficientes
                                video.load();
                                
                                // Esperar un poco para que cargue datos
                                await new Promise(resolve => setTimeout(resolve, 500));
                                
                                // Si aún no tiene datos suficientes, recargar con el src completo
                                if (video.readyState < 2) {
                                    const originalSrc = video.getAttribute('data-original-src') || video.src;
                                    if (originalSrc && video.src !== originalSrc) {
                                        video.src = originalSrc;
                                        video.load();
                                        await new Promise(resolve => setTimeout(resolve, 1000));
                                    }
                                }
                            }
                        }
                        
                        // Reproducir video con mejor manejo de errores
                        video.currentTime = 0;
                        
                        // Función auxiliar para intentar reproducir con reintentos
                        const tryPlayVideo = async (retries = 3) => {
                            for (let i = 0; i < retries; i++) {
                                try {
                                    // Verificar que el video tenga un src válido
                                    const videoSrc = video.getAttribute('data-original-src') || video.src || '';
                                    if (!videoSrc || videoSrc === '') {
                                        debugLog(`Error: video ${slideIndex + 1} no tiene src válido, estableciendo...`, 'error');
                                        const originalSrc = video.getAttribute('data-original-src');
                                        if (originalSrc) {
                                            video.src = originalSrc;
                                            video.setAttribute('src', originalSrc);
                                            video.load();
                                            await new Promise(resolve => setTimeout(resolve, 500));
                                        } else {
                                            debugLog(`Error: no hay src disponible para video ${slideIndex + 1}`, 'error');
                                            break;
                                        }
                                    }
                                    
                                    // Simplificado: aceptar readyState >= 2 (consistente con loadVideoWithRetry)
                                    const minReadyState = 2;
                                    
                                    if (video.readyState < minReadyState) {
                                        debugLog(`Video ${slideIndex + 1} no está listo (readyState: ${video.readyState}, requiere: ${minReadyState}), esperando y forzando carga...`, 'warn');
                                        
                                        // Forzar carga adicional antes de esperar eventos
                                        video.load();
                                        
                                        // Esperar múltiples eventos para asegurar que esté listo
                                        await new Promise((resolve) => {
                                            let resolved = false;
                                            let loadAttempts = 0;
                                            const maxLoadAttempts = 10;
                                            
                                            const resolveOnce = () => {
                                                if (resolved) return;
                                                resolved = true;
                                                cleanup();
                                                resolve();
                                            };
                                            
                                            const cleanup = () => {
                                                video.removeEventListener('canplay', onCanPlay);
                                                video.removeEventListener('canplaythrough', onCanPlayThrough);
                                                video.removeEventListener('loadeddata', onLoadedData);
                                                video.removeEventListener('progress', onProgress);
                                            };
                                            
                                            const forceLoad = () => {
                                                if (!resolved && loadAttempts < maxLoadAttempts && video.readyState < minReadyState) {
                                                    loadAttempts++;
                                                    debugLog(`Forzando carga video ${slideIndex + 1} (intento ${loadAttempts}, readyState: ${video.readyState})`, 'debug');
                                                    video.load();
                                                    
                                                    setTimeout(() => {
                                                        if (!resolved && video.readyState < minReadyState) {
                                                            forceLoad();
                                                        }
                                                    }, 500);
                                                }
                                            };
                                            
                                            const onCanPlay = () => {
                                                if (video.readyState >= minReadyState) {
                                                    resolveOnce();
                                                } else {
                                                    forceLoad();
                                                }
                                            };
                                            
                                            const onCanPlayThrough = () => {
                                                if (video.readyState >= minReadyState) {
                                                    resolveOnce();
                                                }
                                            };
                                            
                                            const onLoadedData = () => {
                                                if (video.readyState >= minReadyState) {
                                                    resolveOnce();
                                                } else {
                                                    forceLoad();
                                                }
                                            };
                                            
                                            const onProgress = () => {
                                                if (video.readyState >= minReadyState) {
                                                    resolveOnce();
                                                }
                                            };
                                            
                                            video.addEventListener('canplay', onCanPlay);
                                            video.addEventListener('canplaythrough', onCanPlayThrough);
                                            video.addEventListener('loadeddata', onLoadedData);
                                            video.addEventListener('progress', onProgress);
                                            
                                            // Iniciar carga forzada
                                            forceLoad();
                                            
                                            // Timeout más largo para TVs
                                            setTimeout(() => {
                                                if (!resolved) {
                                                    debugLog(`Timeout esperando video ${slideIndex + 1} (readyState: ${video.readyState}, requiere: ${minReadyState})`, 'warn');
                                                    // Si tiene al menos readyState 2, continuar (puede reproducir mientras carga)
                                                    if (video.readyState >= 2) {
                                                        debugLog(`Continuando con readyState ${video.readyState} - puede reproducir mientras carga`, 'info');
                                                        resolveOnce();
                                                    } else {
                                                        // Si tiene readyState 1, intentar una última vez
                                                        debugLog(`Video ${slideIndex + 1} solo tiene metadata, forzando última carga...`, 'warn');
                                                        video.load();
                                                        setTimeout(() => {
                                                            resolveOnce(); // Continuar de todas formas
                                                        }, 2000);
                                                    }
                                                }
                                            }, isTV ? 15000 : 8000); // Más tiempo en TVs
                                            
                                            // Verificar inmediatamente si ya está listo
                                            if (video.readyState >= minReadyState) {
                                                resolveOnce();
                                            }
                                        });
                                    }
                                    
                                    // Verificación final: si aún no está listo después de esperar, intentar continuar de todas formas
                                    if (video.readyState < minReadyState) {
                                        if (video.readyState >= 1) {
                                            debugLog(`Video ${slideIndex + 1} tiene metadata (readyState: ${video.readyState}), intentando reproducir mientras carga...`, 'warn');
                                            // Intentar reproducir de todas formas - puede funcionar
                                        } else {
                                            debugLog(`Video ${slideIndex + 1} sin datos (readyState: ${video.readyState}), forzando carga...`, 'warn');
                                            video.load();
                                            await new Promise(resolve => setTimeout(resolve, 2000));
                                        }
                                    }
                                    
                                    // Verificar nuevamente que el src esté presente antes de reproducir
                                    if (!video.src || video.src === '') {
                                        debugLog(`Error: src vacío antes de reproducir video ${slideIndex + 1}, reintentando...`, 'error');
                                        const originalSrc = video.getAttribute('data-original-src');
                                        if (originalSrc) {
                                            video.src = originalSrc;
                                            video.setAttribute('src', originalSrc);
                                            video.load();
                                            await new Promise(resolve => setTimeout(resolve, 1000));
                                        } else {
                                            throw new Error('Empty src attribute');
                                        }
                                    }
                                    
                                    // Asegurar que el video no esté pausado antes de reproducir
                                    if (video.paused) {
                                        // Esperar un pequeño delay para asegurar que no haya conflictos
                                        await new Promise(resolve => setTimeout(resolve, 100));
                                        
                                        // Verificar que el video tenga al menos metadata (readyState >= 1)
                                        // Aceptar readyState >= 1 para intentar reproducir (puede cargar mientras reproduce)
                                        if (video.readyState >= 1 && video.src) {
                                            // Ocultar mensaje de error si existe
                                            const errorMsg = nextSlide.querySelector(`#video-error-${slideIndex}`);
                                            if (errorMsg) {
                                                errorMsg.style.display = 'none';
                                            }
                                            nextSlide.classList.remove('video-error');
                                            
                                            const playPromise = video.play();
                                            
                                            // Manejar la promesa correctamente
                                            if (playPromise !== undefined) {
                                                await playPromise;
                                            }
                                        } else {
                                            // Mostrar mensaje de error en lugar de pantalla negra
                                            const errorMsg = nextSlide.querySelector(`#video-error-${slideIndex}`);
                                            if (errorMsg) {
                                                errorMsg.style.display = 'block';
                                                errorMsg.innerHTML = `Video no está listo<br><small>ReadyState: ${video.readyState} (requiere: ${minReadyState})</small>`;
                                            }
                                            nextSlide.classList.add('video-error');
                                            // Intentar reproducir de todas formas si tiene al menos metadata
                                            if (video.readyState >= 1) {
                                                debugLog(`Video ${slideIndex + 1} solo tiene metadata, intentando reproducir mientras carga...`, 'warn');
                                            } else {
                                                throw new Error(`Video no está listo (readyState: ${video.readyState})`);
                                            }
                                        }
                                    } else {
                                        // Si ya está reproduciendo, solo loggear
                                        debugLog(`Video ${slideIndex + 1} ya está reproduciendo`, 'info');
                                        // Ocultar mensaje de error si existe
                                        const errorMsg = nextSlide.querySelector(`#video-error-${slideIndex}`);
                                        if (errorMsg) {
                                            errorMsg.style.display = 'none';
                                        }
                                        nextSlide.classList.remove('video-error');
                                    }
                                    debugLog(`Video ${slideIndex + 1} reproduciendo`, 'info');
                                    updateVideoStatus(slideIndex, '✓ Reproduciendo');
                                    return true;
                                } catch (e) {
                                    const errorInfo = {
                                        message: e?.message || 'Error desconocido',
                                        name: e?.name || 'Error',
                                        code: video.error?.code || null,
                                        errorMessage: video.error?.message || null,
                                        readyState: video.readyState,
                                        networkState: video.networkState,
                                        attempt: i + 1
                                    };
                                    
                                    debugLog(`Error al reproducir video ${slideIndex + 1} (intento ${i + 1}/${retries})`, 'error', errorInfo);
                                    
                                    if (i < retries - 1) {
                                        // Si hay un error de carga, intentar recargar
                                        if (video.error && video.error.code === 4) {
                                            debugLog(`Error de formato en video ${slideIndex + 1}, recargando...`, 'warn');
                                            const videoSrc = video.getAttribute('data-original-src') || video.src || '';
                                            
                                            if (!videoSrc || videoSrc === '') {
                                                debugLog(`Error: no hay src disponible para recargar video ${slideIndex + 1}`, 'error');
                                                break;
                                            }
                                            
                                            // Pausar de forma segura antes de cambiar src
                                            try {
                                                if (!video.paused) {
                                                    video.pause();
                                                }
                                            } catch (pauseErr) {
                                                debugLog(`Error al pausar video ${slideIndex + 1} para recargar: ${pauseErr.message}`, 'warn');
                                            }
                                            video.currentTime = 0;
                                            
                                            // NUNCA vaciar el src - establecer el nuevo directamente
                                            // Si el src es diferente, cambiarlo directamente
                                            if (video.src !== videoSrc) {
                                                video.src = videoSrc;
                                                video.setAttribute('src', videoSrc);
                                                
                                                // Verificar inmediatamente que el src se estableció
                                                if (!video.src || video.src === '') {
                                                    debugLog(`Error crítico: src vacío después de recargar video ${slideIndex + 1}`, 'error');
                                                    break;
                                                }
                                                
                                                video.load();
                                                
                                                // Esperar a que el video se cargue
                                                await new Promise(resolve => setTimeout(resolve, 1000));
                                            } else {
                                                // Si el src es el mismo, solo recargar
                                                video.load();
                                                await new Promise(resolve => setTimeout(resolve, 500));
                                            }
                                        }
                                        
                                        await new Promise(resolve => setTimeout(resolve, 1000 * (i + 1)));
                                    } else {
                                        updateVideoStatus(slideIndex, '✗ Error reproducción');
                                        debugLog(`Error persistente reproduciendo video ${slideIndex + 1} después de ${retries} intentos`, 'error', errorInfo);
                                        
                                        // Mostrar mensaje de error en lugar de pantalla negra
                                        const errorMsg = nextSlide.querySelector(`#video-error-${slideIndex}`);
                                        if (errorMsg) {
                                            errorMsg.style.display = 'block';
                                            const errorText = errorInfo.message || 'Error desconocido';
                                            const readyStateText = `ReadyState: ${errorInfo.readyState}`;
                                            errorMsg.innerHTML = `Error al reproducir video<br><small>${errorText}<br>${readyStateText}</small>`;
                                        }
                                        nextSlide.classList.add('video-error');
                                    }
                                }
                            }
                            return false;
                        };
                        
                        await tryPlayVideo();
                    }
                }
                
                // Programar siguiente cambio
                scheduleNextSlide();
            }

            // Función para programar el siguiente cambio de slide
            function scheduleNextSlide() {
                // Limpiar timeout anterior
                if (timeoutId) {
                    clearTimeout(timeoutId);
                    timeoutId = null;
                }
                
                if (slides.length === 0) return;
                
                const currentSlide = slides[currentIndex];
                if (!currentSlide) return;
                
                const duration = parseInt(currentSlide.getAttribute('data-duration')) || 30000; // Default 30s
                const slideType = currentSlide.getAttribute('data-type');
                const slideIndex = allSlides.indexOf(currentSlide);
                
                // Para videos, usar la duración del video si está disponible
                if (slideType === 'video') {
                    const video = currentSlide.querySelector('video');
                    if (video) {
                        // Función mejorada para obtener duración del video
                        const getVideoDuration = () => {
                            return new Promise((resolve) => {
                                // Si ya tiene duración válida, usarla inmediatamente
                                if (video.readyState >= 2 && video.duration && !isNaN(video.duration) && video.duration > 0) {
                                    resolve(video.duration);
                                    return;
                                }
                                
                                // Esperar eventos de carga de metadata
                                let resolved = false;
                                const resolveOnce = (duration) => {
                                    if (resolved) return;
                                    resolved = true;
                                    cleanup();
                                    resolve(duration);
                                };
                                
                                const cleanup = () => {
                                    video.removeEventListener('loadedmetadata', onLoadedMetadata);
                                    video.removeEventListener('durationchange', onDurationChange);
                                    video.removeEventListener('loadeddata', onLoadedData);
                                };
                                
                                const onLoadedMetadata = () => {
                                    if (video.duration && !isNaN(video.duration) && video.duration > 0) {
                                        resolveOnce(video.duration);
                                    }
                                };
                                
                                const onDurationChange = () => {
                                    if (video.duration && !isNaN(video.duration) && video.duration > 0) {
                                        resolveOnce(video.duration);
                                    }
                                };
                                
                                const onLoadedData = () => {
                                    if (video.readyState >= 2 && video.duration && !isNaN(video.duration) && video.duration > 0) {
                                        resolveOnce(video.duration);
                                    }
                                };
                                
                                video.addEventListener('loadedmetadata', onLoadedMetadata, { once: true });
                                video.addEventListener('durationchange', onDurationChange, { once: true });
                                video.addEventListener('loadeddata', onLoadedData, { once: true });
                                
                                // Timeout de seguridad: esperar hasta 6 segundos
                                setTimeout(() => {
                                    if (!resolved) {
                                        cleanup();
                                        // Si el video tiene algún readyState pero sin duración, usar duración configurada
                                        if (video.readyState >= 2) {
                                            debugLog(`Video ${slideIndex + 1} sin duración después de esperar (readyState: ${video.readyState}), usando duración configurada`, 'warn');
                                            resolve(null);
                                        } else {
                                            debugLog(`Video ${slideIndex + 1} aún cargando (readyState: ${video.readyState}), usando duración configurada`, 'warn');
                                            resolve(null);
                                        }
                                    }
                                }, 6000);
                            });
                        };
                        
                        getVideoDuration().then((videoDuration) => {
                            if (videoDuration && videoDuration > 0) {
                                const videoDurationMs = videoDuration * 1000;
                                debugLog(`Programando siguiente slide en ${(videoDurationMs / 1000).toFixed(1)}s (duración del video)`, 'debug');
                                timeoutId = setTimeout(() => {
                                    nextSlide();
                                }, videoDurationMs);
                            } else {
                                // Usar duración configurada como fallback
                                const fallbackDuration = duration > 0 ? duration : 30000;
                                debugLog(`Programando siguiente slide en ${fallbackDuration / 1000}s (duración configurada)`, 'info');
                                timeoutId = setTimeout(() => {
                                    nextSlide();
                                }, fallbackDuration);
                            }
                        });
                        
                        return;
                    }
                }
                
                // Para imágenes o si no hay duración del video, usar la duración configurada
                if (duration > 0) {
                    debugLog(`Programando siguiente slide en ${duration / 1000}s (duración configurada)`, 'debug');
                    timeoutId = setTimeout(() => {
                        nextSlide();
                    }, duration);
                } else {
                    // Si no hay duración configurada, usar 30 segundos por defecto
                    debugLog(`Programando siguiente slide en 30s (default)`, 'debug');
                    timeoutId = setTimeout(() => {
                        nextSlide();
                    }, 30000);
                }
            }

            // Función para precargar todas las imágenes y videos
            async function preloadMedia() {
                const mediaElements = [];
                let loadedImages = 0;
                let loadedVideos = 0;
                let totalImages = 0;
                let totalVideos = 0;
                let totalSize = 0;
                let loadedSize = 0;
                
                // Obtener todos los elementos de media
                allSlides.forEach((slide, index) => {
                    const img = slide.querySelector('img');
                    const video = slide.querySelector('video');
                    
                    if (img) {
                        const size = parseInt(slide.getAttribute('data-size')) || 0;
                        totalSize += size;
                        totalImages++;
                        mediaElements.push({ element: img, size: size, type: 'image', slideIndex: index });
                    }
                    
                    if (video) {
                        const size = parseInt(slide.getAttribute('data-size')) || 0;
                        totalSize += size;
                        totalVideos++;
                        mediaElements.push({ element: video, size: size, type: 'video', slideIndex: index });
                    }
                });
                
                if (mediaElements.length === 0) {
                    return;
                }
                
                const progressBar = document.getElementById('progress-bar');
                const progressText = document.getElementById('progress-text');
                
                // Función para actualizar progreso con información detallada
                function updateProgress() {
                    const totalLoaded = loadedImages + loadedVideos;
                    const totalMedia = totalImages + totalVideos;
                    
                    const percent = totalSize > 0 
                        ? Math.min(100, Math.round((loadedSize / totalSize) * 100)) 
                        : Math.min(100, Math.round((totalLoaded / totalMedia) * 100));
                    
                    progressBar.style.width = percent + '%';
                    progressBar.textContent = percent + '%';
                    
                    // Mostrar información detallada: imágenes y videos por separado
                    let statusText = '';
                    
                    if (totalSize > 0) {
                        const loadedMB = (loadedSize / (1024 * 1024)).toFixed(1);
                        const totalMB = (totalSize / (1024 * 1024)).toFixed(1);
                        statusText = `${loadedMB} MB / ${totalMB} MB`;
                    }
                    
                    // Agregar contadores de imágenes y videos
                    const imageStatus = `Imágenes: ${loadedImages}/${totalImages}`;
                    const videoStatus = `Videos: ${loadedVideos}/${totalVideos}`;
                    
                    if (statusText) {
                        progressText.innerHTML = `${statusText}<br><small>${imageStatus} | ${videoStatus}</small>`;
                    } else {
                        progressText.innerHTML = `Cargando...<br><small>${imageStatus} | ${videoStatus}</small>`;
                    }
                }
                
                // Cargar imágenes primero (más rápido)
                const imagePromises = mediaElements
                    .filter(m => m.type === 'image')
                    .map(({ element, size, slideIndex }) => {
                        return new Promise((resolve) => {
                            // Resolver inmediatamente si ya está cargada
                            if (element.complete && element.naturalWidth > 0) {
                                loadedImages++;
                                loadedSize += size;
                                updateProgress();
                                debugLog(`Imagen ${slideIndex + 1} ya cargada`, 'debug');
                                // Usar setTimeout para evitar bloqueo
                                setTimeout(() => resolve(), 0);
                                return;
                            }
                            
                            // Si no está cargada, esperar eventos
                            const onLoad = () => {
                                loadedImages++;
                                loadedSize += size;
                                updateProgress();
                                debugLog(`Imagen ${slideIndex + 1} cargada`, 'debug');
                                resolve();
                            };
                            
                            const onError = () => {
                                debugLog(`Error al cargar imagen ${slideIndex + 1}`, 'error', { src: element.src });
                                loadedImages++;
                                loadedSize += size; // Contar como cargado para progreso
                                updateProgress();
                                resolve(); // Continuar aunque falle
                            };
                            
                            element.addEventListener('load', onLoad, { once: true });
                            element.addEventListener('error', onError, { once: true });
                            
                            // Timeout de seguridad para imágenes (10 segundos)
                            setTimeout(() => {
                                if (element.complete) {
                                    onLoad();
                                } else {
                                    debugLog(`Timeout cargando imagen ${slideIndex + 1}`, 'warn');
                                    onError();
                                }
                            }, 10000);
                        });
                    });
                
                // Cargar videos de forma secuencial en TVs para evitar saturar la conexión
                // En dispositivos normales, cargar en paralelo pero limitado
                const videoElements = mediaElements.filter(m => m.type === 'video');
                
                if (isTV) {
                    // En TVs: cargar videos uno por uno para evitar saturar conexión
                    debugLog(`Cargando ${videoElements.length} videos secuencialmente en TV...`, 'info');
                    for (const { element, size, slideIndex } of videoElements) {
                        try {
                            await loadVideoWithRetry(element, slideIndex);
                            loadedVideos++;
                            loadedSize += size;
                            updateProgress();
                            debugLog(`Video ${slideIndex + 1} precargado exitosamente`, 'info');
                        } catch (err) {
                            debugLog(`No se pudo precargar video ${slideIndex + 1}`, 'warn', err);
                            loadedVideos++;
                            updateProgress();
                        }
                    }
                } else {
                    // En dispositivos normales: cargar en paralelo pero limitado (máx 3 a la vez)
                    const maxConcurrent = 3;
                    const videoPromises = [];
                    
                    for (let i = 0; i < videoElements.length; i += maxConcurrent) {
                        const batch = videoElements.slice(i, i + maxConcurrent);
                        const batchPromises = batch.map(async ({ element, size, slideIndex }) => {
                            try {
                                await loadVideoWithRetry(element, slideIndex);
                                loadedVideos++;
                                loadedSize += size;
                                updateProgress();
                                debugLog(`Video ${slideIndex + 1} precargado exitosamente`, 'info');
                            } catch (err) {
                                debugLog(`No se pudo precargar video ${slideIndex + 1}`, 'warn', err);
                                loadedVideos++;
                                updateProgress();
                            }
                        });
                        
                        await Promise.all(batchPromises);
                    }
                }
                
                // Cargar imágenes en paralelo (los videos ya se cargaron arriba)
                try {
                    await Promise.race([
                        Promise.all(imagePromises),
                        new Promise((resolve) => {
                            setTimeout(() => {
                                debugLog(`Timeout cargando imágenes después de 60 segundos`, 'warn');
                                resolve();
                            }, 60000);
                        })
                    ]);
                } catch (err) {
                    debugLog(`Error en precarga de imágenes: ${err.message}`, 'error', err);
                    // Continuar aunque haya errores
                }
                
                const totalLoaded = loadedImages + loadedVideos;
                debugLog(`Precarga completada: ${totalLoaded}/${mediaElements.length} elementos (Imágenes: ${loadedImages}/${totalImages}, Videos: ${loadedVideos}/${totalVideos})`, 'info');
                
                // Pequeño delay para asegurar que todo esté listo
                await new Promise(resolve => setTimeout(resolve, 500));
            }

            // ========== MONITOREO DE SRC DE VIDEOS ==========
            let videoSrcMonitorInterval = null;
            
            function startVideoSrcMonitoring() {
                // Verificar cada 2 segundos que todos los videos tengan src válido
                videoSrcMonitorInterval = setInterval(() => {
                    allSlides.forEach((slide, index) => {
                        const video = slide.querySelector('video');
                        if (video) {
                            const currentSrc = video.src || video.getAttribute('src') || '';
                            const originalSrc = video.getAttribute('data-original-src') || '';
                            
                            // Si el src está vacío pero hay un originalSrc, restaurarlo inmediatamente
                            if ((!currentSrc || currentSrc === '') && originalSrc) {
                                debugLog(`Restaurando src vacío para video ${index + 1}`, 'warn');
                                video.src = originalSrc;
                                video.setAttribute('src', originalSrc);
                                
                                // Si el video estaba cargado, recargarlo
                                if (videoLoadStatus.has(`${index}-${originalSrc}`)) {
                                    const status = videoLoadStatus.get(`${index}-${originalSrc}`);
                                    if (status && status.loaded) {
                                        video.load();
                                    }
                                }
                            }
                        }
                    });
                }, 2000); // Verificar cada 2 segundos
                
                debugLog('Monitoreo de src de videos iniciado', 'info');
            }
            
            // Función de inicialización
            async function init() {
                try {
                    debugLog('Iniciando carrusel promocional', 'info', {
                        isTV: isTV,
                        online: navigator.onLine,
                        totalSlides: allSlides.length
                    });
                    
                    // Iniciar monitoreo de red
                    startNetworkMonitoring();
                    
                    // Iniciar monitoreo de src de videos
                    startVideoSrcMonitoring();
                    
                    // Verificar si hay slides
                    if (allSlides.length === 0) {
                        debugLog('No hay slides disponibles', 'error');
                        error.style.display = 'block';
                        loading.style.display = 'none';
                        return;
                    }
                    
                    // Filtrar slides según horarios
                    updateVisibleSlides();
                    
                    if (slides.length === 0) {
                        debugLog('No hay slides visibles según horarios', 'warn');
                        error.style.display = 'block';
                        loading.style.display = 'none';
                        return;
                    }
                    
                    debugLog(`Precargando ${slides.length} slides visibles`, 'info');
                    
                    // Precargar media
                    await preloadMedia();
                    
                    debugLog('Precarga completada, iniciando carrusel', 'info');
                    
                    // Mostrar primer slide
                    if (slides.length > 0) {
                        slides[0].classList.add('active');
                        
                        // Iniciar video si es el primer slide con carga mejorada
                        const firstVideo = slides[0].querySelector('video');
                        if (firstVideo) {
                            const slideIndex = allSlides.indexOf(slides[0]);
                            firstVideo.style.display = 'block';
                            
                            // Asegurar que el video esté cargado
                            const videoSrc = firstVideo.getAttribute('data-original-src') || firstVideo.src;
                            const videoKey = `${slideIndex}-${videoSrc}`;
                            const status = videoLoadStatus.get(videoKey);
                            
                            if (!status || !status.loaded) {
                                debugLog('Cargando primer video...', 'info');
                                try {
                                    await loadVideoWithRetry(firstVideo, slideIndex);
                                } catch (err) {
                                    debugLog('No se pudo cargar primer video', 'warn', err);
                                }
                            }
                            
                            firstVideo.currentTime = 0;
                            
                            // Usar la misma lógica mejorada de reproducción
                            const tryPlayFirstVideo = async (retries = 3) => {
                                for (let i = 0; i < retries; i++) {
                                    try {
                                        // Verificar que el video tenga un src válido
                                        const videoSrc = firstVideo.getAttribute('data-original-src') || firstVideo.src || '';
                                        if (!videoSrc || videoSrc === '') {
                                            debugLog(`Error: primer video no tiene src válido, estableciendo...`, 'error');
                                            const originalSrc = firstVideo.getAttribute('data-original-src');
                                            if (originalSrc) {
                                                firstVideo.src = originalSrc;
                                                firstVideo.setAttribute('src', originalSrc);
                                                firstVideo.load();
                                                await new Promise(resolve => setTimeout(resolve, 500));
                                            } else {
                                                debugLog(`Error: no hay src disponible para primer video`, 'error');
                                                break;
                                            }
                                        }
                                        
                                        // Simplificado: aceptar readyState >= 2
                                        const minReadyState = 2;
                                        
                                        if (firstVideo.readyState < minReadyState) {
                                            await new Promise((resolve) => {
                                                let resolved = false;
                                                
                                                const resolveOnce = () => {
                                                    if (resolved) return;
                                                    resolved = true;
                                                    cleanup();
                                                    resolve();
                                                };
                                                
                                                const cleanup = () => {
                                                    firstVideo.removeEventListener('canplay', onCanPlay);
                                                    firstVideo.removeEventListener('canplaythrough', onCanPlayThrough);
                                                    firstVideo.removeEventListener('loadeddata', onLoadedData);
                                                };
                                                
                                                const onCanPlay = () => {
                                                    debugLog(`Primer video: canplay (readyState: ${firstVideo.readyState})`, 'info');
                                                    resolveOnce();
                                                };
                                                
                                                const onCanPlayThrough = () => {
                                                    debugLog(`Primer video: canplaythrough (readyState: ${firstVideo.readyState})`, 'info');
                                                    resolveOnce();
                                                };
                                                
                                                const onLoadedData = () => {
                                                    if (firstVideo.readyState >= minReadyState) {
                                                        debugLog(`Primer video: loadeddata suficiente (readyState: ${firstVideo.readyState})`, 'info');
                                                        resolveOnce();
                                                    }
                                                };
                                                
                                                firstVideo.addEventListener('canplay', onCanPlay, { once: true });
                                                firstVideo.addEventListener('canplaythrough', onCanPlayThrough, { once: true });
                                                firstVideo.addEventListener('loadeddata', onLoadedData);
                                                
                                                setTimeout(() => {
                                                    if (!resolved) {
                                                        if (firstVideo.readyState >= 2) {
                                                            debugLog(`Primer video: timeout pero tiene readyState ${firstVideo.readyState}, continuando...`, 'warn');
                                                        }
                                                        resolveOnce();
                                                    }
                                                }, 5000);
                                                
                                                if (firstVideo.readyState >= minReadyState) {
                                                    resolveOnce();
                                                }
                                            });
                                        }
                                        
                                        // Verificar nuevamente que el src esté presente antes de reproducir
                                        if (!firstVideo.src || firstVideo.src === '') {
                                            debugLog(`Error: src vacío antes de reproducir primer video, reintentando...`, 'error');
                                            const originalSrc = firstVideo.getAttribute('data-original-src');
                                            if (originalSrc) {
                                                firstVideo.src = originalSrc;
                                                firstVideo.setAttribute('src', originalSrc);
                                                firstVideo.load();
                                                await new Promise(resolve => setTimeout(resolve, 1000));
                                            } else {
                                                throw new Error('Empty src attribute');
                                            }
                                        }
                                        
                                        // Reproducir de forma segura - aceptar readyState >= 2
                                        if (firstVideo.paused) {
                                            await new Promise(resolve => setTimeout(resolve, 100));
                                            
                                            if (firstVideo.readyState >= 2 && firstVideo.src) {
                                                const playPromise = firstVideo.play();
                                                if (playPromise !== undefined) {
                                                    await playPromise;
                                                }
                                            } else {
                                                throw new Error(`Primer video no está listo (readyState: ${firstVideo.readyState})`);
                                            }
                                        }
                                        debugLog('Primer video reproduciendo', 'info');
                                        return true;
                                    } catch (e) {
                                        const errorInfo = {
                                            message: e?.message || 'Error desconocido',
                                            name: e?.name || 'Error',
                                            code: firstVideo.error?.code || null,
                                            readyState: firstVideo.readyState,
                                            attempt: i + 1
                                        };
                                        
                                        debugLog(`Error al reproducir primer video (intento ${i + 1}/${retries})`, 'error', errorInfo);
                                        
                                        if (i < retries - 1) {
                                            await new Promise(resolve => setTimeout(resolve, 1000 * (i + 1)));
                                        } else {
                                            debugLog('Error persistente en primer video después de reintentos', 'error', errorInfo);
                                        }
                                    }
                                }
                                return false;
                            };
                            
                            tryPlayFirstVideo();
                        }
                        
                        // Programar siguiente slide
                        scheduleNextSlide();
                    }
                    
                    // Programar cambios de horario
                    scheduleTimeChanges();
                    
                    // Iniciar verificación de versión
                    await startVersionCheck();
                    
                    // Ocultar loading
                    loading.style.display = 'none';
                    carouselContainer.classList.remove('loading');
                    
                    debugLog('Carrusel inicializado correctamente', 'info');
                    
                } catch (err) {
                    debugLog('Error en inicialización', 'error', err);
                    error.style.display = 'block';
                    loading.style.display = 'none';
                }
            }

            // ========== VERIFICACIÓN DE VERSIÓN PARA RECARGA AUTOMÁTICA ==========
            async function fetchVersion() {
                try {
                    const response = await fetch('?action=get_version', { 
                        cache: 'no-store',
                        headers: {
                            'Cache-Control': 'no-cache, no-store, must-revalidate',
                            'Pragma': 'no-cache'
                        }
                    });
                    const data = await response.json();
                    if (data.success) {
                        return data.version;
                    }
                } catch (e) {
                    debugLog('Error al obtener versión', 'warn', e);
                }
                return null;
            }

            async function startVersionCheck() {
                // Obtener versión inicial
                currentVersion = await fetchVersion();
                if (currentVersion !== null) {
                    debugLog(`Versión inicial: ${currentVersion}`, 'info');
                } else {
                    debugLog('No se pudo obtener versión inicial, reintentando...', 'warn');
                    // Reintentar después de 2 segundos
                    setTimeout(() => startVersionCheck(), 2000);
                    return;
                }
                
                // Verificar versión cada 5 segundos
                versionCheckInterval = setInterval(async () => {
                    if (!isOnline) {
                        debugLog('Sin conexión, omitiendo verificación de versión', 'debug');
                        return;
                    }
                    
                    const newVersion = await fetchVersion();
                    if (newVersion !== null && newVersion !== currentVersion) {
                        debugLog(`Nueva versión detectada: ${newVersion} (anterior: ${currentVersion})`, 'info');
                        debugLog('Limpiando cache y recargando promocionales...', 'info');
                        
                        // Limpiar cache de videos e imágenes antes de recargar
                        try {
                            // Limpiar todos los videos
                            allSlides.forEach(slide => {
                                const video = slide.querySelector('video');
                                if (video) {
                                    video.pause();
                                    video.src = '';
                                    video.removeAttribute('src');
                                    video.load();
                                }
                                const img = slide.querySelector('img');
                                if (img) {
                                    img.src = '';
                                }
                            });
                            
                            // Limpiar cache del navegador si está disponible
                            if ('caches' in window) {
                                caches.keys().then(names => {
                                    names.forEach(name => {
                                        caches.delete(name);
                                    });
                                    debugLog('Cache del navegador limpiado', 'info');
                                });
                            }
                            
                            // Limpiar el mapa de estado de videos
                            videoLoadStatus.clear();
                            
                            debugLog('Cache limpiado, recargando página...', 'info');
                        } catch (e) {
                            debugLog(`Error al limpiar cache: ${e.message}`, 'warn');
                        }
                        
                        // Recargar la página con cache busting y timestamp
                        const timestamp = new Date().getTime();
                        window.location.href = window.location.href.split('?')[0] + '?v=' + timestamp + '&nocache=' + timestamp;
                    }
                }, 5000); // Cada 5 segundos
                
                debugLog('Verificación de versión iniciada (cada 5 segundos)', 'info');
            }

            // Limpiar recursos al salir (prevenir memory leaks)
            window.addEventListener('beforeunload', () => {
                debugLog('Limpiando recursos...', 'info');
                
                // Limpiar timeouts
                if (timeoutId) clearTimeout(timeoutId);
                scheduleTimeouts.forEach(timeout => clearTimeout(timeout));
                videoTimeouts.forEach(timeout => clearTimeout(timeout));
                if (networkCheckInterval) clearInterval(networkCheckInterval);
                if (versionCheckInterval) clearInterval(versionCheckInterval);
                if (videoSrcMonitorInterval) clearInterval(videoSrcMonitorInterval);
                
                // Pausar videos (no liberar src para mejor rendimiento)
                allSlides.forEach(slide => {
                    const video = slide.querySelector('video');
                    if (video) {
                        video.pause();
                        video.currentTime = 0;
                    }
                });
                
                // Limpiar mapas
                videoLoadStatus.clear();
                videoRetries.clear();
                videoTimeouts.clear();
            });

            // Iniciar cuando el DOM esté listo
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', init);
            } else {
                init();
            }
        })();

        // ========== REGISTRO DEL SERVICE WORKER ==========
        (function() {
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', () => {
                    navigator.serviceWorker.register('/sw.js')
                        .then((registration) => {
                            console.log('[SW] Service Worker registrado exitosamente:', registration.scope);
                            
                            // Verificar actualizaciones del Service Worker
                            registration.addEventListener('updatefound', () => {
                                const newWorker = registration.installing;
                                console.log('[SW] Nueva versión del Service Worker encontrada');
                                
                                newWorker.addEventListener('statechange', () => {
                                    if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                                        console.log('[SW] Nueva versión instalada, recargando...');
                                        window.location.reload();
                                    }
                                });
                            });
                        })
                        .catch((error) => {
                            console.error('[SW] Error al registrar Service Worker:', error);
                        });
                });
            } else {
                console.warn('[SW] Service Worker no soportado en este navegador');
            }
        })();
    </script>
</body>
</html>
