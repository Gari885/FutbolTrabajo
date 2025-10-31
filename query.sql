-- ==========================================================
-- SCRIPT DE CREACIÓN DE BASE DE DATOS - PROYECTO ARTEAN
-- ==========================================================

-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS futbolstats
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;

USE futbolstats;

-- Tabla de equipos
CREATE TABLE equipos (
    id_equipo INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL UNIQUE,
    estadio VARCHAR(100) NOT NULL
);

-- Tabla de partidos
CREATE TABLE partidos (
    id_partido INT AUTO_INCREMENT PRIMARY KEY,
    id_local INT NOT NULL,
    id_visitante INT NOT NULL,
    jornada INT NOT NULL,
    resultado CHAR(1) CHECK (resultado IN ('1', 'X', '2')),
    estadio VARCHAR(100) NOT NULL,
    CONSTRAINT fk_local FOREIGN KEY (id_local) REFERENCES equipos(id_equipo)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_visitante FOREIGN KEY (id_visitante) REFERENCES equipos(id_equipo)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT uq_partido UNIQUE (id_local, id_visitante, jornada)
);

-- Datos de ejemplo (opcional)
INSERT INTO equipos (nombre, estadio) VALUES
('Athletic Club', 'San Mamés'),
('Real Sociedad', 'Reale Arena'),
('Osasuna', 'El Sadar'),
('Alavés', 'Mendizorroza');

INSERT INTO partidos (id_local, id_visitante, jornada, resultado, estadio) VALUES
(1, 2, 1, '1', 'San Mamés'),
(3, 4, 1, 'X', 'El Sadar'),
(2, 3, 2, '2', 'Reale Arena');
