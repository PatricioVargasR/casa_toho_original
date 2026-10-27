<?php
require_once __DIR__ . '/../config/database.php';

class MeseroModel {
    private $db;

    public function __construct() {
        $this->db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /** Devuelve todos los meseros (activos e inactivos) */
    public function getTodos() {
        $stmt = $this->db->query("SELECT * FROM meseros ORDER BY activo DESC, nombre ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** Devuelve solo los meseros activos (para el formulario de encuesta) */
    public function getActivos() {
        $stmt = $this->db->query("SELECT * FROM meseros WHERE activo = 1 ORDER BY nombre ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** Obtiene un mesero por id */
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM meseros WHERE id = :id");
        $stmt->execute([':id' => (int)$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /** Crea un nuevo mesero */
    public function crear($nombre) {
        $stmt = $this->db->prepare("INSERT INTO meseros (nombre) VALUES (:nombre)");
        $stmt->execute([':nombre' => trim($nombre)]);
        return $this->db->lastInsertId();
    }

    /** Actualiza nombre y estado de un mesero */
    public function actualizar($id, $nombre, $activo) {
        $stmt = $this->db->prepare(
            "UPDATE meseros SET nombre = :nombre, activo = :activo WHERE id = :id"
        );
        $stmt->execute([
            ':nombre' => trim($nombre),
            ':activo' => $activo ? 1 : 0,
            ':id'     => (int)$id
        ]);
    }

    /** Elimina un mesero solo si no tiene encuestas asociadas */
    public function eliminar($id) {
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) FROM encuestas WHERE mesero_id = :id"
        );
        $stmt->execute([':id' => (int)$id]);
        $count = (int)$stmt->fetchColumn();

        if ($count > 0) {
            return false; // No se puede eliminar, tiene encuestas
        }

        $stmt = $this->db->prepare("DELETE FROM meseros WHERE id = :id");
        $stmt->execute([':id' => (int)$id]);
        return true;
    }

    /**
     * Estadísticas de encuestas agrupadas por mesero en un rango de fechas.
     * Devuelve: mesero, total, avg_general, avg_r1, avg_r2, avg_r3, avg_r4
     */
    public function getEstadisticasPorMesero($fechaInicio, $fechaFin) {
        $sql = "SELECT
                    m.nombre AS mesero,
                    COUNT(*) AS total,
                    ROUND(AVG((e.respuesta1 + e.respuesta2 + e.respuesta3 + e.respuesta4) / 4.0), 2) AS avg_general,
                    ROUND(AVG(e.respuesta1), 2) AS avg_r1,
                    ROUND(AVG(e.respuesta2), 2) AS avg_r2,
                    ROUND(AVG(e.respuesta3), 2) AS avg_r3,
                    ROUND(AVG(e.respuesta4), 2) AS avg_r4
                FROM encuestas e
                INNER JOIN meseros m ON m.id = e.mesero_id
                WHERE e.mesero_id IS NOT NULL
                  AND e.fecha BETWEEN :inicio AND :fin
                GROUP BY e.mesero_id, m.nombre
                ORDER BY avg_general DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':inicio' => $fechaInicio,
            ':fin'    => $fechaFin . ' 23:59:59'
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
