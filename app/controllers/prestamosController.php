<?php
require_once __DIR__ . '/../models/prestamos.php';
require_once __DIR__ . '/../models/libro.php';

/**
 * Controlador de Préstamos
 * Usa los métodos estáticos de las clases `prestamos` y `libro` (mysqli).
 *
 * Nota: el modelo `prestamos::actualizar($id, $fecha_devolucion_real, $estado)`
 * solo permite modificar la fecha de devolución real y el estado de un
 * préstamo (no el prestatario ni las fechas de préstamo). El formulario de
 * edición refleja exactamente esa capacidad.
 */
class PrestamoController
{
    /** GET /prestamos -> listado */
    public function index(): void
    {
        $prestamosLista = prestamos::obtenerTodos();
        require __DIR__ . '/../views/prestamos/index.php';
    }

    /** GET /prestamos/create -> formulario de creación */
    public function crear(): void
    {
        $errores = [];
        $datos = [];
        $libros = libro::obtenerTodos();
        require __DIR__ . '/../views/prestamos/create.php';
    }

    /** POST /prestamos/store -> procesa creación */
    public function guardar(): void
    {
        $datos = $this->obtenerDatosFormularioCreacion();
        $errores = $this->validarCreacion($datos);

        if (!empty($errores)) {
            $libros = libro::obtenerTodos();
            require __DIR__ . '/../views/prestamos/create.php';
            return;
        }

        prestamos::crear(
            $datos['libro_id'],
            $datos['nombre_prestatario'],
            $datos['curso_grado'],
            $datos['fecha_prestamo'],
            $datos['fecha_devolucion_esperada'],
            '', // fecha_devolucion_real: aún no aplica al crear
            'prestado'
        );

        $this->decrementarStock((int) $datos['libro_id']);

        header('Location: index.php?route=prestamos&mensaje=creado');
        exit;
    }

    /** GET /prestamos/edit&id= -> formulario de edición (fecha real + estado) */
    public function editar(int $id): void
    {
        $datos = $this->buscarPorId($id);
        if (!$datos) {
            header('Location: index.php?route=prestamos&error=no_encontrado');
            exit;
        }
        $errores = [];
        require __DIR__ . '/../views/prestamos/edit.php';
    }

    /** POST /prestamos/update&id= -> procesa actualización */
    public function actualizar(int $id): void
    {
        $existente = $this->buscarPorId($id);
        if (!$existente) {
            header('Location: index.php?route=prestamos&error=no_encontrado');
            exit;
        }

        $fechaDevolucionReal = trim(filter_input(INPUT_POST, 'fecha_devolucion_real', FILTER_UNSAFE_RAW) ?? '');
        $estado = trim(filter_input(INPUT_POST, 'estado', FILTER_UNSAFE_RAW) ?? '');

        $errores = $this->validarActualizacion($estado, $fechaDevolucionReal);

        if (!empty($errores)) {
            $datos = $existente;
            $datos['fecha_devolucion_real'] = $fechaDevolucionReal;
            $datos['estado'] = $estado;
            require __DIR__ . '/../views/prestamos/edit.php';
            return;
        }

        prestamos::actualizar($id, $fechaDevolucionReal, $estado);

        // Si el estado cambió a "devuelto" y antes no lo estaba, se libera el stock.
        if ($existente['estado'] !== 'devuelto' && $estado === 'devuelto') {
            $this->incrementarStock((int) $existente['libro_id']);
        }
        // Si un préstamo devuelto se revierte a otro estado, se vuelve a descontar.
        if ($existente['estado'] === 'devuelto' && $estado !== 'devuelto') {
            $this->decrementarStock((int) $existente['libro_id']);
        }

        header('Location: index.php?route=prestamos&mensaje=actualizado');
        exit;
    }

    /** GET /prestamos/delete&id= -> elimina un préstamo */
    public function eliminar(int $id): void
    {
        $existente = $this->buscarPorId($id);
        if ($existente && $existente['estado'] !== 'devuelto') {
            // Si se elimina un préstamo activo, se libera el stock del libro.
            $this->incrementarStock((int) $existente['libro_id']);
        }
        prestamos::eliminar($id);
        header('Location: index.php?route=prestamos&mensaje=eliminado');
        exit;
    }

    /** GET /prestamos/devolver&id= -> marca como devuelto (atajo rápido) */
    public function devolver(int $id): void
    {
        $existente = $this->buscarPorId($id);
        if ($existente && $existente['estado'] !== 'devuelto') {
            prestamos::actualizar($id, date('Y-m-d'), 'devuelto');
            $this->incrementarStock((int) $existente['libro_id']);
        }
        header('Location: index.php?route=prestamos&mensaje=devuelto');
        exit;
    }

