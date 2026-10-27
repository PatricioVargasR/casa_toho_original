// Service Worker para Cache Offline Persistente
// Versión: 2.0.0
// Optimizado para redes inestables y navegadores de TV

const CACHE_NAME = 'promocional-cache-v2';
const MEDIA_CACHE_NAME = 'promocional-media-cache-v2';
const MAX_CACHE_SIZE = 500 * 1024 * 1024; // 500MB máximo
const MAX_MEDIA_CACHE_SIZE = 2 * 1024 * 1024 * 1024; // 2GB para medios

// Lista de recursos críticos que siempre deben estar en cache
const CRITICAL_RESOURCES = [
    '/',
    '/promocional',
    '/app/css/styles.css'
];

// Estrategia: Cache-First para medios (ideal para redes malas)
// Network-First para HTML (siempre actualizado)

self.addEventListener('install', (event) => {
    console.log('[SW] Instalando Service Worker...');
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            console.log('[SW] Cache abierto');
            return cache.addAll(CRITICAL_RESOURCES).catch(err => {
                console.warn('[SW] Error al cachear recursos críticos:', err);
            });
        })
    );
    self.skipWaiting(); // Activar inmediatamente
});

self.addEventListener('activate', (event) => {
    console.log('[SW] Activando Service Worker...');
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((cacheName) => {
                    // Eliminar caches antiguos
                    if (cacheName !== CACHE_NAME && cacheName !== MEDIA_CACHE_NAME) {
                        console.log('[SW] Eliminando cache antiguo:', cacheName);
                        return caches.delete(cacheName);
                    }
                })
            );
        })
    );
    return self.clients.claim(); // Tomar control inmediatamente
});

// Función para obtener tamaño aproximado de un cache
async function getCacheSize(cacheName) {
    try {
        const cache = await caches.open(cacheName);
        const keys = await cache.keys();
        let totalSize = 0;
        
        for (const key of keys) {
            const response = await cache.match(key);
            if (response) {
                const blob = await response.blob();
                totalSize += blob.size;
            }
        }
        return totalSize;
    } catch (e) {
        console.warn('[SW] Error calculando tamaño de cache:', e);
        return 0;
    }
}

// Función para limpiar cache si excede el tamaño máximo
async function cleanCacheIfNeeded(cacheName, maxSize) {
    try {
        const currentSize = await getCacheSize(cacheName);
        if (currentSize <= maxSize) {
            return; // No necesita limpieza
        }
        
        console.log(`[SW] Limpiando cache ${cacheName}: ${(currentSize / 1024 / 1024).toFixed(2)}MB > ${(maxSize / 1024 / 1024).toFixed(2)}MB`);
        
        const cache = await caches.open(cacheName);
        const keys = await cache.keys();
        
        // Ordenar por fecha (más antiguos primero)
        const entries = [];
        for (const key of keys) {
            const response = await cache.match(key);
            if (response) {
                entries.push({
                    key,
                    date: response.headers.get('date') || new Date().toISOString()
                });
            }
        }
        
        entries.sort((a, b) => new Date(a.date) - new Date(b.date));
        
        // Eliminar entradas más antiguas hasta estar bajo el límite
        let deletedSize = 0;
        for (const entry of entries) {
            const response = await cache.match(entry.key);
            if (response) {
                const blob = await response.blob();
                deletedSize += blob.size;
                await cache.delete(entry.key);
                
                const newSize = currentSize - deletedSize;
                if (newSize <= maxSize * 0.9) { // Dejar 10% de margen
                    break;
                }
            }
        }
        
        console.log(`[SW] Cache limpiado: eliminados ${(deletedSize / 1024 / 1024).toFixed(2)}MB`);
    } catch (e) {
        console.error('[SW] Error limpiando cache:', e);
    }
}

// Función para validar integridad de un archivo
async function validateFileIntegrity(response) {
    try {
        const blob = await response.clone().blob();
        // Validación básica: verificar que el blob tenga tamaño > 0
        if (blob.size === 0) {
            return false;
        }
        
        // Para videos, verificar que tenga headers válidos
        const contentType = response.headers.get('content-type') || '';
        if (contentType.startsWith('video/')) {
            // Verificar que el tamaño sea razonable (mínimo 1KB)
            if (blob.size < 1024) {
                return false;
            }
        }
        
        return true;
    } catch (e) {
        console.warn('[SW] Error validando integridad:', e);
        return false;
    }
}

