<?php
// app/controllers/CodigoRegaloAdminController.php
require_once __DIR__ . '/../models/CodigoRegaloModel.php';

class CodigoRegaloAdminController {
    private $model;

    public function __construct() {
        $this->model = new CodigoRegaloModel();
    }

    public function mostrarAdmin() {
        // Verificar sesión de PIN
        session_start();
        if (!isset($_SESSION['admin_autenticado']) || $_SESSION['admin_autenticado'] !== true) {
            require_once __DIR__ . '/../views/codigo_regalo_login.php';
            return;
        }
        
        require_once __DIR__ . '/../views/codigo_regalo_admin.php';
    }

    public function verificarPin() {
        header('Content-Type: application/json');
        session_start();
        
        $data = json_decode(file_get_contents('php://input'), true);
        $pin = $data['pin'] ?? '';
        
        if ($this->model->verificarPin($pin)) {
            $_SESSION['admin_autenticado'] = true;
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'PIN incorrecto']);
        }
    }

    public function cerrarSesion() {
        session_start();
        session_destroy();
        header('Location: /codigo-regalo-admin');
        exit;
    }

    public function getCodigos() {
        header('Content-Type: application/json');
        session_start();
        
        if (!isset($_SESSION['admin_autenticado'])) {
            echo json_encode(['success' => false, 'message' => 'No autenticado']);
            return;
        }
        
        $filtro = $_GET['filtro'] ?? 'todos';
        $busqueda = $_GET['busqueda'] ?? '';
        $codigos = $this->model->obtenerTodosCodigos($filtro, $busqueda);
        $stats = $this->model->getEstadisticas();
        echo json_encode([
            'success' => true,
            'codigos' => $codigos,
            'estadisticas' => $stats
        ]);
    }

    public function crearCodigo() {
        header('Content-Type: application/json');
        session_start();
        
        if (!isset($_SESSION['admin_autenticado'])) {
            echo json_encode(['success' => false, 'message' => 'No autenticado']);
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        
        $resultado = $this->model->crearCodigo(
            $data['codigo'],
            $data['nombre_regalo'],
            $data['descripcion'] ?? '',
            $data['cantidad'] ?? 1
        );

        if ($resultado) {
            // Generar URL con el código
            $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'];
            $url = $baseUrl . '/codigo-regalo?c=' . strtoupper($data['codigo']);
            
            echo json_encode([
                'success' => true, 
                'message' => 'Código creado exitosamente',
                'url' => $url
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error: El código ya existe']);
        }
    }

    public function sumarUso() {
        header('Content-Type: application/json');
        session_start();
        
        if (!isset($_SESSION['admin_autenticado'])) {
            echo json_encode(['success' => false]);
            return;
        }
        
        $data = json_decode(file_get_contents('php://input'), true);
        $resultado = $this->model->sumarUso($data['id']);
        
        echo json_encode(['success' => $resultado]);
    }

    public function restarUso() {
        header('Content-Type: application/json');
        session_start();
        
        if (!isset($_SESSION['admin_autenticado'])) {
            echo json_encode(['success' => false]);
            return;
        }
        
        $data = json_decode(file_get_contents('php://input'), true);
        $resultado = $this->model->restarUso($data['id']);
        
        echo json_encode(['success' => $resultado]);
    }

    public function desactivarCodigo() {
        header('Content-Type: application/json');
        session_start();
        
        if (!isset($_SESSION['admin_autenticado'])) {
            echo json_encode(['success' => false]);
            return;
        }
        
        $data = json_decode(file_get_contents('php://input'), true);
        $resultado = $this->model->desactivarCodigo($data['id']);
        
        echo json_encode(['success' => $resultado]);
    }

    public function activarCodigo() {
        header('Content-Type: application/json');
        session_start();
        
        if (!isset($_SESSION['admin_autenticado'])) {
            echo json_encode(['success' => false]);
            return;
        }
        
        $data = json_decode(file_get_contents('php://input'), true);
        $resultado = $this->model->activarCodigo($data['id']);
        
        echo json_encode(['success' => $resultado]);
    }

    public function eliminarCodigo() {
        header('Content-Type: application/json');
        session_start();
        
        if (!isset($_SESSION['admin_autenticado'])) {
            echo json_encode(['success' => false]);
            return;
        }
        
        $data = json_decode(file_get_contents('php://input'), true);
        $resultado = $this->model->eliminarCodigo($data['id']);
        
        echo json_encode(['success' => $resultado]);
    }
}
?>