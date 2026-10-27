<?php
// app/controllers/CodigoRegaloController.php
require_once __DIR__ . '/../models/CodigoRegaloModel.php';

class CodigoRegaloController {
    private $model;

    public function __construct() {
        $this->model = new CodigoRegaloModel();
    }

    public function mostrarFormulario() {
        $codigo = $_GET['c'] ?? '';
        require_once __DIR__ . '/../views/codigo_regalo.php';
    }

    public function verificarCodigo() {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $codigo = $data['codigo'] ?? '';

        if (empty($codigo)) {
            echo json_encode(['success' => false, 'message' => 'Código vacío']);
            return;
        }

        $regalo = $this->model->verificarCodigo($codigo);

        if (!$regalo) {
            echo json_encode(['success' => false, 'message' => 'Código inválido']);
            return;
        }

        // Registrar que fue visualizado
        $this->model->registrarVisualizacion($codigo);

        echo json_encode([
            'success' => true,
            'regalo' => [
                'nombre' => $regalo['nombre_regalo'],
                'descripcion' => $regalo['descripcion'],
                'codigo' => $regalo['codigo'],
                'usos_realizados' => $regalo['usos_realizados'],
                'cantidad_total' => $regalo['cantidad_total']
            ]
        ]);
    }
}
?>