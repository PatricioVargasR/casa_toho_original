<?php

require_once __DIR__ . '/../models/PromocionalModel.php';

class PromocionalController {
    public function promocional() {
        // Manejar acción de obtener versión
        if (isset($_GET['action']) && $_GET['action'] === 'get_version') {
            header('Content-Type: application/json');
            $model = new PromocionalModel();
            $version = $model->getConfigVersion();
            echo json_encode(['success' => true, 'version' => $version]);
            return;
        }
        
        // Obtener solo medios activos desde la base de datos
        $model = new PromocionalModel();
        $mediosActivos = $model->getByEstado('activa');

        // Esta variable estará disponible en la vista
        $promocionales = $mediosActivos;

        require __DIR__ . '/../../app/views/promocional.php';
    }
}
?>