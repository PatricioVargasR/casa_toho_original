<?php
// app/models/CodigoRegaloModel.php
require_once __DIR__ . '/../config/database.php';

class CodigoRegaloModel {
    private $db;
    private const PIN_ADMIN = '010925'; // Cambia este PIN

    public function __construct() {
        $this->db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    private function obtenerFechaMexico() {
        $timezone = new DateTimeZone('America/Mexico_City');
        $datetime = new DateTime('now', $timezone);
        return $datetime->format('Y-m-d H:i:s');
    }

    public function verificarPin($pin) {
        return $pin === self::PIN_ADMIN;
    }

    public function verificarCodigo($codigo) {
        $sql = "SELECT * FROM codigos_regalo WHERE codigo = :codigo AND activo = 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':codigo' => strtoupper($codigo)]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function registrarVisualizacion($codigo) {
        $fechaVisualizacion = $this->obtenerFechaMexico();
        $sql = "UPDATE codigos_regalo 
                SET fecha_ultima_visualizacion = :fecha 
                WHERE codigo = :codigo";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':codigo' => strtoupper($codigo),
            ':fecha' => $fechaVisualizacion
        ]);
    }

    public function sumarUso($id) {
        $fechaUso = $this->obtenerFechaMexico();
        
        // Obtener datos actuales
        $sqlGet = "SELECT usos_realizados, cantidad_total FROM codigos_regalo WHERE id = :id";
        $stmtGet = $this->db->prepare($sqlGet);
        $stmtGet->execute([':id' => $id]);
        $datos = $stmtGet->fetch(PDO::FETCH_ASSOC);
        
        if (!$datos) return false;
        
        $usosRealizados = $datos['usos_realizados'] + 1;
        $cantidadTotal = $datos['cantidad_total'];
        
        // Si ya usó todos, marcar como completado
        $usado = ($usosRealizados >= $cantidadTotal) ? 1 : 0;
        
        $sql = "UPDATE codigos_regalo 
                SET usos_realizados = :usos, 
                    usado = :usado,
                    fecha_ultimo_uso = :fecha_uso 
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':usos' => $usosRealizados,
            ':usado' => $usado,
            ':fecha_uso' => $fechaUso
        ]);
    }

    public function restarUso($id) {
        // Obtener datos actuales
        $sqlGet = "SELECT usos_realizados FROM codigos_regalo WHERE id = :id";
        $stmtGet = $this->db->prepare($sqlGet);
        $stmtGet->execute([':id' => $id]);
        $datos = $stmtGet->fetch(PDO::FETCH_ASSOC);
        
        if (!$datos || $datos['usos_realizados'] <= 0) return false;
        
        $usosRealizados = $datos['usos_realizados'] - 1;
        
        $sql = "UPDATE codigos_regalo 
                SET usos_realizados = :usos, 
                    usado = 0
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':usos' => $usosRealizados
        ]);
    }

    public function crearCodigo($codigo, $nombreRegalo, $descripcion, $cantidad = 1) {
        $fechaCreacion = $this->obtenerFechaMexico();
        $sql = "INSERT INTO codigos_regalo 
                (codigo, nombre_regalo, descripcion, cantidad_total, usos_realizados, fecha_creacion) 
                VALUES (:codigo, :nombre, :descripcion, :cantidad, 0, :fecha)";
        $stmt = $this->db->prepare($sql);
        try {
            return $stmt->execute([
                ':codigo' => strtoupper($codigo),
                ':nombre' => $nombreRegalo,
                ':descripcion' => $descripcion,
                ':cantidad' => $cantidad,
                ':fecha' => $fechaCreacion
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function obtenerTodosCodigos($filtro = 'todos', $busqueda = '') {
        $sql = "SELECT * FROM codigos_regalo WHERE 1=1";
        
        if (!empty($busqueda)) {
            $sql .= " AND (codigo LIKE :busqueda OR nombre_regalo LIKE :busqueda)";
        }
        
        if ($filtro === 'completados') {
            $sql .= " AND usado = 1";
        } elseif ($filtro === 'disponibles') {
            $sql .= " AND usado = 0 AND activo = 1";
        } elseif ($filtro === 'inactivos') {
            $sql .= " AND activo = 0";
        }
        
        $sql .= " ORDER BY fecha_creacion DESC";
        
        $stmt = $this->db->prepare($sql);
        
        if (!empty($busqueda)) {
            $stmt->bindValue(':busqueda', '%' . $busqueda . '%');
        }
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function desactivarCodigo($id) {
        $sql = "UPDATE codigos_regalo SET activo = 0 WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public function activarCodigo($id) {
        $sql = "UPDATE codigos_regalo SET activo = 1 WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public function eliminarCodigo($id) {
        $sql = "DELETE FROM codigos_regalo WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public function getEstadisticas() {
        $stats = [];
        
        // Total códigos activos
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM codigos_regalo WHERE activo = 1");
        $stats['total'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Códigos completados
        $stmt = $this->db->query("SELECT COUNT(*) as usado FROM codigos_regalo WHERE usado = 1");
        $stats['completados'] = $stmt->fetch(PDO::FETCH_ASSOC)['usado'];
        
        // Códigos disponibles
        $stmt = $this->db->query("SELECT COUNT(*) as disponible FROM codigos_regalo WHERE usado = 0 AND activo = 1");
        $stats['disponibles'] = $stmt->fetch(PDO::FETCH_ASSOC)['disponible'];
        
        // Total usos pendientes
        $stmt = $this->db->query("SELECT SUM(cantidad_total - usos_realizados) as pendientes FROM codigos_regalo WHERE usado = 0 AND activo = 1");
        $stats['usos_pendientes'] = $stmt->fetch(PDO::FETCH_ASSOC)['pendientes'] ?? 0;
        
        return $stats;
    }
}
?>