-- =============================================================================
-- SCHEMA SQL — Módulo de Trabajadores
-- Proyecto : reto_tecnico
-- Motor    : MySQL 8.0+
-- Fecha    : 2026-03-19
-- -----------------------------------------------------------------------------
-- INSTRUCCIONES DE USO:
--   Opción A (línea de comandos):
--     mysql -u root -p < database/script_sql.sql
--
--   Opción B (phpMyAdmin / DBeaver / MySQL Workbench):
--     Abrir este archivo, seleccionar todo y ejecutar.
--
--   El script es idempotente: puede ejecutarse varias veces sin error porque
--   usa CREATE TABLE IF NOT EXISTS e INSERT IGNORE.
-- =============================================================================

-- -----------------------------------------------------------------------------
-- 1. Crear / seleccionar la base de datos
-- -----------------------------------------------------------------------------
CREATE DATABASE IF NOT EXISTS reto_tecnico
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE reto_tecnico;

-- Desactivar temporalmente las foreign keys para poder recrear tablas
SET FOREIGN_KEY_CHECKS = 0;

-- -----------------------------------------------------------------------------
-- 2. Tabla: cargos
--    Catálogo de tipos de cargo que puede tener un trabajador.
-- -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS cargos (
    id         BIGINT UNSIGNED  NOT NULL AUTO_INCREMENT  COMMENT 'Clave primaria',
    nombre     VARCHAR(100)     NOT NULL                 COMMENT 'Nombre del cargo',
    created_at TIMESTAMP        NULL DEFAULT NULL,
    updated_at TIMESTAMP        NULL DEFAULT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci
  COMMENT='Catálogo de cargos';

-- -----------------------------------------------------------------------------
-- 3. Tabla: proyectos
--    Catálogo de proyectos a los que se puede asignar un trabajador.
-- -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS proyectos (
    id          BIGINT UNSIGNED  NOT NULL AUTO_INCREMENT  COMMENT 'Clave primaria',
    nombre      VARCHAR(150)     NOT NULL                 COMMENT 'Nombre del proyecto',
    descripcion TEXT             NULL                     COMMENT 'Descripción opcional',
    created_at  TIMESTAMP        NULL DEFAULT NULL,
    updated_at  TIMESTAMP        NULL DEFAULT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci
  COMMENT='Catálogo de proyectos';

-- -----------------------------------------------------------------------------
-- 4. Tabla: trabajadores
--    Registro principal de empleados.
--    - cargo_id    → FK a cargos(id)
--    - proyecto_id → FK a proyectos(id)
--    - activo      → baja lógica (1 = activo, 0 = inactivo)
-- -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS trabajadores (
    id          BIGINT UNSIGNED  NOT NULL AUTO_INCREMENT  COMMENT 'Clave primaria',
    nombre      VARCHAR(100)     NOT NULL                 COMMENT 'Nombre del trabajador',
    apellido    VARCHAR(100)     NOT NULL                 COMMENT 'Apellido del trabajador',
    dni         VARCHAR(20)      NOT NULL                 COMMENT 'Documento de identidad (único)',
    email       VARCHAR(150)     NULL                     COMMENT 'Correo electrónico (único, opcional)',
    telefono    VARCHAR(20)      NULL                     COMMENT 'Teléfono de contacto',
    cargo_id    BIGINT UNSIGNED  NOT NULL                 COMMENT 'FK → cargos.id',
    proyecto_id BIGINT UNSIGNED  NOT NULL                 COMMENT 'FK → proyectos.id',
    activo      TINYINT(1)       NOT NULL DEFAULT 1       COMMENT '1 = activo, 0 = desactivado',
    created_at  TIMESTAMP        NULL DEFAULT NULL,
    updated_at  TIMESTAMP        NULL DEFAULT NULL,
    PRIMARY KEY (id),
    UNIQUE  KEY uq_trabajadores_dni   (dni),
    UNIQUE  KEY uq_trabajadores_email (email),
    CONSTRAINT fk_trabajadores_cargo
        FOREIGN KEY (cargo_id)    REFERENCES cargos    (id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_trabajadores_proyecto
        FOREIGN KEY (proyecto_id) REFERENCES proyectos (id)
        ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci
  COMMENT='Registro de trabajadores';

-- Reactivar las foreign keys
SET FOREIGN_KEY_CHECKS = 1;

-- =============================================================================
-- 5. Datos de ejemplo
-- =============================================================================

-- Cargos (INSERT IGNORE evita error si ya existen)
INSERT IGNORE INTO cargos (nombre, created_at, updated_at) VALUES
    ('Desarrollador Backend',  NOW(), NOW()),
    ('Desarrollador Frontend', NOW(), NOW()),
    ('Diseñador UX/UI',        NOW(), NOW()),
    ('Analista de QA',         NOW(), NOW()),
    ('Project Manager',        NOW(), NOW()),
    ('DevOps Engineer',        NOW(), NOW()),
    ('Analista de Datos',      NOW(), NOW());

-- Proyectos
INSERT IGNORE INTO proyectos (nombre, descripcion, created_at, updated_at) VALUES
    ('Portal Web Corporativo',   'Rediseño del portal web principal de la empresa.',       NOW(), NOW()),
    ('App Móvil de Ventas',      'Aplicación móvil para el equipo de ventas externo.',     NOW(), NOW()),
    ('Sistema ERP Interno',      'Módulos de gestión interna de recursos empresariales.',  NOW(), NOW()),
    ('Plataforma E-commerce',    'Tienda en línea con integración de pasarelas de pago.',  NOW(), NOW()),
    ('Data Warehouse Reporting', 'Centralización y análisis de datos operativos.',         NOW(), NOW());

-- Trabajadores
-- cargo_id y proyecto_id hacen referencia al orden de inserción anterior
-- (1=Backend, 2=Frontend, 3=UX, 4=QA, 5=PM | 1=Portal, 2=App, 3=ERP, 4=Ecomm, 5=DW)
INSERT IGNORE INTO trabajadores
    (nombre, apellido, dni,        email,                  telefono,    cargo_id, proyecto_id, activo, created_at, updated_at)
VALUES
    ('Carlos', 'Ramírez', '12345678', 'c.ramirez@empresa.com', '987654321', 1, 1, 1, NOW(), NOW()),
    ('Ana',    'Torres',  '23456789', 'a.torres@empresa.com',  '976543210', 2, 1, 1, NOW(), NOW()),
    ('Luis',   'Mendoza', '34567890', 'l.mendoza@empresa.com', '965432109', 5, 2, 1, NOW(), NOW()),
    ('María',  'García',  '45678901', 'm.garcia@empresa.com',  '954321098', 3, 4, 1, NOW(), NOW()),
    ('Pedro',  'Quispe',  '56789012', 'p.quispe@empresa.com',  '943210987', 4, 3, 0, NOW(), NOW());

-- =============================================================================
-- 6. Verificación rápida
-- =============================================================================
SELECT 'cargos'       AS tabla, COUNT(*) AS registros FROM cargos
UNION ALL
SELECT 'proyectos',              COUNT(*)              FROM proyectos
UNION ALL
SELECT 'trabajadores',           COUNT(*)              FROM trabajadores;