// Interceptar peticiones
self.addEventListener('fetch', (event) => {
    const url = new URL(event.request.url);
    
    // Ignorar peticiones de extensiones del navegador y otros esquemas no soportados
    if (url.protocol === 'chrome-extension:' || url.protocol === 'chrome:' || url.protocol === 'moz-extension:') {
        return;
    }
    
    // Solo cachear peticiones GET
    if (event.request.method !== 'GET') {
        return;
    }
    
    // Determinar si es un archivo de medios (imagen o video)
    const isMediaFile = /\.(jpg|jpeg|png|gif|webp|mp4|webm|ogg)$/i.test(url.pathname) ||
                       url.pathname.includes('/images/promocional/');
    
    // Ignorar peticiones de extensiones del navegador
    if (url.protocol === 'chrome-extension:' || url.protocol === 'chrome:') {
        return;
    }
    
    if (isMediaFile) {
        const hasRangeHeader = event.request.headers.get('range');
        const isVideo = /\.(mp4|webm|ogg)$/i.test(url.pathname);
        
        // Para videos con Range requests, dejar que pasen directamente sin cachear
        // Los videos usan Range requests para cargar por partes, y no podemos cachear respuestas parciales
        if (isVideo && hasRangeHeader) {
            event.respondWith(fetch(event.request));
            return;
        }
        
        // ESTRATEGIA CACHE-FIRST para medios (ideal para redes malas)
        event.respondWith(
            caches.open(MEDIA_CACHE_NAME).then(async (cache) => {
                // Primero intentar desde cache (solo si no es Range request)
                const cachedResponse = await cache.match(event.request);
                
                if (cachedResponse && !hasRangeHeader) {
                    console.log('[SW] Media desde cache:', url.pathname);
                    // Validar integridad del archivo cacheado
                    if (await validateFileIntegrity(cachedResponse)) {
                        return cachedResponse;
                    } else {
                        console.warn('[SW] Archivo cacheado corrupto, eliminando:', url.pathname);
                        await cache.delete(event.request);
                    }
                }
                
                // Si no está en cache o está corrupto, intentar desde red
                try {
                    const fetchOptions = {
                        cache: 'no-cache'
                    };
                    
                    // Para videos sin Range header, intentar obtener respuesta completa
                    // Si el navegador agrega Range header automáticamente, lo manejaremos después
                    const networkResponse = await fetch(event.request, fetchOptions);
                    
                    // NO intentar cachear respuestas parciales (206) - estas son para streaming
                    if (networkResponse.status === 206) {
                        console.log('[SW] Respuesta parcial (206) para:', url.pathname, '- no cacheando');
                        return networkResponse; // Devolver directamente sin cachear
                    }
                    
                    // Solo cachear respuestas completas (200)
                    if (networkResponse.ok && networkResponse.status === 200) {
                        // Validar integridad antes de guardar
                        if (await validateFileIntegrity(networkResponse)) {
                            // Para videos, crear una nueva request sin Range para cachear
                            // Esto asegura que el cache tenga el video completo
                            const requestToCache = hasRangeHeader 
                                ? new Request(event.request.url, { method: 'GET' })
                                : event.request;
                            
                            await cache.put(requestToCache, networkResponse.clone());
                            
                            // Limpiar cache si es necesario
                            await cleanCacheIfNeeded(MEDIA_CACHE_NAME, MAX_MEDIA_CACHE_SIZE);
                            
                            console.log('[SW] Media guardado en cache:', url.pathname);
                            return networkResponse;
                        } else {
                            console.warn('[SW] Archivo de red corrupto, no guardando:', url.pathname);
                            return networkResponse;
                        }
                    } else {
                        // Si no es 200, devolver sin cachear
                        return networkResponse;
                    }
                } catch (error) {
                    console.warn('[SW] Error de red, usando cache si existe:', error);
                    // Si hay error de red pero tenemos cache, usarlo
                    if (cachedResponse) {
                        return cachedResponse;
                    }
                    throw error;
                }
            })
        );
    } else {
        // ESTRATEGIA NETWORK-FIRST para HTML y otros recursos
        event.respondWith(
            fetch(event.request).then((response) => {
                // Si la respuesta es válida, guardar en cache
                if (response.ok) {
                    const responseClone = response.clone();
                    caches.open(CACHE_NAME).then((cache) => {
                        cache.put(event.request, responseClone);
                    });
                }
                return response;
            }).catch(() => {
                // Si falla la red, intentar desde cache
                return caches.match(event.request).then((cachedResponse) => {
                    if (cachedResponse) {
                        console.log('[SW] Recurso desde cache (offline):', url.pathname);
                        return cachedResponse;
                    }
                    // Si no hay cache, devolver error
                    return new Response('Recurso no disponible offline', {
                        status: 503,
                        statusText: 'Service Unavailable'
                    });
                });
            })
        );
    }
});

// Mensaje para limpiar cache manualmente
self.addEventListener('message', (event) => {
    if (event.data && event.data.type === 'CLEAR_CACHE') {
        event.waitUntil(
            caches.keys().then((cacheNames) => {
                return Promise.all(
                    cacheNames.map((cacheName) => {
                        console.log('[SW] Limpiando cache:', cacheName);
                        return caches.delete(cacheName);
                    })
                );
            }).then(() => {
                event.ports[0].postMessage({ success: true });
            })
        );
    }
    
    if (event.data && event.data.type === 'GET_CACHE_SIZE') {
        Promise.all([
            getCacheSize(CACHE_NAME),
            getCacheSize(MEDIA_CACHE_NAME)
        ]).then(([size1, size2]) => {
            event.ports[0].postMessage({
                cacheSize: size1,
                mediaCacheSize: size2,
                totalSize: size1 + size2
            });
        });
    }
});

console.log('[SW] Service Worker cargado y listo');
