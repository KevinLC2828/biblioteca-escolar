<?php
require_once __DIR__ . '/../models/empleado.php';

/**
 * Controlador de Empleados
 * Usa los métodos estáticos de la clase `empleado` (mysqli) para el CRUD.
 */
class EmpleadoController
{
    /** GET /empleados -> listado */
    public function index(): void
    {
        $empleados = empleado::obtenerTodos();
        require __DIR__ . '/../views/empleados/index.php';
    }

    /** GET /empleados/create -> formulario de creación */
    public function crear(): void
    {
        $errores = [];
        $datos = [];
        require __DIR__ . '/../views/empleados/create.php';
    }

    /** POST /empleados/store -> procesa creación */
    public function guardar(): void
    {
        $datos = $this->obtenerDatosFormulario();
        $errores = $this->validar($datos);

        if (!empty($errores)) {
            require __DIR__ . '/../views/empleados/create.php';
            return;
        }

        empleado::crear($datos['nombres'], $datos['apellidos'], $datos['cargo'], $datos['telefono'], $datos['email']);

        header('Location: index.php?route=empleados&mensaje=creado');
        exit;
    }

    /** GET /empleados/edit&id= -> formulario de edición */
    public function editar(int $id): void
    {
        $datos = $this->buscarPorId($id);
        if (!$datos) {
            header('Location: index.php?route=empleados&error=no_encontrado');
            exit;
        }
        $errores = [];
        require __DIR__ . '/../views/empleados/edit.php';
    }

    /** POST /empleados/update&id= -> procesa actualización */
    public function actualizar(int $id): void
    {
        $datos = $this->obtenerDatosFormulario();
        $errores = $this->validar($datos, $id);

        if (!empty($errores)) {
            $datos['id'] = $id;
            require __DIR__ . '/../views/empleados/edit.php';
            return;
        }

        empleado::actualizar(
            $id,
            $datos['nombres'], $datos['apellidos'], $datos['cargo'], $datos['telefono'], $datos['email']
        );

        header('Location: index.php?route=empleados&mensaje=actualizado');
        exit;
    }

    /** GET /empleados/delete&id= -> elimina un registro */
    public function eliminar(int $id): void
    {
        empleado::eliminar($id);
        header('Location: index.php?route=empleados&mensaje=eliminado');
        exit;
    }

    /** GET /empleados/buscar -> búsqueda simple usando empleado::busqueda() */
    public function buscar(): void
    {
        $id = $_GET['id'] ?? 0;
        $nombres = $_GET['nombres'] ?? ''; $apellidos = $_GET['apellidos'] ?? '';

        $empleados = (empty($id) && $nombres === '' && $apellidos === '')
            ? empleado::obtenerTodos()
            : empleado::busqueda($id, $nombres, $apellidos);

        require __DIR__ . '/../views/empleados/index.php';
    }

    /** Busca un registro por su ID reutilizando empleado::busqueda() */
    private function buscarPorId(int $id): ?array
    {
        $resultados = empleado::busqueda($id, '', '');
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
            'nombres' => trim(filter_input(INPUT_POST, 'nombres', FILTER_UNSAFE_RAW) ?? ''),
            'apellidos' => trim(filter_input(INPUT_POST, 'apellidos', FILTER_UNSAFE_RAW) ?? ''),
            'cargo' => trim(filter_input(INPUT_POST, 'cargo', FILTER_UNSAFE_RAW) ?? ''),
            'telefono' => trim(filter_input(INPUT_POST, 'telefono', FILTER_UNSAFE_RAW) ?? ''),
            'email' => trim(filter_input(INPUT_POST, 'email', FILTER_UNSAFE_RAW) ?? '')
        ];
    }

    /** Validaciones de backend (nunca confiar solo en el frontend) */
    private function validar(array $datos, ?int $idActual = null): array
    {
        $errores = [];
        if ($datos['nombres'] === '') {
            $errores['nombres'] = 'Nombres es obligatorio.';
        }
        if ($datos['apellidos'] === '') {
            $errores['apellidos'] = 'Apellidos es obligatorio.';
        }
        if ($datos['cargo'] === '') {
            $errores['cargo'] = 'Cargo es obligatorio.';
        }
        if ($datos['telefono'] === '') {
            $errores['telefono'] = 'Teléfono es obligatorio.';
        }

        if ($datos['email'] === '') {
            $errores['email'] = 'Correo electrónico es obligatorio.';
        } else {
            foreach (empleado::obtenerTodos() as $existente) {
                $mismoValor = $existente['email'] === $datos['email'];
                $esOtroRegistro = $idActual === null || (int) $existente['id'] !== $idActual;
                if ($mismoValor && $esOtroRegistro) {
                    $errores['email'] = 'Ya existe un empleado registrado con ese correo.';
                    break;
                }
            }
        }
        return $errores;
    }
}
