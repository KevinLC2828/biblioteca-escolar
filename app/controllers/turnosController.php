<?php
require_once __DIR__ . '/../models/turnos.php';
require_once __DIR__ . '/../models/empleado.php';

/**
 * Controlador de Turnos
 * Usa los métodos estáticos de las clases `turnos` y `empleado` (mysqli).
 */
class TurnoController
{
    /** GET /turnos -> listado */
    public function index(): void
    {
        $turnosLista = turnos::obtenerTodos();
        require __DIR__ . '/../views/turnos/index.php';
    }

    /** GET /turnos/create -> formulario de creación */
    public function crear(): void
    {
        $errores = [];
        $datos = [];
        $empleados = empleado::obtenerTodos();
        require __DIR__ . '/../views/turnos/create.php';
    }

    /** POST /turnos/store -> procesa creación */
    public function guardar(): void
    {
        $datos = $this->obtenerDatosFormulario();
        $errores = $this->validar($datos);

        if (!empty($errores)) {
            $empleados = empleado::obtenerTodos();
            require __DIR__ . '/../views/turnos/create.php';
            return;
        }

        turnos::crear($datos['empleado_id'], $datos['dia_semana'], $datos['hora_inicio'], $datos['hora_fin'], $datos['area']);

        header('Location: index.php?route=turnos&mensaje=creado');
        exit;
    }

    /** GET /turnos/edit&id= -> formulario de edición */
    public function editar(int $id): void
    {
        $datos = $this->buscarPorId($id);
        if (!$datos) {
            header('Location: index.php?route=turnos&error=no_encontrado');
            exit;
        }
        $errores = [];
        $empleados = empleado::obtenerTodos();
        require __DIR__ . '/../views/turnos/edit.php';
    }

    /** POST /turnos/update&id= -> procesa actualización */
    public function actualizar(int $id): void
    {
        $datos = $this->obtenerDatosFormulario();
        $errores = $this->validar($datos);

        if (!empty($errores)) {
            $datos['id'] = $id;
            $empleados = empleado::obtenerTodos();
            require __DIR__ . '/../views/turnos/edit.php';
            return;
        }

        turnos::actualizar(
            $id,
            $datos['empleado_id'], $datos['dia_semana'], $datos['hora_inicio'], $datos['hora_fin'], $datos['area']
        );

        header('Location: index.php?route=turnos&mensaje=actualizado');
        exit;
    }

    /** GET /turnos/delete&id= -> elimina un registro */
    public function eliminar(int $id): void
    {
        turnos::eliminar($id);
        header('Location: index.php?route=turnos&mensaje=eliminado');
        exit;
    }

    /** Busca un registro por su ID reutilizando turnos::busqueda() */
    private function buscarPorId(int $id): ?array
    {
        $resultados = turnos::busqueda($id, '');
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
            'empleado_id' => filter_input(INPUT_POST, 'empleado_id', FILTER_VALIDATE_INT) ?: '',
            'dia_semana' => trim(filter_input(INPUT_POST, 'dia_semana', FILTER_UNSAFE_RAW) ?? ''),
            'hora_inicio' => trim(filter_input(INPUT_POST, 'hora_inicio', FILTER_UNSAFE_RAW) ?? ''),
            'hora_fin' => trim(filter_input(INPUT_POST, 'hora_fin', FILTER_UNSAFE_RAW) ?? ''),
            'area' => trim(filter_input(INPUT_POST, 'area', FILTER_UNSAFE_RAW) ?? '')
        ];
    }

    /** Validaciones de backend (nunca confiar solo en el frontend) */
    private function validar(array $datos): array
    {
        $errores = [];
        if (empty($datos['empleado_id'])) {
            $errores['empleado_id'] = 'Debe seleccionar un(a) empleado.';
        } else {
            $existe = false;
            foreach (empleado::obtenerTodos() as $p) {
                if ((int) $p['id'] === (int) $datos['empleado_id']) {
                    $existe = true;
                    break;
                }
            }
            if (!$existe) {
                $errores['empleado_id'] = 'El/la empleado seleccionado(a) no existe.';
            }
        }
        if (!in_array($datos['dia_semana'], ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'], true)) {
            $errores['dia_semana'] = 'Debe seleccionar una opción válida.';
        }
        if ($datos['hora_inicio'] === '') {
            $errores['hora_inicio'] = 'La hora es obligatoria.';
        }
        if ($datos['hora_fin'] === '') {
            $errores['hora_fin'] = 'La hora es obligatoria.';
        }
        if ($datos['area'] === '') {
            $errores['area'] = 'Área asignada es obligatorio.';
        }

        return $errores;
    }
}
