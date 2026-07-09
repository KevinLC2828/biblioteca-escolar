<?php
require_once __DIR__ . '/../models/sanciones.php';
require_once __DIR__ . '/../models/estudiante.php';

/**
 * Controlador de Sanciones
 * Usa los métodos estáticos de las clases `sanciones` y `estudiante` (mysqli).
 */
class SancionController
{
    /** GET /sanciones -> listado */
    public function index(): void
    {
        $sancionesLista = sanciones::obtenerTodos();
        require __DIR__ . '/../views/sanciones/index.php';
    }

    /** GET /sanciones/create -> formulario de creación */
    public function crear(): void
    {
        $errores = [];
        $datos = [];
        $estudiantes = estudiante::obtenerTodos();
        require __DIR__ . '/../views/sanciones/create.php';
    }

    /** POST /sanciones/store -> procesa creación */
    public function guardar(): void
    {
        $datos = $this->obtenerDatosFormulario();
        $errores = $this->validar($datos);

        if (!empty($errores)) {
            $estudiantes = estudiante::obtenerTodos();
            require __DIR__ . '/../views/sanciones/create.php';
            return;
        }

        sanciones::crear($datos['estudiante_id'], $datos['motivo'], $datos['monto'], $datos['fecha_sancion'], $datos['estado']);

        header('Location: index.php?route=sanciones&mensaje=creado');
        exit;
    }

    /** GET /sanciones/edit&id= -> formulario de edición */
    public function editar(int $id): void
    {
        $datos = $this->buscarPorId($id);
        if (!$datos) {
            header('Location: index.php?route=sanciones&error=no_encontrado');
            exit;
        }
        $errores = [];
        $estudiantes = estudiante::obtenerTodos();
        require __DIR__ . '/../views/sanciones/edit.php';
    }

    /** POST /sanciones/update&id= -> procesa actualización */
    public function actualizar(int $id): void
    {
        $datos = $this->obtenerDatosFormulario();
        $errores = $this->validar($datos);

        if (!empty($errores)) {
            $datos['id'] = $id;
            $estudiantes = estudiante::obtenerTodos();
            require __DIR__ . '/../views/sanciones/edit.php';
            return;
        }

        sanciones::actualizar(
            $id,
            $datos['estudiante_id'], $datos['motivo'], $datos['monto'], $datos['fecha_sancion'], $datos['estado']
        );

        header('Location: index.php?route=sanciones&mensaje=actualizado');
        exit;
    }

    /** GET /sanciones/delete&id= -> elimina un registro */
    public function eliminar(int $id): void
    {
        sanciones::eliminar($id);
        header('Location: index.php?route=sanciones&mensaje=eliminado');
        exit;
    }

    /** Busca un registro por su ID reutilizando sanciones::busqueda() */
    private function buscarPorId(int $id): ?array
    {
        $resultados = sanciones::busqueda($id, '');
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
            'estudiante_id' => filter_input(INPUT_POST, 'estudiante_id', FILTER_VALIDATE_INT) ?: '',
            'motivo' => trim(filter_input(INPUT_POST, 'motivo', FILTER_UNSAFE_RAW) ?? ''),
            'monto' => trim(filter_input(INPUT_POST, 'monto', FILTER_UNSAFE_RAW) ?? ''),
            'fecha_sancion' => trim(filter_input(INPUT_POST, 'fecha_sancion', FILTER_UNSAFE_RAW) ?? ''),
            'estado' => trim(filter_input(INPUT_POST, 'estado', FILTER_UNSAFE_RAW) ?? '')
        ];
    }

    /** Validaciones de backend (nunca confiar solo en el frontend) */
    private function validar(array $datos): array
    {
        $errores = [];
        if (empty($datos['estudiante_id'])) {
            $errores['estudiante_id'] = 'Debe seleccionar un(a) estudiante.';
        } else {
            $existe = false;
            foreach (estudiante::obtenerTodos() as $p) {
                if ((int) $p['id'] === (int) $datos['estudiante_id']) {
                    $existe = true;
                    break;
                }
            }
            if (!$existe) {
                $errores['estudiante_id'] = 'El/la estudiante seleccionado(a) no existe.';
            }
        }
        if ($datos['motivo'] === '') {
            $errores['motivo'] = 'Motivo es obligatorio.';
        }
        if ($datos['monto'] === '' || !is_numeric($datos['monto']) || (float) $datos['monto'] < 0) {
            $errores['monto'] = 'Ingrese un valor numérico válido.';
        }
        if ($datos['fecha_sancion'] === '') {
            $errores['fecha_sancion'] = 'La fecha es obligatoria.';
        }
        if (!in_array($datos['estado'], ['pendiente', 'pagada', 'anulada'], true)) {
            $errores['estado'] = 'Debe seleccionar una opción válida.';
        }

        return $errores;
    }
}
