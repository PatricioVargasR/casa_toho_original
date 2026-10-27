<?php
require_once __DIR__ . '/../models/EncuestaModel.php';
require_once __DIR__ . '/../models/MeseroModel.php';

class EncuestaController {
    private $model;
    private $meseroModel;

    public function __construct() {
        $this->model = new EncuestaModel();
        $this->meseroModel = new MeseroModel();
    }

    public function mostrarFormulario() {
        $meseros = $this->meseroModel->getActivos();
        include __DIR__ . '/../views/encuesta/formulario.php';
    }

    public function guardarRespuesta() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $respuestas = [];
            // Solo procesamos 4 respuestas ahora
            for ($i = 1; $i <= 4; $i++) {
                $valor = $_POST['respuesta'.$i] ?? '';
                // Validar que sea una opción válida
                $opcionesValidas = ['Excelente', 'Buena', 'Regular', 'Mala'];
                if (in_array($valor, $opcionesValidas)) {
                    $respuestas[] = $valor;
                } else {
                    $respuestas[] = '';
                }
            }
            $comentarios = $_POST['comentarios'] ?? '';
            $mesero_id = isset($_POST['mesero_id']) && $_POST['mesero_id'] !== '' ? (int)$_POST['mesero_id'] : null;
            $this->model->guardarEncuesta($respuestas, $comentarios, $mesero_id);
            echo "¡Gracias por tu opinión!<br><a href='/encuesta'>Volver</a>";
        } else {
            header("Location: /encuesta");
            exit;
        }
    }
}
