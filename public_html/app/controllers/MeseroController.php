<?php
require_once __DIR__ . '/../models/MeseroModel.php';

class MeseroController {
    private $model;

    public function __construct() {
        $this->model = new MeseroModel();
    }

    /** GET /meseros-admin — Lista todos los meseros */
    public function listar() {
        $meseros = $this->model->getTodos();
        include __DIR__ . '/../views/meseros/lista.php';
    }

    /** GET /meseros-admin/crear | POST /meseros-admin/crear */
    public function crear() {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            if ($nombre === '') {
                $error = 'El nombre no puede estar vacío.';
            } else {
                $this->model->crear($nombre);
                header('Location: /meseros-admin');
                exit;
            }
        }
        $mesero = null; // nuevo
        include __DIR__ . '/../views/meseros/form.php';
    }

    /** GET /meseros-admin/editar?id=X | POST /meseros-admin/editar?id=X */
    public function editar() {
        $id = (int)($_GET['id'] ?? 0);
        $mesero = $this->model->getById($id);

        if (!$mesero) {
            header('Location: /meseros-admin');
            exit;
        }

        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            $activo = isset($_POST['activo']) ? 1 : 0;
            if ($nombre === '') {
                $error = 'El nombre no puede estar vacío.';
            } else {
                $this->model->actualizar($id, $nombre, $activo);
                header('Location: /meseros-admin');
                exit;
            }
        }

        include __DIR__ . '/../views/meseros/form.php';
    }

    /** POST /meseros-admin/eliminar */
    public function eliminar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)($_POST['id'] ?? 0);
            $eliminado = $this->model->eliminar($id);
            if (!$eliminado) {
                // Tiene encuestas, solo desactivar
                $mesero = $this->model->getById($id);
                if ($mesero) {
                    $this->model->actualizar($id, $mesero['nombre'], 0);
                }
            }
        }
        header('Location: /meseros-admin');
        exit;
    }
}
