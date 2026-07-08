<?php
/**
 * Front Controller / Router
 * Punto de entrada único de la aplicación.
 * Todas las peticiones pasan por aquí y se enrutan según ?route=
 */

require_once __DIR__ . '/../app/controllers/libroController.php';
require_once __DIR__ . '/../app/controllers/prestamosController.php';

$route = $_GET['route'] ?? 'inicio';
$id    = isset($_GET['id']) ? (int) $_GET['id'] : null;

$libroController = new LibroController();
$prestamosController = new PrestamoController();


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
        
    case 'libros':
        $libroController->index();
        break;

    case 'libros/buscar':
        $libroController->buscar();
        break;

    case 'libros/create':
        $libroController->crear();
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

    // ---------- Ruta no encontrada ----------
    default:
        http_response_code(404);
        echo '<h1>404 - Página no encontrada</h1><a href="index.php">Volver al inicio</a>';
        break;
}