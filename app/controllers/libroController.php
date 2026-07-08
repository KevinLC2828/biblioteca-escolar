<?php
require_once __DIR__ . '/../models/libro.php';

/**
 * Controlador de Libros
 * Usa los métodos estáticos de la clase `libro` (mysqli) para el CRUD.
 */
class LibroController
{
    /** GET /libros -> listado */
    public function index(): void
    {
        $libros = libro::obtenerTodos();
        require __DIR__ . '/../views/libros/index.php';
    }

    /** GET /libros/create -> formulario de creación */
    public function crear(): void
    {
        $errores = [];
        $datos = [];
        require __DIR__ . '/../views/libros/create.php';
    }

    /** POST /libros/store -> procesa creación */
    public function guardar(): void
    {
        $datos = $this->obtenerDatosFormulario();
        $errores = $this->validar($datos);

        if (!empty($errores)) {
            require __DIR__ . '/../views/libros/create.php';
            return;
        }

        libro::crear(
            $datos['titulo'],
            $datos['autor'],
            $datos['editorial'],
            $datos['anio_publicacion'],
            $datos['isbn'],
            $datos['stock']
        );

        header('Location: index.php?route=libros&mensaje=creado');
        exit;
    }

    /** GET /libros/edit&id= -> formulario de edición */
    public function editar(int $id): void
    {
        $datos = $this->buscarPorId($id);
        if (!$datos) {
            header('Location: index.php?route=libros&error=no_encontrado');
            exit;
        }
        $errores = [];
        require __DIR__ . '/../views/libros/edit.php';
    }

    /** POST /libros/update&id= -> procesa actualización */
    public function actualizar(int $id): void
    {
        $datos = $this->obtenerDatosFormulario();
        $errores = $this->validar($datos, $id);

        if (!empty($errores)) {
            $datos['id'] = $id;
            require __DIR__ . '/../views/libros/edit.php';
            return;
        }

        libro::actualizar(
            $id,
            $datos['titulo'],
            $datos['autor'],
            $datos['editorial'],
            $datos['anio_publicacion'],
            $datos['isbn'],
            $datos['stock']
        );

        header('Location: index.php?route=libros&mensaje=actualizado');
        exit;
    }

    /** GET /libros/delete&id= -> elimina un libro */
    public function eliminar(int $id): void
    {
        libro::eliminar($id);
        header('Location: index.php?route=libros&mensaje=eliminado');
        exit;
    }

    /** GET /libros/buscar -> búsqueda simple usando libro::busqueda() */
    public function buscar(): void
    {
        $id = $_GET['id'] ?? 0;
        $titulo = $_GET['titulo'] ?? '';
        $autor = $_GET['autor'] ?? '';

        $libros = (empty($id) && $titulo === '' && $autor === '')
            ? libro::obtenerTodos()
            : libro::busqueda($id, $titulo, $autor);

        require __DIR__ . '/../views/libros/index.php';
    }

    /** Busca un libro por su ID reutilizando libro::busqueda() */
    private function buscarPorId(int $id): ?array
    {
        $resultados = libro::busqueda($id, '', '');
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
            'titulo'           => trim(filter_input(INPUT_POST, 'titulo', FILTER_UNSAFE_RAW) ?? ''),
            'autor'            => trim(filter_input(INPUT_POST, 'autor', FILTER_UNSAFE_RAW) ?? ''),
            'editorial'        => trim(filter_input(INPUT_POST, 'editorial', FILTER_UNSAFE_RAW) ?? ''),
            'anio_publicacion' => trim(filter_input(INPUT_POST, 'anio_publicacion', FILTER_UNSAFE_RAW) ?? ''),
            'isbn'             => trim(filter_input(INPUT_POST, 'isbn', FILTER_UNSAFE_RAW) ?? ''),
            'stock'            => trim(filter_input(INPUT_POST, 'stock', FILTER_UNSAFE_RAW) ?? ''),
        ];
    }

    /** Validaciones de backend (nunca confiar solo en el frontend) */
    private function validar(array $datos, ?int $idActual = null): array
    {
        $errores = [];

        if ($datos['titulo'] === '') {
            $errores['titulo'] = 'El título es obligatorio.';
        }
        if ($datos['autor'] === '') {
            $errores['autor'] = 'El autor es obligatorio.';
        }
        if ($datos['editorial'] === '') {
            $errores['editorial'] = 'La editorial es obligatoria.';
        }
        if ($datos['anio_publicacion'] === '' || !ctype_digit((string) $datos['anio_publicacion'])
            || (int) $datos['anio_publicacion'] < 1400 || (int) $datos['anio_publicacion'] > (int) date('Y')) {
            $errores['anio_publicacion'] = 'Ingrese un año válido.';
        }

        if ($datos['isbn'] === '') {
            $errores['isbn'] = 'El ISBN es obligatorio.';
        } else {
            // Verificación de ISBN duplicado usando libro::obtenerTodos()
            foreach (libro::obtenerTodos() as $existente) {
                $mismoIsbn = $existente['isbn'] === $datos['isbn'];
                $esOtroRegistro = $idActual === null || (int) $existente['id'] !== $idActual;
                if ($mismoIsbn && $esOtroRegistro) {
                    $errores['isbn'] = 'Ya existe un libro registrado con ese ISBN.';
                    break;
                }
            }
        }

        if ($datos['stock'] === '' || !ctype_digit((string) $datos['stock']) || (int) $datos['stock'] < 0) {
            $errores['stock'] = 'El stock debe ser un número entero mayor o igual a 0.';
        }

        return $errores;
    }
}