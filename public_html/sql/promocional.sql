-- Crear tabla para gestionar las imágenes promocionales
CREATE TABLE IF NOT EXISTS imagenes_promocionales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_archivo VARCHAR(255) NOT NULL,
    ruta_archivo VARCHAR(500) NOT NULL,
    extension VARCHAR(10) NOT NULL,
    tamano_bytes INT NOT NULL,
    estado ENUM('activa', 'archivada') DEFAULT 'activa',
    orden_visualizacion INT DEFAULT 0,
    fecha_subida DATETIME NOT NULL,
    fecha_modificacion DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    duracion_ms INT DEFAULT NULL,
    UNIQUE KEY unique_nombre (nombre_archivo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Índices para mejor rendimiento
CREATE INDEX idx_estado ON imagenes_promocionales(estado);
CREATE INDEX idx_orden ON imagenes_promocionales(orden_visualizacion);

-- Configuración global para sincronizar recargas de pantallas
CREATE TABLE IF NOT EXISTS promocional_config (
    id INT PRIMARY KEY DEFAULT 1,
    version INT NOT NULL DEFAULT 1,
    actualizado_en DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;