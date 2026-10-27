<?php
require_once __DIR__ . '/../models/EncuestaModel.php';
require_once __DIR__ . '/../models/MeseroModel.php';

class DashboardController {
    private $model;
    private $meseroModel;

    public function __construct() {
        $this->model = new EncuestaModel();
        $this->meseroModel = new MeseroModel();
    }

    public function mostrarDashboard() {
        $fechaInicio = $_GET['fecha_inicio'] ?? '2000-01-01';
        $fechaFin = $_GET['fecha_fin'] ?? date('Y-m-d');

        if (!$this->validarFecha($fechaInicio)) $fechaInicio = '2000-01-01';
        if (!$this->validarFecha($fechaFin)) $fechaFin = date('Y-m-d');

        $total = $this->model->getTotalEncuestas($fechaInicio, $fechaFin);
        $promedios = $this->model->getPromedios($fechaInicio, $fechaFin);
        $distribuciones = $this->model->getDistribuciones($fechaInicio, $fechaFin);
        $tendencia = $this->model->getTendenciaDiaria($fechaInicio, $fechaFin);

        // Comentarios que quieres mostrar en dashboard:
        $ultimosComentarios = $this->model->getUltimosComentarios(5, $fechaInicio, $fechaFin);
        $todosComentarios = $this->model->getTodosLosComentarios('DESC');
        $comentariosHoy = $this->model->getComentariosPorFecha(date('Y-m-d'), 'DESC');
        $comentariosRango = $this->model->getComentariosPorRangoFecha($fechaInicio, $fechaFin, 0, 0, 'DESC');
        $totalComentarios = $this->model->contarComentarios($fechaInicio, $fechaFin);

        $fechaUltimoRegistro = $this->model->getFechaUltimoRegistro($fechaInicio, $fechaFin);

        // Estadísticas por mesero
        $estadisticasMeseros = $this->meseroModel->getEstadisticasPorMesero($fechaInicio, $fechaFin);

        // Mesero filtrado (opcional)
        $meseroFiltro = $_GET['mesero'] ?? '';

        include __DIR__ . '/../views/encuesta/dashboard.php';
    }

    /**
     * Valida si una fecha tiene el formato correcto Y-m-d
     * @param string $fecha
     * @return bool
     */
    private function validarFecha($fecha) {
        if (empty($fecha)) {
            return false;
        }

        // Verificar formato Y-m-d usando DateTime
        $d = DateTime::createFromFormat('Y-m-d', $fecha);
        return $d && $d->format('Y-m-d') === $fecha;
    }
}