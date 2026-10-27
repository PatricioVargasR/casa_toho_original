
-- 3. Crear la tabla de reservaciones
CREATE TABLE IF NOT EXISTS reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    date DATETIME NOT NULL,
    phone VARCHAR(20) NOT NULL,
    area_id VARCHAR(10) NOT NULL,
    area_name VARCHAR(50) NOT NULL,
    area_image VARCHAR(255) NOT NULL,
    people INT NOT NULL,
    status ENUM('pendiente', 'confirmada', 'cumplida') DEFAULT 'pendiente',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_phone (phone),
    INDEX idx_date (date),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Insertar datos de prueba (opcional)
INSERT INTO reservations (name, date, phone, area_id, area_name, area_image, people, status) VALUES
('Juan Pérez', '2025-08-25 19:00:00', '5551234567', 'A001', 'Área VIP', 'assets/images/vip.jpg', 4, 'pendiente'),
('María González', '2025-08-26 20:00:00', '5559876543', 'A002', 'Terraza', 'assets/images/terraza.jpg', 2, 'confirmada'),
('Carlos López', '2025-08-24 18:30:00', '5555555555', 'A003', 'Salón Principal', 'assets/images/salon.jpg', 6, 'cumplida');

-- ============================================
-- VERIFICAR LA INSTALACIÓN
-- ============================================

-- Mostrar todas las reservas
SELECT * FROM reservations ORDER BY created_at DESC;

-- Mostrar estadísticas
SELECT 
    COUNT(*) as total_reservas,
    COUNT(CASE WHEN status = 'pendiente' THEN 1 END) as pendientes,
    COUNT(CASE WHEN status = 'confirmada' THEN 1 END) as confirmadas,
    COUNT(CASE WHEN status = 'cumplida' THEN 1 END) as cumplidas
FROM reservations;