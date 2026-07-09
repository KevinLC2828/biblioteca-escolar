

-- ============================================================
-- Módulos adicionales (8 entidades, 4 pares) — 4 integrantes más
-- ============================================================

-- ------------------------------------------------------------
-- Tabla: editoriales
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS editoriales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    pais VARCHAR(80) NOT NULL,
    telefono VARCHAR(20) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- Tabla: adquisiciones
-- Relación: un(a) editorial puede tener muchos(as) adquisiciones (1:N)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS adquisiciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    editorial_id INT NOT NULL,
    titulo_obra VARCHAR(150) NOT NULL,
    cantidad INT NOT NULL DEFAULT 1,
    fecha_adquisicion DATE NOT NULL,
    costo_unitario DECIMAL(8,2) NOT NULL,
    estado ENUM('pendiente', 'recibido', 'cancelado') NOT NULL DEFAULT 'pendiente',
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_adquisicion_editorial
        FOREIGN KEY (editorial_id) REFERENCES editoriales(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- Tabla: estudiantes
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS estudiantes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombres VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    curso_grado VARCHAR(50) NOT NULL,
    cedula VARCHAR(15) NOT NULL UNIQUE,
    email VARCHAR(150) NOT NULL,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- Tabla: sanciones
-- Relación: un(a) estudiante puede tener muchos(as) sanciones (1:N)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS sanciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    estudiante_id INT NOT NULL,
    motivo VARCHAR(200) NOT NULL,
    monto DECIMAL(8,2) NOT NULL,
    fecha_sancion DATE NOT NULL,
    estado ENUM('pendiente', 'pagada', 'anulada') NOT NULL DEFAULT 'pendiente',
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_sancion_estudiante
        FOREIGN KEY (estudiante_id) REFERENCES estudiantes(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- Tabla: empleados
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS empleados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombres VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    cargo VARCHAR(80) NOT NULL,
    telefono VARCHAR(20) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- Tabla: turnos
-- Relación: un(a) empleado puede tener muchos(as) turnos (1:N)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS turnos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    empleado_id INT NOT NULL,
    dia_semana ENUM('Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado') NOT NULL DEFAULT 'Lunes',
    hora_inicio TIME NOT NULL,
    hora_fin TIME NOT NULL,
    area VARCHAR(80) NOT NULL,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_turno_empleado
        FOREIGN KEY (empleado_id) REFERENCES empleados(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- Tabla: salas
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS salas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL UNIQUE,
    capacidad INT NOT NULL,
    ubicacion VARCHAR(120) NOT NULL,
    estado ENUM('disponible', 'mantenimiento') NOT NULL DEFAULT 'disponible',
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- Tabla: reservas
-- Relación: un(a) sala puede tener muchos(as) reservas (1:N)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS reservas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sala_id INT NOT NULL,
    nombre_solicitante VARCHAR(120) NOT NULL,
    fecha_reserva DATE NOT NULL,
    hora_inicio TIME NOT NULL,
    hora_fin TIME NOT NULL,
    motivo VARCHAR(150) NOT NULL,
    estado ENUM('confirmada', 'cancelada') NOT NULL DEFAULT 'confirmada',
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_reserva_sala
        FOREIGN KEY (sala_id) REFERENCES salas(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- Datos de ejemplo de los módulos adicionales
-- ------------------------------------------------------------

INSERT INTO editoriales (nombre, pais, telefono, email) VALUES
('Editorial Planeta', 'España', '+34911234567', 'contacto@planeta.es'),
('Penguin Random House', 'Estados Unidos', '+12125551234', 'info@penguinrandomhouse.com'),
('Editorial Norma', 'Colombia', '+5716000000', 'ventas@norma.com');

INSERT INTO adquisiciones (editorial_id, titulo_obra, cantidad, fecha_adquisicion, costo_unitario, estado) VALUES
(1, 'El amor en los tiempos del cólera', 10, '2026-05-10', 8.50, 'recibido'),
(2, 'Sapiens: De animales a dioses', 6, '2026-06-01', 12.00, 'pendiente'),
(3, 'Fábulas y sueños', 4, '2026-06-15', 9.75, 'pendiente');

INSERT INTO estudiantes (nombres, apellidos, curso_grado, cedula, email) VALUES
('Ana', 'Torres Vega', '2do Bachillerato', '1750000011', 'ana.torres@estudiantes.edu.ec'),
('Luis', 'Mendoza Ruiz', '3ro Bachillerato', '1750000022', 'luis.mendoza@estudiantes.edu.ec'),
('Sofía', 'Ramírez Paz', '1ro Bachillerato', '1750000033', 'sofia.ramirez@estudiantes.edu.ec');

INSERT INTO sanciones (estudiante_id, motivo, monto, fecha_sancion, estado) VALUES
(2, 'Devolución tardía de libro', 2.50, '2026-06-20', 'pendiente'),
(1, 'Libro devuelto con daños menores', 5.00, '2026-05-28', 'pagada');

INSERT INTO empleados (nombres, apellidos, cargo, telefono, email) VALUES
('Marta', 'Suárez León', 'Bibliotecaria', '0991234567', 'marta.suarez@biblioteca.edu.ec'),
('Pedro', 'Andrade Cruz', 'Asistente de biblioteca', '0987654321', 'pedro.andrade@biblioteca.edu.ec');

INSERT INTO turnos (empleado_id, dia_semana, hora_inicio, hora_fin, area) VALUES
(1, 'Lunes', '08:00:00', '13:00:00', 'Atención al público'),
(1, 'Miercoles', '13:00:00', '17:00:00', 'Catalogación'),
(2, 'Martes', '08:00:00', '13:00:00', 'Préstamos y devoluciones');

INSERT INTO salas (nombre, capacidad, ubicacion, estado) VALUES
('Sala de Lectura Silenciosa', 20, 'Primer piso, ala norte', 'disponible'),
('Sala de Estudio Grupal A', 8, 'Segundo piso', 'disponible'),
('Sala Multimedia', 15, 'Primer piso, ala sur', 'mantenimiento');

INSERT INTO reservas (sala_id, nombre_solicitante, fecha_reserva, hora_inicio, hora_fin, motivo, estado) VALUES
(2, 'Grupo de Proyecto - 3ro Bachillerato', '2026-07-10', '10:00:00', '12:00:00', 'Trabajo grupal de Biología', 'confirmada'),
(1, 'Sofía Ramírez Paz', '2026-07-09', '15:00:00', '16:00:00', 'Estudio individual para examen', 'confirmada');
