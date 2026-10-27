<?php

class PromocionalModel {
    private $pdo;

    public function __construct() {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        $this->pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    }

    public function getByEstado(string $estado = 'activa'): array {
        $sql = "SELECT * 
                FROM imagenes_promocionales 
                WHERE estado = :estado 
                ORDER BY orden_visualizacion ASC, fecha_subida DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['estado' => $estado]);
        return $stmt->fetchAll();
    }

    public function getAllGrouped(): array {
        return [
            'active'   => $this->getByEstado('activa'),
            'archived' => $this->getByEstado('archivada'),
        ];
    }

    public function findByNombre(string $nombreArchivo): ?array {
        $sql = "SELECT * FROM imagenes_promocionales WHERE nombre_archivo = :nombre LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['nombre' => $nombreArchivo]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function insertMedia(
        string $nombreArchivo,
        string $rutaArchivo,
        string $extension,
        int $tamanoBytes,
        string $estado = 'activa',
        ?int $orden = null,
        ?int $duracionMs = null,
        ?string $horaInicio = null,
        ?string $horaFin = null
    ): int {
        if ($orden === null) {
            $orden = $this->getNextOrden();
        }

        $sql = "INSERT INTO imagenes_promocionales 
                (nombre_archivo, ruta_archivo, extension, tamano_bytes, estado, orden_visualizacion, fecha_subida, duracion_ms, hora_inicio, hora_fin)
                VALUES 
                (:nombre, :ruta, :extension, :tamano, :estado, :orden, NOW(), :duracion_ms, :hora_inicio, :hora_fin)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'nombre'    => $nombreArchivo,
            'ruta'      => $rutaArchivo,
            'extension' => $extension,
            'tamano'    => $tamanoBytes,
            'estado'    => $estado,
            'orden'     => $orden,
            'duracion_ms' => $duracionMs,
            'hora_inicio' => $horaInicio,
            'hora_fin' => $horaFin,
        ]);

        return (int)$this->pdo->lastInsertId();
    }

    public function updateEstadoByNombre(string $nombreArchivo, string $estado): bool {
        $sql = "UPDATE imagenes_promocionales 
                SET estado = :estado 
                WHERE nombre_archivo = :nombre";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'estado' => $estado,
            'nombre' => $nombreArchivo,
        ]);
    }

    public function deleteByNombre(string $nombreArchivo): bool {
        $sql = "DELETE FROM imagenes_promocionales WHERE nombre_archivo = :nombre";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['nombre' => $nombreArchivo]);
    }

    public function updateOrden(string $nombreArchivo, int $nuevoOrden): bool {
        $sql = "UPDATE imagenes_promocionales 
                SET orden_visualizacion = :orden 
                WHERE nombre_archivo = :nombre";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'orden'  => $nuevoOrden,
            'nombre' => $nombreArchivo,
        ]);
    }

    public function updateDuracion(string $nombreArchivo, ?int $duracionMs): bool {
        $sql = "UPDATE imagenes_promocionales 
                SET duracion_ms = :duracion_ms 
                WHERE nombre_archivo = :nombre";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'duracion_ms' => $duracionMs,
            'nombre'      => $nombreArchivo,
        ]);
    }

    public function updateHorario(string $nombreArchivo, ?string $horaInicio, ?string $horaFin): bool {
        $sql = "UPDATE imagenes_promocionales 
                SET hora_inicio = :hora_inicio, hora_fin = :hora_fin 
                WHERE nombre_archivo = :nombre";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'hora_inicio' => $horaInicio,
            'hora_fin' => $horaFin,
            'nombre' => $nombreArchivo,
        ]);
    }

    public function getNextOrden(): int {
        $sql = "SELECT MAX(orden_visualizacion) AS max_orden FROM imagenes_promocionales";
        $stmt = $this->pdo->query($sql);
        $row = $stmt->fetch();
        $max = $row && $row['max_orden'] !== null ? (int)$row['max_orden'] : 0;
        return $max + 1;
    }

    public function getConfigVersion(): int {
        $sql = "SELECT version FROM promocional_config WHERE id = 1";
        $stmt = $this->pdo->query($sql);
        $row = $stmt->fetch();

        if (!$row) {
            $this->pdo->exec("INSERT INTO promocional_config (id, version) VALUES (1, 1)");
            return 1;
        }

        return (int)$row['version'];
    }

    public function bumpConfigVersion(): int {
        $sql = "INSERT INTO promocional_config (id, version, actualizado_en)
                VALUES (1, 1, NOW())
                ON DUPLICATE KEY UPDATE 
                    version = version + 1,
                    actualizado_en = NOW()";
        $this->pdo->exec($sql);
        return $this->getConfigVersion();
    }
}
