<?php
require_once __DIR__ . '/../models/sala.php';

/**
 * Controlador de Salas
 * Usa los métodos estáticos de la clase `sala` (mysqli) para el CRUD.
 */
class SalaController
{
    /** GET /salas -> listado */
    public function index(): void
    {
        $salas = sala::obtenerTodos();
        require __DIR__ . '/../views/salas/index.php';
    }

    /** GET /salas/create -> formulario de creación */
    public function crear(): void
    {
        $errores = [];
        $datos = [];
        require __DIR__ . '/../views/salas/create.php';
    }

    /** POST /salas/store -> procesa creación */
    public function guardar(): void
    {
        $datos = $this->obtenerDatosFormulario();
        $errores = $this->validar($datos);

        if (!empty($errores)) {
            require __DIR__ . '/../views/salas/create.php';
            return;
        }

        sala::crear($datos['nombre'], $datos['capacidad'], $datos['ubicacion'], $datos['estado']);

        header('Location: index.php?route=salas&mensaje=creado');
        exit;
    }

    /** GET /salas/edit&id= -> formulario de edición */
    public function editar(int $id): void
    {
        $datos = $this->buscarPorId($id);
        if (!$datos) {
            header('Location: index.php?route=salas&error=no_encontrado');
            exit;
        }
        $errores = [];
        require __DIR__ . '/../views/salas/edit.php';
    }

    /** POST /salas/update&id= -> procesa actualización */
    public function actualizar(int $id): void
    {
        $datos = $this->obtenerDatosFormulario();
        $errores = $this->validar($datos, $id);

        if (!empty($errores)) {
            $datos['id'] = $id;
            require __DIR__ . '/../views/salas/edit.php';
            return;
        }

        sala::actualizar(
            $id,
            $datos['nombre'], $datos['capacidad'], $datos['ubicacion'], $datos['estado']
        );

        header('Location: index.php?route=salas&mensaje=actualizado');
        exit;
    }

    /** GET /salas/delete&id= -> elimina un registro */
    public function eliminar(int $id): void
    {
        sala::eliminar($id);
        header('Location: index.php?route=salas&mensaje=eliminado');
        exit;
    }

    /** GET /salas/buscar -> búsqueda simple usando sala::busqueda() */
    public function buscar(): void
    {
        $id = $_GET['id'] ?? 0;
        $nombre = $_GET['nombre'] ?? ''; $ubicacion = $_GET['ubicacion'] ?? '';

        $salas = (empty($id) && $nombre === '' && $ubicacion === '')
            ? sala::obtenerTodos()
            : sala::busqueda($id, $nombre, $ubicacion);

        require __DIR__ . '/../views/salas/index.php';
    }

    /** Busca un registro por su ID reutilizando sala::busqueda() */
    private function buscarPorId(int $id): ?array
    {
        $resultados = sala::busqueda($id, '', '');
        foreach ($resultados as $fila) {
            if ((int) $fila['id'] === $id) {
                return $fila;
            }
        }
        return null;
    }

    /** Recolecta y sanitiza los datos enviados por el formulario */
    private function obtenerDatosFormulario(): array
    {
        return [
            'nombre' => trim(filter_input(INPUT_POST, 'nombre', FILTER_UNSAFE_RAW) ?? ''),
            'capacidad' => trim(filter_input(INPUT_POST, 'capacidad', FILTER_UNSAFE_RAW) ?? ''),
            'ubicacion' => trim(filter_input(INPUT_POST, 'ubicacion', FILTER_UNSAFE_RAW) ?? ''),
            'estado' => trim(filter_input(INPUT_POST, 'estado', FILTER_UNSAFE_RAW) ?? '')
        ];
    }

    /** Validaciones de backend (nunca confiar solo en el frontend) */
    private function validar(array $datos, ?int $idActual = null): array
    {
        $errores = [];
        if ($datos['capacidad'] === '' || !is_numeric($datos['capacidad']) || (float) $datos['capacidad'] < 0) {
            $errores['capacidad'] = 'Ingrese un valor numérico válido.';
        }
        if ($datos['ubicacion'] === '') {
            $errores['ubicacion'] = 'Ubicación es obligatorio.';
        }
        if (!in_array($datos['estado'], ['disponible', 'mantenimiento'], true)) {
            $errores['estado'] = 'Debe seleccionar una opción válida.';
        }

        if ($datos['nombre'] === '') {
            $errores['nombre'] = 'Nombre de la sala es obligatorio.';
        } else {
            foreach (sala::obtenerTodos() as $existente) {
                $mismoValor = $existente['nombre'] === $datos['nombre'];
                $esOtroRegistro = $idActual === null || (int) $existente['id'] !== $idActual;
                if ($mismoValor && $esOtroRegistro) {
                    $errores['nombre'] = 'Ya existe una sala registrada con ese nombre.';
                    break;
                }
            }
        }
        return $errores;
    }
}
