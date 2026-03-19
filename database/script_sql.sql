-- =============================================================================
-- Script SQL — Módulo Trabajadores
-- Base de datos: reto_tecnico
-- Motor:         MySQL 8+
-- Fecha:         2026-03-19
-- =============================================================================

CREATE DATABASE IF NOT EXISTS reto_tecnico
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE reto_tecnico;

-- -----------------------------------------------------------------------------
-- Tabla: cargos
-- -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS cargos (
    id         BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    nombre     VARCHAR(100)    NOT NULL,
    created_at TIMESTAMP       NULL DEFAULT NULL,
    updated_at TIMESTAMP       NULL DEFAULT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------------------
-- Tabla: proyectos
-- -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS proyectos (
    id          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    nombre      VARCHAR(150)    NOT NULL,
    descripcion TEXT            NULL,
    created_at  TIMESTAMP       NULL DEFAULT NULL,
    updated_at  TIMESTAMP       NULL DEFAULT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------------------
-- Tabla: trabajadores
-- -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS trabajadores (
    id          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    nombre      VARCHAR(100)    NOT NULL,
    apellido    VARCHAR(100)    NOT NULL,
    dni         VARCHAR(20)     NOT NULL,
    email       VARCHAR(150)    NULL,
    telefono    VARCHAR(20)     NULL,
    cargo_id    BIGINT UNSIGNED NOT NULL,
    proyecto_id BIGINT UNSIGNED NOT NULL,
    activo      TINYINT(1)      NOT NULL DEFAULT 1,
    created_at  TIMESTAMP       NULL DEFAULT NULL,
    updated_at  TIMESTAMP       NULL DEFAULT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY trabajadores_dni_unique   (dni),
    UNIQUE KEY trabajadores_email_unique (email),
    CONSTRAINT fk_trabajadores_cargo    FOREIGN KEY (cargo_id)    REFERENCES cargos    (id) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_trabajadores_proyecto FOREIGN KEY (proyecto_id) REFERENCES proyectos (id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================================================
-- Datos de ejemplo
-- =============================================================================

INSERT INTO cargos (nombre, created_at, updated_at) VALUES
    ('Desarrollador Backend',  NOW(), NOW()),
    ('Desarrollador Frontend', NOW(), NOW()),
    ('Diseñador UX/UI',        NOW(), NOW()),
    ('Analista de QA',         NOW(), NOW()),
    ('Project Manager',        NOW(), NOW()),
    ('DevOps Engineer',        NOW(), NOW()),
    ('Analista de Datos',      NOW(), NOW());

INSERT INTO proyectos (nombre, descripcion, created_at, updated_at) VALUES
    ('Portal Web Corporativo',   'Rediseño del portal web principal de la empresa.',         NOW(), NOW()),
    ('App Móvil de Ventas',      'Aplicación móvil para el equipo de ventas externo.',       NOW(), NOW()),
    ('Sistema ERP Interno',      'Módulos de gestión interna de recursos empresariales.',    NOW(), NOW()),
    ('Plataforma E-commerce',    'Tienda en línea con integración de pasarelas de pago.',    NOW(), NOW()),
    ('Data Warehouse Reporting', 'Centralización y análisis de datos operativos.',           NOW(), NOW());

INSERT INTO trabajadores (nombre, apellido, dni, email, telefono, cargo_id, proyecto_id, activo, created_at, updated_at) VALUES
    ('Carlos', 'Ramírez', '12345678', 'c.ramirez@empresa.com', '987654321', 1, 1, 1, NOW(), NOW()),
    ('Ana',    'Torres',  '23456789', 'a.torres@empresa.com',  '976543210', 2, 1, 1, NOW(), NOW()),
    ('Luis',   'Mendoza', '34567890', 'l.mendoza@empresa.com', '965432109', 5, 2, 1, NOW(), NOW()),
    ('María',  'García',  '45678901', 'm.garcia@empresa.com',  '954321098', 3, 4, 1, NOW(), NOW()),
    ('Pedro',  'Quispe',  '56789012', 'p.quispe@empresa.com',  '943210987', 4, 3, 0, NOW(), NOW());
