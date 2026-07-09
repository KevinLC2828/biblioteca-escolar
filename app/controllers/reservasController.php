<?php
require_once __DIR__ . '/../models/reservas.php';
require_once __DIR__ . '/../models/sala.php';

/**
 * Controlador de Reservas
 * Usa los métodos estáticos de las clases `reservas` y `sala` (mysqli).
 */
class ReservaController
{
    /** GET /reservas -> listado */
    public function index(): void
    {
        $reservasLista = reservas::obtenerTodos();
        require __DIR__ . '/../views/reservas/index.php';
    }

    /** GET /reservas/create -> formulario de creación */
    public function crear(): void
    {
        $errores = [];
        $datos = [];
        $salas = sala::obtenerTodos();
        require __DIR__ . '/../views/reservas/create.php';
    }

    /** POST /reservas/store -> procesa creación */
    public function guardar(): void
    {
        $datos = $this->obtenerDatosFormulario();
        $errores = $this->validar($datos);

        if (!empty($errores)) {
            $salas = sala::obtenerTodos();
            require __DIR__ . '/../views/reservas/create.php';
            return;
        }

        reservas::crear($datos['sala_id'], $datos['nombre_solicitante'], $datos['fecha_reserva'], $datos['hora_inicio'], $datos['hora_fin'], $datos['motivo'], $datos['estado']);

        header('Location: index.php?route=reservas&mensaje=creado');
        exit;
    }

    /** GET /reservas/edit&id= -> formulario de edición */
    public function editar(int $id): void
    {
        $datos = $this->buscarPorId($id);
        if (!$datos) {
            header('Location: index.php?route=reservas&error=no_encontrado');
            exit;
        }
        $errores = [];
        $salas = sala::obtenerTodos();
        require __DIR__ . '/../views/reservas/edit.php';
    }

    /** POST /reservas/update&id= -> procesa actualización */
    public function actualizar(int $id): void
    {
        $datos = $this->obtenerDatosFormulario();
        $errores = $this->validar($datos);

        if (!empty($errores)) {
            $datos['id'] = $id;
            $salas = sala::obtenerTodos();
            require __DIR__ . '/../views/reservas/edit.php';
            return;
        }

        reservas::actualizar(
            $id,
            $datos['sala_id'], $datos['nombre_solicitante'], $datos['fecha_reserva'], $datos['hora_inicio'], $datos['hora_fin'], $datos['motivo'], $datos['estado']
        );

        header('Location: index.php?route=reservas&mensaje=actualizado');
        exit;
    }

    /** GET /reservas/delete&id= -> elimina un registro */
    public function eliminar(int $id): void
    {
        reservas::eliminar($id);
        header('Location: index.php?route=reservas&mensaje=eliminado');
        exit;
    }

    /** Busca un registro por su ID reutilizando reservas::busqueda() */
    private function buscarPorId(int $id): ?array
    {
        $resultados = reservas::busqueda($id, '');
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
            'sala_id' => filter_input(INPUT_POST, 'sala_id', FILTER_VALIDATE_INT) ?: '',
            'nombre_solicitante' => trim(filter_input(INPUT_POST, 'nombre_solicitante', FILTER_UNSAFE_RAW) ?? ''),
            'fecha_reserva' => trim(filter_input(INPUT_POST, 'fecha_reserva', FILTER_UNSAFE_RAW) ?? ''),
            'hora_inicio' => trim(filter_input(INPUT_POST, 'hora_inicio', FILTER_UNSAFE_RAW) ?? ''),
            'hora_fin' => trim(filter_input(INPUT_POST, 'hora_fin', FILTER_UNSAFE_RAW) ?? ''),
            'motivo' => trim(filter_input(INPUT_POST, 'motivo', FILTER_UNSAFE_RAW) ?? ''),
            'estado' => trim(filter_input(INPUT_POST, 'estado', FILTER_UNSAFE_RAW) ?? '')
        ];
    }

    /** Validaciones de backend (nunca confiar solo en el frontend) */
    private function validar(array $datos): array
    {
        $errores = [];
        if (empty($datos['sala_id'])) {
            $errores['sala_id'] = 'Debe seleccionar un(a) sala.';
        } else {
            $existe = false;
            foreach (sala::obtenerTodos() as $p) {
                if ((int) $p['id'] === (int) $datos['sala_id']) {
                    $existe = true;
                    break;
                }
            }
            if (!$existe) {
                $errores['sala_id'] = 'El/la sala seleccionado(a) no existe.';
            }
        }
        if ($datos['nombre_solicitante'] === '') {
            $errores['nombre_solicitante'] = 'Nombre del solicitante es obligatorio.';
        }
        if ($datos['fecha_reserva'] === '') {
            $errores['fecha_reserva'] = 'La fecha es obligatoria.';
        }
        if ($datos['hora_inicio'] === '') {
            $errores['hora_inicio'] = 'La hora es obligatoria.';
        }
        if ($datos['hora_fin'] === '') {
            $errores['hora_fin'] = 'La hora es obligatoria.';
        }
        if ($datos['motivo'] === '') {
            $errores['motivo'] = 'Motivo de la reserva es obligatorio.';
        }
        if (!in_array($datos['estado'], ['confirmada', 'cancelada'], true)) {
            $errores['estado'] = 'Debe seleccionar una opción válida.';
        }

        return $errores;
    }
}
