# Módulo de Trabajadores — Backend API REST

API REST construida con **Laravel 12** y **MySQL** que expone endpoints JSON para gestionar el módulo de trabajadores: listar, registrar, editar, ver detalle, desactivar y reactivar trabajadores.

---

## Tabla de contenidos

1. [Requisitos previos](#1-requisitos-previos)
2. [Clonar o descargar el proyecto](#2-clonar-o-descargar-el-proyecto)
3. [Configurar variables de entorno](#3-configurar-variables-de-entorno)
4. [Instalar dependencias](#4-instalar-dependencias)
5. [Importar la base de datos](#5-importar-la-base-de-datos)
6. [Generar la clave de aplicación](#6-generar-la-clave-de-aplicación)
7. [Levantar el servidor de desarrollo](#7-levantar-el-servidor-de-desarrollo)
8. [Endpoints disponibles](#8-endpoints-disponibles)
9. [Ejemplos de peticiones y respuestas](#9-ejemplos-de-peticiones-y-respuestas)
10. [Validaciones aplicadas](#10-validaciones-aplicadas)
11. [Estructura del proyecto](#11-estructura-del-proyecto)
12. [Solución de problemas comunes](#12-solución-de-problemas-comunes)

---

## 1. Requisitos previos

Antes de comenzar, asegúrese de tener instalado lo siguiente:

| Herramienta | Versión mínima | Verificar con |
|---|---|---|
| PHP | 8.2 | `php -v` |
| Composer | 2.x | `composer -V` |
| MySQL | 8.0 | `mysql --version` |
| Git | cualquiera | `git --version` |

> **Extensiones PHP requeridas:** `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`.
> En Windows con XAMPP o Laragon estas extensiones ya vienen habilitadas por defecto.

---

## 2. Clonar o descargar el proyecto

### Opción A — Con Git

```bash
git clone <URL-del-repositorio> reto_tecnico
cd reto_tecnico
```

### Opción B — Descarga ZIP

1. Descargar el ZIP del repositorio.
2. Extraer la carpeta.
3. Abrir una terminal dentro de la carpeta extraída.

---

## 3. Configurar variables de entorno

Copiar el archivo de ejemplo y editarlo:

```bash
# Linux / macOS
cp .env.example .env

# Windows (PowerShell)
Copy-Item .env.example .env
```

Abrir `.env` y ajustar el bloque de base de datos:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=reto_tecnico
DB_USERNAME=root
DB_PASSWORD=tu_contraseña
```

> Si usa XAMPP la contraseña suele estar vacía (`DB_PASSWORD=`).
> Si usa Laragon la contraseña por defecto también es vacía.

---

## 4. Instalar dependencias

```bash
composer install
```

### Nota especial para Windows con OneDrive

Si la carpeta del proyecto está dentro de **OneDrive**, es necesario quitar el atributo de solo lectura que OneDrive aplica a los directorios. Ejecutar esto **desde cmd.exe** (no PowerShell):

```cmd
attrib -R "bootstrap\cache" /S /D
attrib -R "storage" /S /D
```

Esto es necesario porque PHP verifica el atributo de solo lectura de Windows para determinar si un directorio es escribible. Sin este paso, `composer install` y `php artisan` fallarán con el error `bootstrap\cache directory must be present and writable`.

---

## 5. Importar la base de datos

El proyecto incluye el script `database/script_sql.sql` que crea la base de datos, las tres tablas y carga los datos de ejemplo en un solo paso.

### Opción A — phpMyAdmin (recomendado para XAMPP/Laragon)

1. Abrir **phpMyAdmin** en el navegador (`http://localhost/phpmyadmin`).
2. Ir a la pestaña **Importar**.
3. Hacer clic en **Seleccionar archivo** y elegir `database/script_sql.sql`.
4. Clic en **Continuar**.

### Opción B — Línea de comandos

```bash
mysql -u root -p < database/script_sql.sql
```

> Al terminar la importación verá una tabla de verificación con el conteo de registros:
>
> | tabla | registros |
> |---|---|
> | cargos | 7 |
> | proyectos | 5 |
> | trabajadores | 5 |

---

## 6. Generar la clave de aplicación

```bash
php artisan key:generate
```

---

## 7. Levantar el servidor de desarrollo

```bash
php artisan serve
```

La API quedará disponible en: **`http://127.0.0.1:8000`**

Para especificar un puerto diferente:

```bash
php artisan serve --port=8080
```

---

## 8. Endpoints disponibles

Todas las rutas tienen el prefijo `/api`.

| Método | Endpoint | Descripción |
|---|---|---|
| `GET` | `/api/trabajadores` | Listar todos los trabajadores |
| `POST` | `/api/trabajadores` | Registrar un nuevo trabajador |
| `GET` | `/api/trabajadores/{id}` | Ver detalle de un trabajador |
| `PUT` | `/api/trabajadores/{id}` | Editar un trabajador |
| `DELETE` | `/api/trabajadores/{id}` | Desactivar (baja lógica) un trabajador |
| `PATCH` | `/api/trabajadores/{id}/restaurar` | Reactivar un trabajador desactivado |
| `GET` | `/api/cargos` | Listar todos los cargos |
| `GET` | `/api/proyectos` | Listar todos los proyectos |

> **Importante:** `DELETE` no elimina el registro físicamente. Cambia `activo = false` (baja lógica). El trabajador permanece en la base de datos y puede reactivarse con `PATCH /restaurar`.

---

## 9. Ejemplos de peticiones y respuestas

> Se recomienda probar con **Postman**. Siempre incluir el header `Accept: application/json`.

---

### GET /api/trabajadores

**Response `200 OK`:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "nombre": "Carlos",
      "apellido": "Ramírez",
      "nombre_completo": "Ramírez, Carlos",
      "dni": "12345678",
      "email": "c.ramirez@empresa.com",
      "telefono": "987654321",
      "cargo_id": 1,
      "cargo": "Desarrollador Backend",
      "proyecto_id": 1,
      "proyecto": "Portal Web Corporativo",
      "activo": true,
      "created_at": "19/03/2026 10:00",
      "updated_at": "19/03/2026 10:00"
    }
  ]
}
```

---

### POST /api/trabajadores

**Headers:**
```
Content-Type: application/json
Accept: application/json
```

**Body (raw JSON):**
```json
{
  "nombre":      "Laura",
  "apellido":    "Pérez",
  "dni":         "77889900",
  "email":       "l.perez@empresa.com",
  "telefono":    "912345678",
  "cargo_id":    2,
  "proyecto_id": 3
}
```

**Response `201 Created`:**
```json
{
  "success": true,
  "message": "Trabajador registrado correctamente.",
  "data": {
    "id": 6,
    "nombre": "Laura",
    "apellido": "Pérez",
    "nombre_completo": "Pérez, Laura",
    "dni": "77889900",
    "email": "l.perez@empresa.com",
    "telefono": "912345678",
    "cargo_id": 2,
    "cargo": "Desarrollador Frontend",
    "proyecto_id": 3,
    "proyecto": "Sistema ERP Interno",
    "activo": true,
    "created_at": "19/03/2026 10:05",
    "updated_at": "19/03/2026 10:05"
  }
}
```

---

### GET /api/trabajadores/{id}

**Response `200 OK`:** igual al objeto individual del listado.

---

### PUT /api/trabajadores/{id}

**Body (raw JSON):**
```json
{
  "nombre":      "Carlos",
  "apellido":    "Ramírez Vega",
  "dni":         "12345678",
  "email":       "c.ramirez@empresa.com",
  "telefono":    "999888777",
  "cargo_id":    1,
  "proyecto_id": 2,
  "activo":      true
}
```

**Response `200 OK`:**
```json
{
  "success": true,
  "message": "Trabajador actualizado correctamente.",
  "data": { "..." }
}
```

---

### DELETE /api/trabajadores/{id}

**Response `200 OK`:**
```json
{
  "success": true,
  "message": "Trabajador desactivado correctamente."
}
```

---

### PATCH /api/trabajadores/{id}/restaurar

**Response `200 OK`:**
```json
{
  "success": true,
  "message": "Trabajador reactivado correctamente."
}
```

---

### Response de error de validación `422`

```json
{
  "success": false,
  "message": "Error de validación.",
  "errors": {
    "dni": ["El DNI ya está registrado."],
    "email": ["El correo electrónico no tiene un formato válido."]
  }
}
```

---

## 10. Validaciones aplicadas

### Al registrar — POST /api/trabajadores

| Campo | Reglas |
|---|---|
| `nombre` | Requerido, texto, máx. 100 caracteres |
| `apellido` | Requerido, texto, máx. 100 caracteres |
| `dni` | Requerido, máx. 20 caracteres, **único** en la tabla |
| `email` | Opcional, formato email válido, **único** en la tabla |
| `telefono` | Opcional, máx. 20 caracteres |
| `cargo_id` | Requerido, entero, debe **existir** en tabla `cargos` |
| `proyecto_id` | Requerido, entero, debe **existir** en tabla `proyectos` |

### Al editar — PUT /api/trabajadores/{id}

Las mismas reglas anteriores. Para `dni` y `email`, la validación de unicidad ignora el registro actual (para no bloquearse a sí mismo al editar sin cambiar el valor).

Campo adicional:

| Campo | Reglas |
|---|---|
| `activo` | Opcional, booleano (`true` / `false`) |

---

## 11. Estructura del proyecto

```
reto_tecnico/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── TrabajadorController.php    ← CRUD completo de trabajadores
│   │   │   ├── CargoController.php         ← Listar cargos
│   │   │   └── ProyectoController.php      ← Listar proyectos
│   │   └── Requests/
│   │       ├── StoreTrabajadorRequest.php  ← Validación al crear
│   │       └── UpdateTrabajadorRequest.php ← Validación al editar
│   └── Models/
│       ├── Trabajador.php                  ← Relaciones con Cargo y Proyecto
│       ├── Cargo.php
│       └── Proyecto.php
├── database/
│   └── script_sql.sql                      ← Script SQL (tablas + datos de ejemplo)
├── routes/
│   ├── api.php                             ← Todas las rutas de la API
│   └── web.php
├── bootstrap/
│   └── app.php                             ← Registro de rutas API
├── .env                                    ← Variables de entorno (no subir a Git)
└── .env.example                            ← Plantilla de variables de entorno
```

---

## 12. Solución de problemas comunes

### `bootstrap/cache directory must be present and writable`

Ocurre en Windows cuando el proyecto está en OneDrive. Ejecutar en **cmd.exe**:

```cmd
attrib -R "bootstrap\cache" /S /D
attrib -R "storage" /S /D
```

---

### `php artisan key:generate` no encuentra `.env`

```powershell
Copy-Item .env.example .env
```

---

### Error de conexión a la base de datos

1. Verificar que MySQL esté corriendo (en XAMPP: panel → Start MySQL).
2. Revisar `DB_HOST`, `DB_PORT`, `DB_USERNAME` y `DB_PASSWORD` en el `.env`.
3. Confirmar que la base de datos `reto_tecnico` existe.

---

### `SQLSTATE[HY000] [1049] Unknown database 'reto_tecnico'`

La base de datos no existe. Crearla antes de migrar:

```sql
CREATE DATABASE reto_tecnico CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

---

### Error 404 en las rutas `/api/...`

Asegurarse de que el servidor esté corriendo con `php artisan serve` y de que la URL base sea `http://127.0.0.1:8000`.

---

### Las respuestas llegan como HTML en lugar de JSON

Agregar el header en Postman o en el cliente HTTP:

```
Accept: application/json
```

---

## Datos de ejemplo incluidos

Tras ejecutar el seeder (o importar el SQL), la base de datos contendrá:

**Cargos (7):**
Desarrollador Backend, Desarrollador Frontend, Diseñador UX/UI, Analista de QA, Project Manager, DevOps Engineer, Analista de Datos.

**Proyectos (5):**
Portal Web Corporativo, App Móvil de Ventas, Sistema ERP Interno, Plataforma E-commerce, Data Warehouse Reporting.

**Trabajadores (5):**

| # | Nombre | Cargo | Proyecto | Activo |
|---|---|---|---|---|
| 1 | Carlos Ramírez | Desarrollador Backend | Portal Web Corporativo | Sí |
| 2 | Ana Torres | Desarrollador Frontend | Portal Web Corporativo | Sí |
| 3 | Luis Mendoza | Project Manager | App Móvil de Ventas | Sí |
| 4 | María García | Diseñador UX/UI | Plataforma E-commerce | Sí |
| 5 | Pedro Quispe | Analista de QA | Sistema ERP Interno | No |

