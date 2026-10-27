-- ============================================================
-- Migración: Tabla meseros + migración de datos existentes
-- ============================================================

-- 1. Crear tabla meseros
CREATE TABLE IF NOT EXISTS `meseros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Insertar meseros base
INSERT INTO `meseros` (`nombre`, `activo`) VALUES
('Mesero 1', 1),
('Mesero 2', 1),
('Mesero 3', 1),
('Mesero 4', 1),
('Mesero 5', 1);

-- 3. Agregar columna mesero_id en encuestas
ALTER TABLE `encuestas` 
ADD COLUMN `mesero_id` int(11) DEFAULT NULL AFTER `mesero`;

-- 4. Agregar clave foránea
ALTER TABLE `encuestas` 
ADD CONSTRAINT `fk_mesero` 
FOREIGN KEY (`mesero_id`) 
REFERENCES `meseros`(`id`) 
ON DELETE SET NULL;
