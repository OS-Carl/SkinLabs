CREATE DATABASE esba;
USE esba;

-- Crear tabla pacientes
CREATE TABLE pacientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dni VARCHAR(15) UNIQUE,
    nombre VARCHAR(100),
    telefono VARCHAR(20),
    direccion VARCHAR(150),
    fecha_nacimiento DATE
);

-- Crear tabla profesionales
CREATE TABLE profesionales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    especialidad VARCHAR(100)
);

-- Crear tabla tratamientos (incluyendo historial)
CREATE TABLE tratamientos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_paciente INT,
    id_profesional INT,
    fecha DATE,
    descripcion TEXT,
    observaciones TEXT DEFAULT NULL,
    historial_fecha DATE DEFAULT NULL,  -- Fecha cuando se agrega al historial
    FOREIGN KEY (id_paciente) REFERENCES pacientes(id),
    FOREIGN KEY (id_profesional) REFERENCES profesionales(id)
);

-- Insertar pacientes de prueba
INSERT INTO pacientes (dni, nombre, telefono, direccion, fecha_nacimiento)
VALUES 
('12345678', 'María López', '1122334455', 'Av. Siempreviva 123', '1990-05-12'),
('87654321', 'Juan Pérez', '1133445566', 'Calle Falsa 456', '1985-09-21');

-- Insertar profesionales
INSERT INTO profesionales (nombre, especialidad)
VALUES 
('Dra. Lucía Fernández', 'Dermatología'),
('Dr. Martín Gómez', 'Cosmetología'),
('Juan Sanchez', 'Masajista profesional'),
('Dra. Sofia Martinez', 'Esteticista'),
('Dr. Fernando López', 'Manicurista/Pedicurista');

-- Insertar tratamientos
INSERT INTO tratamientos (id_paciente, id_profesional, fecha, descripcion, observaciones, historial_fecha)
VALUES
(1, 1, '2025-04-01', 'Limpieza facial profunda', 'Piel sensible, recomendación de productos suaves', '2025-04-08'),
(2, 2, '2025-04-02', 'Tratamiento antiacné', 'Buena respuesta al tratamiento, seguir control', '2025-04-10');

CREATE TABLE citas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    telefono VARCHAR(20),
    servicio VARCHAR(100),
    fecha DATE,
    hora TIME
);
CREATE TABLE empleados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) UNIQUE NOT NULL,
    clave VARCHAR(255) NOT NULL -- Hasheada
);
INSERT INTO empleados (usuario, clave)
VALUES ('admin', SHA2('1234', 256));

INSERT INTO citas (nombre, telefono, servicio, fecha, hora) VALUES
('Carla Ramírez', '1144556677', 'Limpieza facial', '2025-12-01', '10:00'),
('Luis González', '1199887766', 'Tratamiento antiacné', '2025-12-03', '14:30'),
('Sofía Álvarez', '1133445566', 'Masajes relajantes', '2025-12-05', '09:00'),
('Mariano Pérez', '1122334455', 'Manicura completa', '2025-12-10', '11:15'),
('Natalia Suárez', '1177665544', 'Consulta dermatológica', '2025-12-15', '13:00');

-- 1. Añadir restricción para evitar que una persona agende más de una cita en el mismo día
ALTER TABLE citas ADD CONSTRAINT unique_persona_dia UNIQUE (nombre, fecha);

-- 2. Añadir restricción para evitar que se agenden dos citas a la misma hora
ALTER TABLE citas ADD CONSTRAINT unique_hora_fecha UNIQUE (fecha, hora);

-- 3. Crear un TRIGGER para evitar agendar citas en fechas pasadas
DELIMITER //
CREATE TRIGGER evitar_fecha_pasada BEFORE INSERT ON citas
FOR EACH ROW
BEGIN
    DECLARE fecha_actual DATE;
    SET fecha_actual = CURDATE();
    IF NEW.fecha < fecha_actual THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'No se puede agendar una cita en una fecha pasada';
    END IF;
END; //
DELIMITER ;

ALTER TABLE citas ADD dni VARCHAR(15);