    /** Busca un préstamo por su ID reutilizando prestamos::busqueda() */
    private function buscarPorId(int $id): ?array
    {
        $resultados = prestamos::busqueda($id, '', '', '');
        foreach ($resultados as $fila) {
            if ((int) $fila['id'] === $id) {
                return $fila;
            }
        }
        return null;
    }

    /** Aumenta el stock de un libro reutilizando libro::busqueda() + libro::actualizar() */
    private function incrementarStock(int $libroId): void
    {
        $this->ajustarStock($libroId, 1);
    }

    /** Disminuye el stock de un libro reutilizando libro::busqueda() + libro::actualizar() */
    private function decrementarStock(int $libroId): void
    {
        $this->ajustarStock($libroId, -1);
    }

    private function ajustarStock(int $libroId, int $delta): void
    {
        $resultados = libro::busqueda($libroId, '', '');
        foreach ($resultados as $l) {
            if ((int) $l['id'] === $libroId) {
                $nuevoStock = max(0, (int) $l['stock'] + $delta);
                libro::actualizar(
                    $libroId,
                    $l['titulo'],
                    $l['autor'],
                    $l['editorial'],
                    $l['anio_publicacion'],
                    $l['isbn'],
                    $nuevoStock
                );
                break;
            }
        }
    }

    private function obtenerDatosFormularioCreacion(): array
    {
        return [
            'libro_id'                  => filter_input(INPUT_POST, 'libro_id', FILTER_VALIDATE_INT) ?: '',
            'nombre_prestatario'        => trim(filter_input(INPUT_POST, 'nombre_prestatario', FILTER_UNSAFE_RAW) ?? ''),
            'curso_grado'               => trim(filter_input(INPUT_POST, 'curso_grado', FILTER_UNSAFE_RAW) ?? ''),
            'fecha_prestamo'            => trim(filter_input(INPUT_POST, 'fecha_prestamo', FILTER_UNSAFE_RAW) ?? ''),
            'fecha_devolucion_esperada' => trim(filter_input(INPUT_POST, 'fecha_devolucion_esperada', FILTER_UNSAFE_RAW) ?? ''),
        ];
    }

    private function validarCreacion(array $datos): array
    {
        $errores = [];

        if (empty($datos['libro_id'])) {
            $errores['libro_id'] = 'Debe seleccionar un libro.';
        } else {
            $libroEncontrado = null;
            foreach (libro::obtenerTodos() as $l) {
                if ((int) $l['id'] === (int) $datos['libro_id']) {
                    $libroEncontrado = $l;
                    break;
                }
            }
            if (!$libroEncontrado) {
                $errores['libro_id'] = 'El libro seleccionado no existe.';
            } elseif ((int) $libroEncontrado['stock'] <= 0) {
                $errores['libro_id'] = 'No hay ejemplares disponibles de este libro.';
            }
        }

        if ($datos['nombre_prestatario'] === '') {
            $errores['nombre_prestatario'] = 'El nombre del prestatario es obligatorio.';
        }
        if ($datos['curso_grado'] === '') {
            $errores['curso_grado'] = 'El curso o grado es obligatorio.';
        }
        if ($datos['fecha_prestamo'] === '') {
            $errores['fecha_prestamo'] = 'La fecha de préstamo es obligatoria.';
        }
        if ($datos['fecha_devolucion_esperada'] === '') {
            $errores['fecha_devolucion_esperada'] = 'La fecha de devolución esperada es obligatoria.';
        } elseif ($datos['fecha_prestamo'] !== '' && $datos['fecha_devolucion_esperada'] < $datos['fecha_prestamo']) {
            $errores['fecha_devolucion_esperada'] = 'La devolución esperada no puede ser anterior al préstamo.';
        }

        return $errores;
    }

    private function validarActualizacion(string $estado, string $fechaDevolucionReal): array
    {
        $errores = [];
        $estadosValidos = ['prestado', 'devuelto', 'atrasado'];

        if (!in_array($estado, $estadosValidos, true)) {
            $errores['estado'] = 'Debe seleccionar un estado válido.';
        }
        if ($estado === 'devuelto' && $fechaDevolucionReal === '') {
            $errores['fecha_devolucion_real'] = 'Debe indicar la fecha real de devolución.';
        }

        return $errores;
    }
}