<?php
// index.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// DEBUG: Descomenta para ver qué URI recibes
// echo "URI recibida: " . $uri . "<br><hr>";

require_once __DIR__ . '/app/config/database.php';
$db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

switch ($uri) {
    case '/':
        require_once __DIR__ . '/app/controllers/HomeController.php';
        $controller = new HomeController();
        $controller->home();
        break;
    
//    case '/menu':
//        require_once __DIR__ . '/app/controllers/MenuController.php';
//        $controller = new MenuController();
//        $controller->menu();
//        break;

    case '/encuesta':
        require_once __DIR__ . '/app/controllers/EncuestaController.php';
        $controller = new EncuestaController();
        $controller->mostrarFormulario();
        break;

    case '/guardar-respuesta':
        require_once __DIR__ . '/app/controllers/EncuestaController.php';
        $controller = new EncuestaController();
        $controller->guardarRespuesta();
        break;

    case '/dashboard':
        require_once __DIR__ . '/app/controllers/DashboardController.php';
        $dashboard = new DashboardController();
        $dashboard->mostrarDashboard();
        break;

//         case '/menu':
//         require_once __DIR__ . '/app/controllers/MenuController.php';
//         $controller = new MenuController();
//         $controller->menu();
//         break;

        case '/promocional':
        require_once __DIR__ . '/app/controllers/PromocionalController.php';
        $controller = new PromocionalController();
        $controller->promocional();
        break;

    case '/sw.js':
        // Servir el Service Worker con headers correctos
        header('Content-Type: application/javascript');
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Pragma: no-cache');
        header('Expires: 0');
        readfile(__DIR__ . '/sw.js');
        exit;
        break;

        case '/promocional-admin':
        require_once __DIR__ . '/app/controllers/PromocionalAdminController.php';
        $controller = new PromocionalAdminController();
        $controller->promocionalAdmin();
        break;

        case '/reservas':
        require_once __DIR__ . '/app/controllers/ReservasController.php';
        $controller = new ReservasController();
        $controller->reservas();
        break;

        case '/reservas-admin':
        require_once __DIR__ . '/app/controllers/ReservasAdminController.php';
        $controller = new ReservasAdminController();
        $controller->reservasAdmin();
        break;


    case '/codigo-regalo':
        require_once __DIR__ . '/app/controllers/CodigoRegaloController.php';
        $controller = new CodigoRegaloController();
        $controller->mostrarFormulario();
        break;

    case '/verificar-codigo':
        require_once __DIR__ . '/app/controllers/CodigoRegaloController.php';
        $controller = new CodigoRegaloController();
        $controller->verificarCodigo();
        break;

    case '/marcar-usado':
        require_once __DIR__ . '/app/controllers/CodigoRegaloController.php';
        $controller = new CodigoRegaloController();
        $controller->marcarUsado();
        break;

    case '/codigo-regalo-admin':
        require_once __DIR__ . '/app/controllers/CodigoRegaloAdminController.php';
        $controller = new CodigoRegaloAdminController();
        $controller->mostrarAdmin();
        break;

    case '/admin/codigos/get':
        require_once __DIR__ . '/app/controllers/CodigoRegaloAdminController.php';
        $controller = new CodigoRegaloAdminController();
        $controller->getCodigos();
        break;

    case '/admin/codigos/crear':
        require_once __DIR__ . '/app/controllers/CodigoRegaloAdminController.php';
        $controller = new CodigoRegaloAdminController();
        $controller->crearCodigo();
        break;

    case '/admin/codigos/desactivar':
        require_once __DIR__ . '/app/controllers/CodigoRegaloAdminController.php';
        $controller = new CodigoRegaloAdminController();
        $controller->desactivarCodigo();
        break;

    case '/admin/codigos/activar':
        require_once __DIR__ . '/app/controllers/CodigoRegaloAdminController.php';
        $controller = new CodigoRegaloAdminController();
        $controller->activarCodigo();
        break;

    case '/admin/codigos/eliminar':
        require_once __DIR__ . '/app/controllers/CodigoRegaloAdminController.php';
        $controller = new CodigoRegaloAdminController();
        $controller->eliminarCodigo();
        break;
    case '/admin/verificar-pin':
        require_once __DIR__ . '/app/controllers/CodigoRegaloAdminController.php';
        $controller = new CodigoRegaloAdminController();
        $controller->verificarPin();
        break;

    case '/admin/cerrar-sesion':
        require_once __DIR__ . '/app/controllers/CodigoRegaloAdminController.php';
        $controller = new CodigoRegaloAdminController();
        $controller->cerrarSesion();
        break;

    case '/admin/codigos/sumar-uso':
        require_once __DIR__ . '/app/controllers/CodigoRegaloAdminController.php';
        $controller = new CodigoRegaloAdminController();
        $controller->sumarUso();
        break;

    case '/admin/codigos/restar-uso':
        require_once __DIR__ . '/app/controllers/CodigoRegaloAdminController.php';
        $controller = new CodigoRegaloAdminController();
        $controller->restarUso();
        break;

    // ---- Gestión de Meseros ----
    case '/meseros-admin':
        require_once __DIR__ . '/app/controllers/MeseroController.php';
        $controller = new MeseroController();
        $controller->listar();
        break;

    case '/meseros-admin/crear':
        require_once __DIR__ . '/app/controllers/MeseroController.php';
        $controller = new MeseroController();
        $controller->crear();
        break;

    case '/meseros-admin/editar':
        require_once __DIR__ . '/app/controllers/MeseroController.php';
        $controller = new MeseroController();
        $controller->editar();
        break;

    case '/meseros-admin/eliminar':
        require_once __DIR__ . '/app/controllers/MeseroController.php';
        $controller = new MeseroController();
        $controller->eliminar();
        break;

    default:
        require_once __DIR__ . '/app/controllers/ErrorController.php';
        $errorController = new ErrorController();   
        $errorController->show404();
        break;
}
// Agregar después de las rutas existentes en tu index.php

?>