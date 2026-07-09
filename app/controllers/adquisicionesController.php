<?php
require_once __DIR__ . '/../models/adquisiciones.php';
require_once __DIR__ . '/../models/editorial.php';

/**
 * Controlador de Adquisiciones
 * Usa los métodos estáticos de las clases `adquisiciones` y `editorial` (mysqli).
 */
class AdquisicionController
{
    /** GET /adquisiciones -> listado */
    public function index(): void
    {
        $adquisicionesLista = adquisiciones::obtenerTodos();
        require __DIR__ . '/../views/adquisiciones/index.php';
    }

    /** GET /adquisiciones/create -> formulario de creación */
    public function crear(): void
    {
        $errores = [];
        $datos = [];
        $editoriales = editorial::obtenerTodos();
        require __DIR__ . '/../views/adquisiciones/create.php';
    }

    /** POST /adquisiciones/store -> procesa creación */
    public function guardar(): void
    {
        $datos = $this->obtenerDatosFormulario();
        $errores = $this->validar($datos);

        if (!empty($errores)) {
            $editoriales = editorial::obtenerTodos();
            require __DIR__ . '/../views/adquisiciones/create.php';
            return;
        }

        adquisiciones::crear($datos['editorial_id'], $datos['titulo_obra'], $datos['cantidad'], $datos['fecha_adquisicion'], $datos['costo_unitario'], $datos['estado']);

        header('Location: index.php?route=adquisiciones&mensaje=creado');
        exit;
    }

    /** GET /adquisiciones/edit&id= -> formulario de edición */
    public function editar(int $id): void
    {
        $datos = $this->buscarPorId($id);
        if (!$datos) {
            header('Location: index.php?route=adquisiciones&error=no_encontrado');
            exit;
        }
        $errores = [];
        $editoriales = editorial::obtenerTodos();
        require __DIR__ . '/../views/adquisiciones/edit.php';
    }

    /** POST /adquisiciones/update&id= -> procesa actualización */
    public function actualizar(int $id): void
    {
        $datos = $this->obtenerDatosFormulario();
        $errores = $this->validar($datos);

        if (!empty($errores)) {
            $datos['id'] = $id;
            $editoriales = editorial::obtenerTodos();
            require __DIR__ . '/../views/adquisiciones/edit.php';
            return;
        }

        adquisiciones::actualizar(
            $id,
            $datos['editorial_id'], $datos['titulo_obra'], $datos['cantidad'], $datos['fecha_adquisicion'], $datos['costo_unitario'], $datos['estado']
        );

        header('Location: index.php?route=adquisiciones&mensaje=actualizado');
        exit;
    }

    /** GET /adquisiciones/delete&id= -> elimina un registro */
    public function eliminar(int $id): void
    {
        adquisiciones::eliminar($id);
        header('Location: index.php?route=adquisiciones&mensaje=eliminado');
        exit;
    }

    /** Busca un registro por su ID reutilizando adquisiciones::busqueda() */
    private function buscarPorId(int $id): ?array
    {
        $resultados = adquisiciones::busqueda($id, '');
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
            'editorial_id' => filter_input(INPUT_POST, 'editorial_id', FILTER_VALIDATE_INT) ?: '',
            'titulo_obra' => trim(filter_input(INPUT_POST, 'titulo_obra', FILTER_UNSAFE_RAW) ?? ''),
            'cantidad' => trim(filter_input(INPUT_POST, 'cantidad', FILTER_UNSAFE_RAW) ?? ''),
            'fecha_adquisicion' => trim(filter_input(INPUT_POST, 'fecha_adquisicion', FILTER_UNSAFE_RAW) ?? ''),
            'costo_unitario' => trim(filter_input(INPUT_POST, 'costo_unitario', FILTER_UNSAFE_RAW) ?? ''),
            'estado' => trim(filter_input(INPUT_POST, 'estado', FILTER_UNSAFE_RAW) ?? '')
        ];
    }

    /** Validaciones de backend (nunca confiar solo en el frontend) */
    private function validar(array $datos): array
    {
        $errores = [];
        if (empty($datos['editorial_id'])) {
            $errores['editorial_id'] = 'Debe seleccionar un(a) editorial.';
        } else {
            $existe = false;
            foreach (editorial::obtenerTodos() as $p) {
                if ((int) $p['id'] === (int) $datos['editorial_id']) {
                    $existe = true;
                    break;
                }
            }
            if (!$existe) {
                $errores['editorial_id'] = 'El/la editorial seleccionado(a) no existe.';
            }
        }
        if ($datos['titulo_obra'] === '') {
            $errores['titulo_obra'] = 'Título de la obra es obligatorio.';
        }
        if ($datos['cantidad'] === '' || !is_numeric($datos['cantidad']) || (float) $datos['cantidad'] < 0) {
            $errores['cantidad'] = 'Ingrese un valor numérico válido.';
        }
        if ($datos['fecha_adquisicion'] === '') {
            $errores['fecha_adquisicion'] = 'La fecha es obligatoria.';
        }
        if ($datos['costo_unitario'] === '' || !is_numeric($datos['costo_unitario']) || (float) $datos['costo_unitario'] < 0) {
            $errores['costo_unitario'] = 'Ingrese un valor numérico válido.';
        }
        if (!in_array($datos['estado'], ['pendiente', 'recibido', 'cancelado'], true)) {
            $errores['estado'] = 'Debe seleccionar una opción válida.';
        }

        return $errores;
    }
}
