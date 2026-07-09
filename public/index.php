<?php
/**
 * Front Controller / Router
 * Punto de entrada único de la aplicación.
 * Todas las peticiones pasan por aquí y se enrutan según ?route=
 */

require_once __DIR__ . '/../app/controllers/libroController.php';
require_once __DIR__ . '/../app/controllers/prestamosController.php';
require_once __DIR__ . '/../app/controllers/EditorialController.php';
require_once __DIR__ . '/../app/controllers/AdquisicionController.php';
require_once __DIR__ . '/../app/controllers/EstudianteController.php';
require_once __DIR__ . '/../app/controllers/SancionController.php';
require_once __DIR__ . '/../app/controllers/EmpleadoController.php';
require_once __DIR__ . '/../app/controllers/TurnoController.php';
require_once __DIR__ . '/../app/controllers/SalaController.php';
require_once __DIR__ . '/../app/controllers/ReservaController.php';

$route = $_GET['route'] ?? 'inicio';
$id    = isset($_GET['id']) ? (int) $_GET['id'] : null;

$libroController = new LibroController();
$prestamosController = new PrestamoController();
$editorialesController = new EditorialController();
$adquisicionesController = new AdquisicionController();
$estudiantesController = new EstudianteController();
$sancionesController = new SancionController();
$empleadosController = new EmpleadoController();
$turnosController = new TurnoController();
$salasController = new SalaController();
$reservasController = new ReservaController();


switch ($route) {
    // ---------- Página de inicio ----------
    case 'inicio':
        require __DIR__ . '/../app/views/inicio.php';
        break;

    // ---------- Rutas de Libros ----------
    case 'libros':
        $libroController->index();
        break;

    case 'libros/create':
        $libroController->crear();
        break;

    case 'libros/store':
        $libroController->guardar();
        break;

    case 'libros/edit':
        $libroController->editar($id);
        break;

    case 'libros/update':
        $libroController->actualizar($id);
        break;

    case 'libros/delete':
        $libroController->eliminar($id);
        break;

    case 'libros/buscar':
        $libroController->buscar();
        break;

    // ---------- Rutas de Préstamos ----------
    case 'prestamos':
        $prestamosController->index();
        break;

    case 'prestamos/create':
        $prestamosController->crear();
        break;

    case 'prestamos/store':
        $prestamosController->guardar();
        break;

    case 'prestamos/edit':
        $prestamosController->editar($id);
        break;

    case 'prestamos/update':
        $prestamosController->actualizar($id);
        break;

    case 'prestamos/delete':
        $prestamosController->eliminar($id);
        break;

    case 'prestamos/devolver':
        $prestamosController->devolver($id);
        break;

    // ---------- Rutas de Editoriales ----------
    case 'editoriales':
        $editorialesController->index();
        break;

    case 'editoriales/create':
        $editorialesController->crear();
        break;

    case 'editoriales/store':
        $editorialesController->guardar();
        break;

    case 'editoriales/edit':
        $editorialesController->editar($id);
        break;

    case 'editoriales/update':
        $editorialesController->actualizar($id);
        break;

    case 'editoriales/delete':
        $editorialesController->eliminar($id);
        break;

    case 'editoriales/buscar':
        $editorialesController->buscar();
        break;
    // ---------- Rutas de Adquisiciones ----------
    case 'adquisiciones':
        $adquisicionesController->index();
        break;

    case 'adquisiciones/create':
        $adquisicionesController->crear();
        break;

    case 'adquisiciones/store':
        $adquisicionesController->guardar();
        break;

    case 'adquisiciones/edit':
        $adquisicionesController->editar($id);
        break;

    case 'adquisiciones/update':
        $adquisicionesController->actualizar($id);
        break;

    case 'adquisiciones/delete':
        $adquisicionesController->eliminar($id);
        break;
    // ---------- Rutas de Estudiantes ----------
    case 'estudiantes':
        $estudiantesController->index();
        break;

    case 'estudiantes/create':
        $estudiantesController->crear();
        break;

    case 'estudiantes/store':
        $estudiantesController->guardar();
        break;

    case 'estudiantes/edit':
        $estudiantesController->editar($id);
        break;

    case 'estudiantes/update':
        $estudiantesController->actualizar($id);
        break;

    case 'estudiantes/delete':
        $estudiantesController->eliminar($id);
        break;

    case 'estudiantes/buscar':
        $estudiantesController->buscar();
        break;
    // ---------- Rutas de Sanciones ----------
    case 'sanciones':
        $sancionesController->index();
        break;

    case 'sanciones/create':
        $sancionesController->crear();
        break;

    case 'sanciones/store':
        $sancionesController->guardar();
        break;

    case 'sanciones/edit':
        $sancionesController->editar($id);
        break;

    case 'sanciones/update':
        $sancionesController->actualizar($id);
        break;

    case 'sanciones/delete':
        $sancionesController->eliminar($id);
        break;
    // ---------- Rutas de Empleados ----------
    case 'empleados':
        $empleadosController->index();
        break;

    case 'empleados/create':
        $empleadosController->crear();
        break;

    case 'empleados/store':
        $empleadosController->guardar();
        break;

    case 'empleados/edit':
        $empleadosController->editar($id);
        break;

    case 'empleados/update':
        $empleadosController->actualizar($id);
        break;

    case 'empleados/delete':
        $empleadosController->eliminar($id);
        break;

    case 'empleados/buscar':
        $empleadosController->buscar();
        break;
    // ---------- Rutas de Turnos ----------
    case 'turnos':
        $turnosController->index();
        break;

    case 'turnos/create':
        $turnosController->crear();
        break;

    case 'turnos/store':
        $turnosController->guardar();
        break;

    case 'turnos/edit':
        $turnosController->editar($id);
        break;

    case 'turnos/update':
        $turnosController->actualizar($id);
        break;

    case 'turnos/delete':
        $turnosController->eliminar($id);
        break;
    // ---------- Rutas de Salas ----------
    case 'salas':
        $salasController->index();
        break;

    case 'salas/create':
        $salasController->crear();
        break;

    case 'salas/store':
        $salasController->guardar();
        break;

    case 'salas/edit':
        $salasController->editar($id);
        break;

    case 'salas/update':
        $salasController->actualizar($id);
        break;

    case 'salas/delete':
        $salasController->eliminar($id);
        break;

    case 'salas/buscar':
        $salasController->buscar();
        break;
    // ---------- Rutas de Reservas ----------
    case 'reservas':
        $reservasController->index();
        break;

    case 'reservas/create':
        $reservasController->crear();
        break;

    case 'reservas/store':
        $reservasController->guardar();
        break;

    case 'reservas/edit':
        $reservasController->editar($id);
        break;

    case 'reservas/update':
        $reservasController->actualizar($id);
        break;

    case 'reservas/delete':
        $reservasController->eliminar($id);
        break;

    // ---------- Ruta no encontrada ----------
    default:
        http_response_code(404);
        echo '<h1>404 - Página no encontrada</h1><a href="index.php">Volver al inicio</a>';
        break;
}
