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

### Editoriales y Adquisiciones
- CRUD completo de editoriales (nombre, país, teléfono, correo).
- Registro de adquisiciones de libros por editorial, con cantidad, costo y estado (pendiente/recibido/cancelado).

### Estudiantes y Sanciones
- CRUD completo de estudiantes (nombres, apellidos, curso/grado, cédula, correo).
- Registro de sanciones asociadas a un estudiante (motivo, monto, estado: pendiente/pagada/anulada).

### Empleados y Turnos
- CRUD completo de empleados (nombres, apellidos, cargo, teléfono, correo).
- Asignación de turnos de trabajo por empleado (día, hora de inicio/fin, área).

### Salas y Reservas
- CRUD completo de salas (nombre, capacidad, ubicación, estado: disponible/mantenimiento).
- Registro de reservas de sala (solicitante, fecha, horario, motivo, estado).

## Despliegue

La aplicación fue desplegada en **InfinityFree** en lugar de Render, como alternativa válida. Se eligió InfinityFree por las siguientes razones:

- **Soporte nativo de PHP y MySQL**: a diferencia de Render, que no ejecuta PHP de forma nativa (requiere configurar un contenedor Docker), InfinityFree está pensado específicamente para aplicaciones PHP + MySQL, sin configuración adicional.
- **Base de datos MySQL gratuita incluida**: Render no ofrece bases de datos MySQL administradas en su plan gratuito (solo PostgreSQL); InfinityFree sí la incluye directamente en el panel.
- **Panel simple tipo cPanel**: administración de archivos (File Manager), base de datos y phpMyAdmin desde un mismo panel, sin curva de aprendizaje adicional.

🔗 **Demo en línea:** [http://bibliotecaescolar.infinityfreeapp.com/Proyecto_Segundo_Parcial/public/index.php](http://bibliotecaescolar.infinityfreeapp.com/Proyecto_Segundo_Parcial/public/index.php)

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
│   └── validacion.js      # Validaciones de cliente (todos los módulos)
├── app/
│   ├── controllers/       # Un controlador por cada entidad (10 en total)
│   ├── models/            # Un modelo por cada entidad (10 en total)
│   ├── views/              # Vistas HTML/PHP, organizadas por módulo
│   └── config/conexion.php # Conexión a la base de datos (detecta local/producción)
└── database/
    ├── database.sql             # Tablas base: libros y prestamos
    └── database_extension.sql   # 8 tablas adicionales (4 pares por integrante)
```

## Módulos por integrante

Siguiendo el requisito de "CRUD completo de dos entidades relacionadas por integrante", el proyecto se organiza en 5 pares de entidades (padre-hijo, relación 1:N):

| Integrante | Entidad padre | Entidad hija (relacionada) |
|---|---|---|
| Lozada Castro Kevin Alberto | 📖 Libros | 🗂️ Préstamos |
| Angulo Bustos Terry Abiud | 🏢 Editoriales | 📦 Adquisiciones |
| Tovar Burgos Christian Jesus | 🎓 Estudiantes | ⚠️ Sanciones |
| Vargas Morales Cristobal Enrique | 🧑‍💼 Empleados | 🕒 Turnos |
| Zurita Barco Andy Gabriel | 🚪 Salas | 📅 Reservas |

## Instalación y ejecución local (XAMPP)

1. **Clonar o descargar** este repositorio dentro de la carpeta `htdocs` de tu instalación de XAMPP, por ejemplo:
   ```
   C:\xampp\htdocs\proyecto_segundo_parcial
   ```

2. **Iniciar Apache y MySQL** desde el Panel de Control de XAMPP.

3. **Importar la base de datos:**
   - Ir a `http://localhost/phpmyadmin`
   - Ir a la pestaña **Importar**
   - Seleccionar el archivo `database/database.sql` y ejecutar la importación (crea la base `biblioteca_escolar` con las tablas `libros` y `prestamos`).
   - Seleccionar la base de datos `biblioteca_escolar` en el panel izquierdo, ir de nuevo a **Importar** y seleccionar `database/database_extension.sql` (crea las 8 tablas adicionales de los demás integrantes).

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
