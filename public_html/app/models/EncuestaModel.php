<?php
require_once __DIR__ . '/../config/database.php';

class EncuestaModel {
    private $db;

    public function __construct() {
        $this->db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // No configuramos zona horaria en MySQL porque no está disponible
        // Usaremos PHP para manejar las fechas
    }

    /**
     * Obtiene la fecha y hora actual de México CDMX
     * @return string Fecha en formato Y-m-d H:i:s
     */
    private function obtenerFechaMexico() {
        $timezone = new DateTimeZone('America/Mexico_City');
        $datetime = new DateTime('now', $timezone);
        return $datetime->format('Y-m-d H:i:s');
    }

    public function guardarEncuesta($respuestas, $comentarios, $mesero_id = null) {
        $fechaActual = $this->obtenerFechaMexico();

        $sql = "INSERT INTO encuestas
                (respuesta1, respuesta2, respuesta3, respuesta4, comentarios, mesero_id, fecha)
                VALUES (:r1, :r2, :r3, :r4, :comentarios, :mesero_id, :fecha)";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':r1' => $this->textoANumero($respuestas[0] ?? ''),
            ':r2' => $this->textoANumero($respuestas[1] ?? ''),
            ':r3' => $this->textoANumero($respuestas[2] ?? ''),
            ':r4' => $this->textoANumero($respuestas[3] ?? ''),
            ':comentarios' => $comentarios,
            ':mesero_id' => $mesero_id,
            ':fecha' => $fechaActual
        ]);
    }

    // Total encuestas en rango
    public function getTotalEncuestas($fechaInicio = null, $fechaFin = null) {
        $sql = "SELECT COUNT(*) as total FROM encuestas WHERE fecha BETWEEN :inicio AND :fin";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':inicio' => $fechaInicio,
            ':fin' => $fechaFin . ' 23:59:59'
        ]);
        return (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    /**
     * Convierte texto de respuesta a valor numérico para cálculos
     */
    private function textoANumero($texto) {
        switch($texto) {
            case 'Excelente': return 4;
            case 'Buena': return 3;
            case 'Regular': return 2;
            case 'Mala': return 1;
            default: return 0;
        }
    }

    private function numeroATexto($numero) {
        switch((int)$numero) {
            case 4: return 'Excelente';
            case 3: return 'Buena';
            case 2: return 'Regular';
            case 1: return 'Mala';
            default: return '';
        }
    }

    // Promedios en rango
    public function getPromedios($fechaInicio = null, $fechaFin = null) {
        $sql = "SELECT 
                respuesta1, respuesta2, respuesta3, respuesta4
            FROM encuestas
            WHERE fecha BETWEEN :inicio AND :fin";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':inicio' => $fechaInicio,
            ':fin' => $fechaFin . ' 23:59:59'
        ]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Calcular promedios manualmente
        $sumas = [0, 0, 0, 0];
        $contadores = [0, 0, 0, 0];
        
        foreach($rows as $row) {
            for($i = 1; $i <= 4; $i++) {
                $valor = $row['respuesta'.$i] ?? '';
                if (!empty($valor)) {
                    $sumas[$i-1] += (int)$valor;
                    $contadores[$i-1]++;
                }
            }
        }
        
        return [
            'r1' => $contadores[0] > 0 ? $sumas[0] / $contadores[0] : 0,
            'r2' => $contadores[1] > 0 ? $sumas[1] / $contadores[1] : 0,
            'r3' => $contadores[2] > 0 ? $sumas[2] / $contadores[2] : 0,
            'r4' => $contadores[3] > 0 ? $sumas[3] / $contadores[3] : 0
        ];
    }

    // Distribuciones en rango
    public function getDistribuciones($fechaInicio = null, $fechaFin = null) {
        $result = [];
        
        for ($i = 1; $i <= 4; $i++) {
            $sql = "SELECT respuesta{$i} as respuesta, COUNT(*) as total
                    FROM encuestas
                    WHERE fecha BETWEEN :inicio AND :fin
                    AND respuesta{$i} IS NOT NULL
                    AND respuesta{$i} != ''
                    GROUP BY respuesta{$i}";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':inicio' => $fechaInicio,
                ':fin' => $fechaFin . ' 23:59:59'
            ]);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $conteos = ['Excelente' => 0, 'Buena' => 0, 'Regular' => 0, 'Mala' => 0];
            foreach($rows as $row) {
                $numero = (int)$row['respuesta'];
                $respuestaTexto = $this->numeroATexto($numero);
                if (!empty($respuestaTexto)) {
                    $conteos[$respuestaTexto] = (int)$row['total'];
                }
            }
            $result["respuesta{$i}"] = $conteos;
        }
        return $result;
    }

    // Tendencia diaria promedio total
    public function getTendenciaDiaria($fechaInicio = null, $fechaFin = null) {
        $sql = "SELECT DATE(fecha) as dia, COUNT(*) as total_encuestas
                FROM encuestas
                WHERE fecha BETWEEN :inicio AND :fin
                GROUP BY dia
                ORDER BY dia ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':inicio' => $fechaInicio,
            ':fin' => $fechaFin . ' 23:59:59'
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Comentarios en rango
    public function getUltimosComentarios($limite = 5, $fechaInicio = null, $fechaFin = null) {
        $sql = "SELECT e.comentarios, e.fecha, m.nombre AS mesero
                FROM encuestas e
                LEFT JOIN meseros m ON m.id = e.mesero_id
                WHERE e.comentarios <> '' AND e.fecha BETWEEN :inicio AND :fin
                ORDER BY e.fecha DESC LIMIT :limite";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':inicio', $fechaInicio);
        $stmt->bindValue(':fin', $fechaFin . ' 23:59:59');
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene todos los comentarios de la base de datos
     * @param string $orden 'ASC' para más antiguos primero, 'DESC' para más recientes primero
     * @return array Array de comentarios con fecha
     */
    public function getTodosLosComentarios($orden = 'DESC') {
        $sql = "SELECT e.comentarios, e.fecha, m.nombre AS mesero
                FROM encuestas e
                LEFT JOIN meseros m ON m.id = e.mesero_id
                WHERE e.comentarios <> '' AND e.comentarios IS NOT NULL
                ORDER BY e.fecha " . ($orden === 'ASC' ? 'ASC' : 'DESC');
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene comentarios filtrados por fecha específica
     * @param string $fecha Fecha en formato Y-m-d (ej: '2024-01-15')
     * @param string $orden 'ASC' para más antiguos primero, 'DESC' para más recientes primero
     * @return array Array de comentarios de la fecha especificada
     */
    public function getComentariosPorFecha($fecha, $orden = 'DESC') {
        $sql = "SELECT e.comentarios, e.fecha, m.nombre AS mesero
                FROM encuestas e
                LEFT JOIN meseros m ON m.id = e.mesero_id
                WHERE e.comentarios <> ''
                AND e.comentarios IS NOT NULL
                AND DATE(e.fecha) = :fecha
                ORDER BY e.fecha " . ($orden === 'ASC' ? 'ASC' : 'DESC');
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':fecha', $fecha);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene comentarios en un rango de fechas con paginación opcional
     * @param string $fechaInicio Fecha inicio en formato Y-m-d
     * @param string $fechaFin Fecha fin en formato Y-m-d
     * @param int $limite Número de comentarios a mostrar (0 = sin límite)
     * @param int $offset Número de comentarios a omitir (para paginación)
     * @param string $orden 'ASC' o 'DESC'
     * @return array Array de comentarios en el rango especificado
     */
    public function getComentariosPorRangoFecha($fechaInicio, $fechaFin, $limite = 0, $offset = 0, $orden = 'DESC') {
        $sql = "SELECT e.comentarios, e.fecha, m.nombre AS mesero
                FROM encuestas e
                LEFT JOIN meseros m ON m.id = e.mesero_id
                WHERE e.comentarios <> ''
                AND e.comentarios IS NOT NULL
                AND e.fecha BETWEEN :inicio AND :fin
                ORDER BY e.fecha " . ($orden === 'ASC' ? 'ASC' : 'DESC');
        
        if ($limite > 0) {
            $sql .= " LIMIT :limite";
            if ($offset > 0) {
                $sql .= " OFFSET :offset";
            }
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':inicio', $fechaInicio);
        $stmt->bindValue(':fin', $fechaFin . ' 23:59:59');
        
        if ($limite > 0) {
            $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
            if ($offset > 0) {
                $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            }
        }
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Cuenta el total de comentarios para paginación
     * @param string $fechaInicio Fecha inicio (opcional)
     * @param string $fechaFin Fecha fin (opcional)
     * @return int Número total de comentarios
     */
    public function contarComentarios($fechaInicio = null, $fechaFin = null) {
        if ($fechaInicio && $fechaFin) {
            $sql = "SELECT COUNT(*) as total 
                    FROM encuestas 
                    WHERE comentarios <> '' 
                    AND comentarios IS NOT NULL
                    AND fecha BETWEEN :inicio AND :fin";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':inicio' => $fechaInicio,
                ':fin' => $fechaFin . ' 23:59:59'
            ]);
        } else {
            $sql = "SELECT COUNT(*) as total 
                    FROM encuestas 
                    WHERE comentarios <> '' AND comentarios IS NOT NULL";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
        }
        
        return (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
    
    public function getFechaUltimoRegistro($fechaInicio = null, $fechaFin = null) {
        $sql = "SELECT MAX(fecha) as ultima_fecha 
                FROM encuestas 
                WHERE fecha BETWEEN :inicio AND :fin";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':inicio' => $fechaInicio,
            ':fin' => $fechaFin . ' 23:59:59'
        ]);
        
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado['ultima_fecha'];
    }
}