<?php
require_once __DIR__ . '/../models/editorial.php';

/**
 * Controlador de Editoriales
 * Usa los métodos estáticos de la clase `editorial` (mysqli) para el CRUD.
 */
class EditorialController
{
    /** GET /editoriales -> listado */
    public function index(): void
    {
        $editoriales = editorial::obtenerTodos();
        require __DIR__ . '/../views/editoriales/index.php';
    }

    /** GET /editoriales/create -> formulario de creación */
    public function crear(): void
    {
        $errores = [];
        $datos = [];
        require __DIR__ . '/../views/editoriales/create.php';
    }

    /** POST /editoriales/store -> procesa creación */
    public function guardar(): void
    {
        $datos = $this->obtenerDatosFormulario();
        $errores = $this->validar($datos);

        if (!empty($errores)) {
            require __DIR__ . '/../views/editoriales/create.php';
            return;
        }

        editorial::crear($datos['nombre'], $datos['pais'], $datos['telefono'], $datos['email']);

        header('Location: index.php?route=editoriales&mensaje=creado');
        exit;
    }

    /** GET /editoriales/edit&id= -> formulario de edición */
    public function editar(int $id): void
    {
        $datos = $this->buscarPorId($id);
        if (!$datos) {
            header('Location: index.php?route=editoriales&error=no_encontrado');
            exit;
        }
        $errores = [];
        require __DIR__ . '/../views/editoriales/edit.php';
    }

    /** POST /editoriales/update&id= -> procesa actualización */
    public function actualizar(int $id): void
    {
        $datos = $this->obtenerDatosFormulario();
        $errores = $this->validar($datos, $id);

        if (!empty($errores)) {
            $datos['id'] = $id;
            require __DIR__ . '/../views/editoriales/edit.php';
            return;
        }

        editorial::actualizar(
            $id,
            $datos['nombre'], $datos['pais'], $datos['telefono'], $datos['email']
        );

        header('Location: index.php?route=editoriales&mensaje=actualizado');
        exit;
    }

    /** GET /editoriales/delete&id= -> elimina un registro */
    public function eliminar(int $id): void
    {
        editorial::eliminar($id);
        header('Location: index.php?route=editoriales&mensaje=eliminado');
        exit;
    }

    /** GET /editoriales/buscar -> búsqueda simple usando editorial::busqueda() */
    public function buscar(): void
    {
        $id = $_GET['id'] ?? 0;
        $nombre = $_GET['nombre'] ?? ''; $pais = $_GET['pais'] ?? '';

        $editoriales = (empty($id) && $nombre === '' && $pais === '')
            ? editorial::obtenerTodos()
            : editorial::busqueda($id, $nombre, $pais);

        require __DIR__ . '/../views/editoriales/index.php';
    }

    /** Busca un registro por su ID reutilizando editorial::busqueda() */
    private function buscarPorId(int $id): ?array
    {
        $resultados = editorial::busqueda($id, '', '');
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
            'pais' => trim(filter_input(INPUT_POST, 'pais', FILTER_UNSAFE_RAW) ?? ''),
            'telefono' => trim(filter_input(INPUT_POST, 'telefono', FILTER_UNSAFE_RAW) ?? ''),
            'email' => trim(filter_input(INPUT_POST, 'email', FILTER_UNSAFE_RAW) ?? '')
        ];
    }

    /** Validaciones de backend (nunca confiar solo en el frontend) */
    private function validar(array $datos, ?int $idActual = null): array
    {
        $errores = [];
        if ($datos['nombre'] === '') {
            $errores['nombre'] = 'Nombre de la editorial es obligatorio.';
        }
        if ($datos['pais'] === '') {
            $errores['pais'] = 'País es obligatorio.';
        }
        if ($datos['telefono'] === '') {
            $errores['telefono'] = 'Teléfono es obligatorio.';
        }

        if ($datos['email'] === '') {
            $errores['email'] = 'Correo electrónico es obligatorio.';
        } else {
            foreach (editorial::obtenerTodos() as $existente) {
                $mismoValor = $existente['email'] === $datos['email'];
                $esOtroRegistro = $idActual === null || (int) $existente['id'] !== $idActual;
                if ($mismoValor && $esOtroRegistro) {
                    $errores['email'] = 'Ya existe una editorial registrada con ese correo.';
                    break;
                }
            }
        }
        return $errores;
    }
}
