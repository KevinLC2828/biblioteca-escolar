-- ============================================================
-- Base de datos: biblioteca_escolar
-- Proyecto: Biblioteca Escolar (Libros <-> Préstamos)
-- ============================================================

-- Asegura una importación consistente de acentos y caracteres especiales
-- sin importar la configuración por defecto del cliente mysql.
SET NAMES utf8mb4;

CREATE DATABASE IF NOT EXISTS biblioteca_escolar
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE biblioteca_escolar;

-- ------------------------------------------------------------
-- Tabla: libros
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS libros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    autor VARCHAR(120) NOT NULL,
    editorial VARCHAR(120) NOT NULL,
    anio_publicacion SMALLINT UNSIGNED NOT NULL,
    isbn VARCHAR(20) NOT NULL UNIQUE,
    stock INT NOT NULL DEFAULT 1,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- Tabla: prestamos
-- Relación: un libro puede tener muchos préstamos (1:N)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS prestamos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    libro_id INT NOT NULL,
    nombre_prestatario VARCHAR(120) NOT NULL,
    curso_grado VARCHAR(50) NOT NULL,
    fecha_prestamo DATE NOT NULL,
    fecha_devolucion_esperada DATE NOT NULL,
    fecha_devolucion_real DATE NULL,
    estado ENUM('prestado', 'devuelto', 'atrasado') NOT NULL DEFAULT 'prestado',
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_prestamo_libro
        FOREIGN KEY (libro_id) REFERENCES libros(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- Datos de ejemplo
-- ------------------------------------------------------------
INSERT INTO libros (titulo, autor, editorial, anio_publicacion, isbn, stock) VALUES
('Cien años de soledad', 'Gabriel García Márquez', 'Sudamericana', 1967, '978-0307474728', 3),
('Don Quijote de la Mancha', 'Miguel de Cervantes', 'Cátedra', 1605, '978-8437600550', 2),
('1984', 'George Orwell', 'Debolsillo', 1949, '978-8499890944', 4);

INSERT INTO prestamos (libro_id, nombre_prestatario, curso_grado, fecha_prestamo, fecha_devolucion_esperada, estado) VALUES
(1, 'Juan Pérez', '3ro Bachillerato', '2026-06-20', '2026-07-05', 'prestado'),
(2, 'María López', '2do Bachillerato', '2026-06-15', '2026-06-29', 'atrasado');