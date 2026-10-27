-- Agregar campos de horario a la tabla imagenes_promocionales
ALTER TABLE imagenes_promocionales 
ADD COLUMN hora_inicio TIME DEFAULT NULL AFTER duracion_ms,
ADD COLUMN hora_fin TIME DEFAULT NULL AFTER hora_inicio;
