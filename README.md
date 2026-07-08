# Biblioteca Escolar

Sistema web de gestión de biblioteca escolar desarrollado con **PHP** y **MySQL**, siguiendo el patrón **MVC (Modelo–Vista–Controlador)**. Permite administrar el catálogo de libros y controlar los préstamos realizados a los estudiantes mediante operaciones **CRUD** completas.

## Descripción del problema

La aplicación resuelve la gestión manual de préstamos de libros en una institución educativa, permitiendo:
- Registrar, editar, consultar y eliminar libros del catálogo.
- Registrar préstamos a estudiantes y controlar su devolución.
- Llevar el control automático de existencias (stock) disponibles de cada libro.

## Funcionalidades

### Libros
- Crear, listar, editar y eliminar libros.
- Búsqueda por título o autor.
- Validación de ISBN único.

### Prestamos
- Registrar un préstamo asociado a un libro y un estudiante.
- Marcar un préstamo como devuelto (actualiza automáticamente el stock del libro).
- Editar estado y fecha real de devolución.
- Eliminar préstamos.

## Tecnologías utilizadas

- **Backend:** PHP (arquitectura MVC, sin frameworks)
- **Base de datos:** MySQL / MariaDB
- **Frontend:** HTML5, CSS3, JavaScript (validaciones de cliente)
- **Servidor local de pruebas:** XAMPP (Apache + MySQL)

## Estructura del proyecto

```
proyecto_segundo_parcial/
├── public/
│   ├── index.php          # Front Controller / enrutador principal
│   ├── css/style.css
│   └── js/validations.js  # Validaciones de cliente
├── app/
│   ├── controllers/       # Lógica de negocio (LibroController, PrestamoController)
│   ├── models/            # Acceso a datos (libro, prestamos)
│   ├── views/              # Vistas HTML/PHP
│   └── config/conexion.php # Conexión a la base de datos
└── database/
    └── database.sql        # Script de creación e inserción de datos de ejemplo
```

## Instalación y ejecución local (XAMPP)

1. **Clonar o descargar** este repositorio dentro de la carpeta `htdocs` de tu instalación de XAMPP, por ejemplo:
   ```
   C:\xampp\htdocs\proyecto_segundo_parcial
   ```

2. **Iniciar Apache y MySQL** desde el Panel de Control de XAMPP.

3. **Importar la base de datos:**
   - Ir a `http://localhost/phpmyadmin`
   - Ir a la pestaña **Importar**
   - Seleccionar el archivo `database/database.sql`
   - Ejecutar la importación (esto crea la base `biblioteca_escolar` con sus tablas y datos de ejemplo).

4. **Verificar la configuración de conexión** en `app/config/conexion.php`:
   ```php
   $host    = "127.0.0.1";
   $bd      = "biblioteca_escolar";
   $usuario = "root";
   $clave   = "";
   $puerto  = "3306"; // puerto por defecto de MySQL en XAMPP
   ```
   Ajusta usuario, clave o puerto según tu configuración local.

5. **Abrir la aplicación en el navegador:**
   ```
   http://localhost/proyecto_segundo_parcial/public/index.php
   ```

## Credenciales de base de datos (entorno local)

| Host - 127.0.0.1 |
| Puerto - 3306 |
| Usuario - root |
| Contraseña - (vacia) |
| Base de datos - biblioteca_escolar |

## Autores

- Angulo Bustos Terry Abiud
- Lozada Castro Kevin Alberto
- Tovar Burgos Christian Jesus
- Vargas Morales Cristobal Enrique 
- Zurita Barco Andy Gabriel

## Notas

- Proyecto desarrollado como Segundo Parcial de la asignatura de Desarrollo de Aplicaciones Web con PHP.
- Las validaciones se implementan tanto en el cliente (HTML5 + JavaScript) como en el servidor (PHP), conforme a los requisitos del proyecto.
