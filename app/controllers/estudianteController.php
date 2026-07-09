<?php
require_once __DIR__ . '/../models/estudiante.php';

/**
 * Controlador de Estudiantes
 * Usa los métodos estáticos de la clase `estudiante` (mysqli) para el CRUD.
 */
class EstudianteController
{
    /** GET /estudiantes -> listado */
    public function index(): void
    {
        $estudiantes = estudiante::obtenerTodos();
        require __DIR__ . '/../views/estudiantes/index.php';
    }

    /** GET /estudiantes/create -> formulario de creación */
    public function crear(): void
    {
        $errores = [];
        $datos = [];
        require __DIR__ . '/../views/estudiantes/create.php';
    }

    /** POST /estudiantes/store -> procesa creación */
    public function guardar(): void
    {
        $datos = $this->obtenerDatosFormulario();
        $errores = $this->validar($datos);

        if (!empty($errores)) {
            require __DIR__ . '/../views/estudiantes/create.php';
            return;
        }

        estudiante::crear($datos['nombres'], $datos['apellidos'], $datos['curso_grado'], $datos['cedula'], $datos['email']);

        header('Location: index.php?route=estudiantes&mensaje=creado');
        exit;
    }

    /** GET /estudiantes/edit&id= -> formulario de edición */
    public function editar(int $id): void
    {
        $datos = $this->buscarPorId($id);
        if (!$datos) {
            header('Location: index.php?route=estudiantes&error=no_encontrado');
            exit;
        }
        $errores = [];
        require __DIR__ . '/../views/estudiantes/edit.php';
    }

    /** POST /estudiantes/update&id= -> procesa actualización */
    public function actualizar(int $id): void
    {
        $datos = $this->obtenerDatosFormulario();
        $errores = $this->validar($datos, $id);

        if (!empty($errores)) {
            $datos['id'] = $id;
            require __DIR__ . '/../views/estudiantes/edit.php';
            return;
        }

        estudiante::actualizar(
            $id,
            $datos['nombres'], $datos['apellidos'], $datos['curso_grado'], $datos['cedula'], $datos['email']
        );

        header('Location: index.php?route=estudiantes&mensaje=actualizado');
        exit;
    }

    /** GET /estudiantes/delete&id= -> elimina un registro */
    public function eliminar(int $id): void
    {
        estudiante::eliminar($id);
        header('Location: index.php?route=estudiantes&mensaje=eliminado');
        exit;
    }

    /** GET /estudiantes/buscar -> búsqueda simple usando estudiante::busqueda() */
    public function buscar(): void
    {
        $id = $_GET['id'] ?? 0;
        $nombres = $_GET['nombres'] ?? ''; $apellidos = $_GET['apellidos'] ?? '';

        $estudiantes = (empty($id) && $nombres === '' && $apellidos === '')
            ? estudiante::obtenerTodos()
            : estudiante::busqueda($id, $nombres, $apellidos);

        require __DIR__ . '/../views/estudiantes/index.php';
    }

    /** Busca un registro por su ID reutilizando estudiante::busqueda() */
    private function buscarPorId(int $id): ?array
    {
        $resultados = estudiante::busqueda($id, '', '');
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
            'curso_grado' => trim(filter_input(INPUT_POST, 'curso_grado', FILTER_UNSAFE_RAW) ?? ''),
            'cedula' => trim(filter_input(INPUT_POST, 'cedula', FILTER_UNSAFE_RAW) ?? ''),
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
        if ($datos['curso_grado'] === '') {
            $errores['curso_grado'] = 'Curso / Grado es obligatorio.';
        }
        if ($datos['email'] === '' || !filter_var($datos['email'], FILTER_VALIDATE_EMAIL)) {
            $errores['email'] = 'Ingrese un correo electrónico válido.';
        }

        if ($datos['cedula'] === '') {
            $errores['cedula'] = 'Cédula es obligatorio.';
        } else {
            foreach (estudiante::obtenerTodos() as $existente) {
                $mismoValor = $existente['cedula'] === $datos['cedula'];
                $esOtroRegistro = $idActual === null || (int) $existente['id'] !== $idActual;
                if ($mismoValor && $esOtroRegistro) {
                    $errores['cedula'] = 'Ya existe un estudiante registrado con esa cédula.';
                    break;
                }
            }
        }
        return $errores;
    }
}
