<?php

require_once __DIR__ . '/../models/PromocionalModel.php';

class PromocionalAdminController {
    private $promocionalPath = __DIR__ . '/../../public/images/promocional/';
    private $archivedPath = __DIR__ . '/../../public/images/promocional/off/';

    // Permitimos imágenes y videos
    private $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'mp4', 'webm', 'ogg'];

    public function __construct() {
        // Crear carpeta off si no existe
        if (!is_dir($this->archivedPath)) {
            mkdir($this->archivedPath, 0755, true);
        }
    }

    public function promocionalAdmin() {
        // Si hay una acción AJAX, procesarla
        if (isset($_GET['action'])) {
            $this->handleAjaxRequest();
            return;
        }

        // Mostrar la vista
        require_once __DIR__ . '/../../app/views/promocional_admin.php';
    }

    private function handleAjaxRequest() {
        // Evitar warnings de "headers already sent" si algún archivo envió salida antes
        if (!headers_sent()) {
            header('Content-Type: application/json');
            header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
            header('Pragma: no-cache');
            header('Expires: 0');
        }

        $action = $_GET['action'];
        
        try {
            switch ($action) {
                case 'get_images':
                    echo json_encode($this->getImages());
                    break;

                case 'get_version':
                    echo json_encode($this->getVersion());
                    break;
                    
                case 'archive_image':
                    $input = json_decode(file_get_contents('php://input'), true);
                    echo json_encode($this->archiveImage($input['filename']));
                    break;
                    
                case 'activate_image':
                    $input = json_decode(file_get_contents('php://input'), true);
                    echo json_encode($this->activateImage($input['filename']));
                    break;
                    
                case 'delete_image':
                    $input = json_decode(file_get_contents('php://input'), true);
                    echo json_encode($this->deleteImage($input['filename'], $input['type']));
                    break;
                    
                case 'upload_image':
                    echo json_encode($this->uploadImage());
                    break;

                case 'reorder_image':
                    $input = json_decode(file_get_contents('php://input'), true);
                    echo json_encode($this->reorderImage($input['filename'], $input['direction'] ?? 'up'));
                    break;

                case 'reorder_image_absolute':
                    $input = json_decode(file_get_contents('php://input'), true);
                    echo json_encode($this->reorderImageAbsolute($input['filename'], $input['position'] ?? 'last'));
                    break;

                case 'bump_version':
                    echo json_encode($this->bumpVersion());
                    break;

                case 'update_media':
                    $input = json_decode(file_get_contents('php://input'), true);
                    $durationSec = isset($input['duration_seconds']) ? (int)$input['duration_seconds'] : null;
                    $horaInicio = isset($input['hora_inicio']) && $input['hora_inicio'] !== '' ? $input['hora_inicio'] : null;
                    $horaFin = isset($input['hora_fin']) && $input['hora_fin'] !== '' ? $input['hora_fin'] : null;
                    echo json_encode($this->updateMediaSettings($input['filename'], $durationSec, $horaInicio, $horaFin));
                    break;
                    
                default:
                    echo json_encode(['success' => false, 'message' => 'Acción no válida']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    private function getImages() {
        $model = new PromocionalModel();
        $grouped = $model->getAllGrouped();

        // La vista/JS espera name/path/size/modified
        $mapFn = function (array $rows, string $estado) {
            return array_map(function ($row) use ($estado) {
                return [
                    'name'        => $row['nombre_archivo'],
                    'path'        => $row['ruta_archivo'],
                    'size'        => (int)$row['tamano_bytes'],
                    'modified'    => strtotime($row['fecha_modificacion'] ?? $row['fecha_subida']),
                    'estado'      => $estado,
                    'extension'   => $row['extension'],
                    'duration_ms' => isset($row['duracion_ms']) ? (int)$row['duracion_ms'] : 0,
                    'hora_inicio' => $row['hora_inicio'] ?? null,
                    'hora_fin'    => $row['hora_fin'] ?? null,
                ];
            }, $rows);
        };

        return [
            'active'   => $mapFn($grouped['active'] ?? [], 'activa'),
            'archived' => $mapFn($grouped['archived'] ?? [], 'archivada'),
        ];
    }

    private function getVersion() {
        $model = new PromocionalModel();
        $version = $model->getConfigVersion();
        return ['success' => true, 'version' => $version];
    }

    private function bumpVersion() {
        $model = new PromocionalModel();
        $version = $model->bumpConfigVersion();
        return ['success' => true, 'version' => $version];
    }

    private function updateMediaSettings(string $filename, ?int $durationSec, ?string $horaInicio = null, ?string $horaFin = null) {
        $model = new PromocionalModel();
        $media = $model->findByNombre($filename);

        if (!$media) {
            return ['success' => false, 'message' => 'El registro no existe en BD'];
        }

        $duracionMs = null;
        if ($durationSec !== null && $durationSec > 0) {
            $duracionMs = $durationSec * 1000;
        }

        $ok1 = $model->updateDuracion($filename, $duracionMs);
        $ok2 = $model->updateHorario($filename, $horaInicio, $horaFin);

        if ($ok1 && $ok2) {
            return ['success' => true, 'message' => 'Configuración actualizada correctamente'];
        }

        return ['success' => false, 'message' => 'No se pudo actualizar la configuración'];
    }

    private function reorderImage(string $filename, string $direction) {
        $model = new PromocionalModel();
        $media = $model->findByNombre($filename);

        if (!$media) {
            return ['success' => false, 'message' => 'El registro no existe en BD'];
        }

        $estado = $media['estado']; // 'activa' o 'archivada'

        // Obtenemos todos los elementos de ese estado, ordenados
        $items = $model->getByEstado($estado);

        // Encontrar índice actual
        $index = null;
        foreach ($items as $i => $item) {
            if ($item['nombre_archivo'] === $filename) {
                $index = $i;
                break;
            }
        }

        if ($index === null) {
            return ['success' => false, 'message' => 'No se pudo encontrar el elemento en la lista'];
        }

        // Determinar nuevo índice
        if ($direction === 'up' && $index > 0) {
            $swapIndex = $index - 1;
        } elseif ($direction === 'down' && $index < count($items) - 1) {
            $swapIndex = $index + 1;
        } else {
            return ['success' => false, 'message' => 'No se puede mover más en esa dirección'];
        }

        $current = $items[$index];
        $other   = $items[$swapIndex];

        // Intercambiar orden_visualizacion
        $ordenActual = (int)$current['orden_visualizacion'];
        $ordenOtro   = (int)$other['orden_visualizacion'];

        $ok1 = $model->updateOrden($current['nombre_archivo'], $ordenOtro);
        $ok2 = $model->updateOrden($other['nombre_archivo'], $ordenActual);

        if ($ok1 && $ok2) {
            return ['success' => true, 'message' => 'Orden actualizado correctamente'];
        }

        return ['success' => false, 'message' => 'No se pudo actualizar el orden'];
    }

    private function reorderImageAbsolute(string $filename, string $position) {
        $model = new PromocionalModel();
        $media = $model->findByNombre($filename);

        if (!$media) {
            return ['success' => false, 'message' => 'El registro no existe en BD'];
        }

        $estado = $media['estado'];
        $items = $model->getByEstado($estado);

        // Reordenar la lista completa moviendo el elemento al inicio o final
        $newOrder = [];
        $movingItem = null;

        foreach ($items as $item) {
            if ($item['nombre_archivo'] === $filename) {
                $movingItem = $item;
            } else {
                $newOrder[] = $item;
            }
        }

        if ($movingItem === null) {
            return ['success' => false, 'message' => 'No se pudo encontrar el elemento en la lista'];
        }

        if ($position === 'first') {
            array_unshift($newOrder, $movingItem);
        } else { // 'last' por defecto
            $newOrder[] = $movingItem;
        }

        // Reasignar orden_visualizacion secuencialmente
        $ok = true;
        $orden = 1;
        foreach ($newOrder as $item) {
            $ok = $ok && $model->updateOrden($item['nombre_archivo'], $orden);
            $orden++;
        }

        if ($ok) {
            return ['success' => true, 'message' => 'Orden actualizado correctamente'];
        }

        return ['success' => false, 'message' => 'No se pudo actualizar el orden'];
    }

    private function archiveImage($filename) {
        $model = new PromocionalModel();
        $media = $model->findByNombre($filename);

        if (!$media) {
            return ['success' => false, 'message' => 'El registro no existe en BD'];
        }

        $sourcePath = $this->promocionalPath . $filename;
        $destinationPath = $this->archivedPath . $filename;
        
        if (!file_exists($sourcePath)) {
            return ['success' => false, 'message' => 'El archivo físico no existe'];
        }
        
        // Si ya hay un archivo viejo con el mismo nombre en archivados, lo reemplazamos
        if (file_exists($destinationPath)) {
            @unlink($destinationPath);
        }

        if (rename($sourcePath, $destinationPath)) {
            $model->updateEstadoByNombre($filename, 'archivada');
            return ['success' => true, 'message' => 'Elemento archivado correctamente'];
        } else {
            return ['success' => false, 'message' => 'Error al mover el archivo'];
        }
    }

    private function activateImage($filename) {
        $model = new PromocionalModel();
        $media = $model->findByNombre($filename);

        if (!$media) {
            return ['success' => false, 'message' => 'El registro no existe en BD'];
        }

        $sourcePath = $this->archivedPath . $filename;
        $destinationPath = $this->promocionalPath . $filename;
        
        if (!file_exists($sourcePath)) {
            return ['success' => false, 'message' => 'El archivo físico no existe'];
        }
        
        // Si ya hay un archivo viejo con el mismo nombre en activos, lo reemplazamos
        if (file_exists($destinationPath)) {
            @unlink($destinationPath);
        }

        if (rename($sourcePath, $destinationPath)) {
            $model->updateEstadoByNombre($filename, 'activa');
            return ['success' => true, 'message' => 'Elemento activado correctamente'];
        } else {
            return ['success' => false, 'message' => 'Error al mover el archivo'];
        }
    }

    private function deleteImage($filename, $type) {
        $model = new PromocionalModel();
        $media = $model->findByNombre($filename);

        if (!$media) {
            return ['success' => false, 'message' => 'El registro no existe en BD'];
        }

        $filePath = $type === 'active' 
            ? $this->promocionalPath . $filename
            : $this->archivedPath . $filename;
        
        if (!file_exists($filePath)) {
            // Aun así borramos de BD
            $model->deleteByNombre($filename);
            return ['success' => true, 'message' => 'Registro eliminado, archivo físico no encontrado'];
        }
        
        if (unlink($filePath)) {
            $model->deleteByNombre($filename);
            return ['success' => true, 'message' => 'Elemento eliminado correctamente'];
        } else {
            return ['success' => false, 'message' => 'Error al eliminar el archivo'];
        }
    }

    private function uploadImage() {
        if (!isset($_FILES['imagen'])) {
            return ['success' => false, 'message' => 'No se recibió ningún archivo'];            
        }

        $file = $_FILES['imagen'];

        if ($file['error'] !== UPLOAD_ERR_OK) {
            // Mensajes más claros según el código de error
            $errorMessages = [
                UPLOAD_ERR_INI_SIZE   => 'El archivo excede el tamaño máximo permitido por el servidor (upload_max_filesize)',
                UPLOAD_ERR_FORM_SIZE  => 'El archivo excede el tamaño máximo permitido por el formulario (MAX_FILE_SIZE)',
                UPLOAD_ERR_PARTIAL    => 'El archivo se subió solo parcialmente',
                UPLOAD_ERR_NO_FILE    => 'No se subió ningún archivo',
                UPLOAD_ERR_NO_TMP_DIR => 'Falta la carpeta temporal en el servidor',
                UPLOAD_ERR_CANT_WRITE => 'No se pudo escribir el archivo en el disco',
                UPLOAD_ERR_EXTENSION  => 'Una extensión de PHP detuvo la subida del archivo',
            ];

            $msg = $errorMessages[$file['error']] ?? 'Error desconocido al subir el archivo (código ' . $file['error'] . ')';
            return ['success' => false, 'message' => $msg];
        }
        
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        
        if (!in_array($extension, $this->allowedExtensions)) {
            return ['success' => false, 'message' => 'Formato de archivo no permitido'];
        }

        $model = new PromocionalModel();
        
        // Usar el nombre original del archivo (sanitizado)
        $originalName = pathinfo($file['name'], PATHINFO_FILENAME);
        $originalName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $originalName); // Sanitizar nombre
        $newFilename = $originalName . '.' . $extension;
        
        // Si ya existe un archivo con ese nombre, añadir un sufijo numérico
        $counter = 1;
        while ($model->findByNombre($newFilename) !== null) {
            $newFilename = $originalName . '_' . $counter . '.' . $extension;
            $counter++;
        }

        // Obtener el siguiente orden para la visualización
        $nextNumber = $model->getNextOrden();

        $destinationPath = $this->promocionalPath . $newFilename;

        if (!is_dir($this->promocionalPath)) {
            mkdir($this->promocionalPath, 0755, true);
        }
        
        if (!move_uploaded_file($file['tmp_name'], $destinationPath)) {
            return ['success' => false, 'message' => 'Error al guardar el archivo físico'];
        }

        // Ruta relativa que se usará en la vista (coincide con lo que espera el front)
        $relativePath = './../../public/images/promocional/' . $newFilename;

        // Duración opcional proporcionada por el usuario (en segundos)
        $duracionSeg = isset($_POST['duracion']) ? (int)$_POST['duracion'] : 0;
        $duracionMs = $duracionSeg > 0 ? $duracionSeg * 1000 : null;

        // Horarios opcionales
        $horaInicio = isset($_POST['hora_inicio']) && $_POST['hora_inicio'] !== '' ? $_POST['hora_inicio'] : null;
        $horaFin = isset($_POST['hora_fin']) && $_POST['hora_fin'] !== '' ? $_POST['hora_fin'] : null;

        // Guardar en BD
        $model->insertMedia(
            $newFilename,
            $relativePath,
            $extension,
            (int)$file['size'],
            'activa',
            $nextNumber,
            $duracionMs,
            $horaInicio,
            $horaFin
        );

        return ['success' => true, 'message' => 'Archivo subido correctamente como ' . $newFilename];
    }
}
?>