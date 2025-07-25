-- CREATE USER 'test'@'localhost' IDENTIFIED BY '1234';
-- GRANT ALL PRIVILEGES ON *.* TO 'test'@'localhost' WITH GRANT OPTION;
-- FLUSH PRIVILEGES;


CREATE DATABASE registro_intenciones;
USE registro_intenciones;

CREATE TABLE intencion (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT NOT NULL
);
CREATE TABLE peticiones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    por_quien VARCHAR(100) NOT NULL,
    intencion_id INT NOT NULL,
    descripcion TEXT,
    fecha_registro DATE NOT NULL,       -- Fecha en que se guarda la petición
    fecha_inicio DATE NOT NULL,         -- Fecha de inicio del servicio
    fecha_fin DATE NOT NULL,            -- Fecha de fin del servicio (si es un solo día, será igual a fecha_inicio)
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    actualizado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (intencion_id) REFERENCES intencion(id)
);



-- ----------------------------------------------------------------------------------------------
-- DATOS DE PRUEBA
INSERT INTO intencion (nombre, descripcion) VALUES
('Acción de Gracias', 'Intención ofrecida para agradecer a Dios por favores recibidos, bendiciones, logros o acontecimientos especiales.'),
('Salud', 'Intención dirigida a pedir por la recuperación o el bienestar físico, mental o espiritual de una persona.'),
('Aniversario', 'Intención ofrecida para conmemorar un aniversario de matrimonio, ordenación, fallecimiento u otro acontecimiento importante.'),
('Difunto', 'Intención dedicada al eterno descanso del alma de una persona fallecida.')
;

INSERT INTO peticiones (por_quien, intencion_id, descripcion, fecha_registro, fecha_inicio, fecha_fin)
VALUES
('Mercedes Salcedo', 2, 'Oración por su pronta recuperación', '2025-06-10', '2025-06-15', '2025-06-15'),
('José Ignacio López', 1, 'Agradecimiento por su cumpleaños número 50', '2025-06-12', '2025-06-18', '2025-06-18'),
('Matrimonio Pérez-Rodríguez', 3, '25 años de casados', '2025-06-05', '2025-06-20', '2025-06-20'),
('Papa Benedicto XVI', 4, 'Por el eterno descanso de su alma', '2025-06-01', '2025-06-16', '2025-06-16'),
('Padre Benito Ramírez', 2, 'Por su salud y ministerio sacerdotal', '2025-06-08', '2025-06-17', '2025-06-17'),
('Carmen Cecilia Ortega', 1, 'Agradecimiento por favores recibidos', '2025-06-13', '2025-06-22', '2025-06-22'),
('Fernando Rodríguez Mano', 4, 'Por su fallecimiento reciente', '2025-06-11', '2025-06-23', '2025-06-23');
