# School – Sistema de Gestión Escolar

Aplicación web construida con **Laravel 13**, **Livewire 4** y **Flux UI**.

---

## Requisitos previos

Tener instalado lo siguiente antes de comenzar:

| Herramienta | Versión mínima | Descarga |
|---|---|---|
| PHP | 8.3 | https://www.php.net/downloads |
| Composer | 2.x | https://getcomposer.org/download |
| Node.js | 18.x | https://nodejs.org |
| npm | 9.x | (viene incluido con Node.js) |
| SQLite | — | Viene incluido en PHP (extensión `pdo_sqlite`) |
| Git | — | https://git-scm.com/downloads |

> **Verificar instalaciones:**
> ```bash
> php -v
> composer -V
> node -v
> npm -v
> ```

---

## Instalación paso a paso

### 1. Clonar el repositorio

```bash
git clone https://github.com/TU_USUARIO/NOMBRE_REPO.git
cd NOMBRE_REPO
```

### 2. Instalar dependencias de PHP

```bash
composer install
```

### 3. Instalar dependencias de JavaScript

```bash
npm install
```

### 4. Configurar el archivo de entorno

```bash
cp .env.example .env
```

### 5. Generar la clave de la aplicación

```bash
php artisan key:generate
```

### 6. Crear la base de datos y ejecutar las migraciones

El proyecto usa **SQLite** por defecto. El archivo se crea automáticamente al migrar.

```bash
php artisan migrate
```

### 7. Cargar los datos iniciales (seeders)

```bash
php artisan db:seed
```

Esto crea:
- Roles: `admin`, `profesor`, `estudiante`
- Cursos del 1er al 6to Grado
- Materias básicas (Matemáticas, Español, Ciencias, etc.)
- **Usuario administrador por defecto:**
  - Email: `admin@school.com`
  - Contraseña: `Admin@1234`

### 8. Crear el enlace de almacenamiento público

```bash
php artisan storage:link
```

---

## Arrancar el proyecto

Se necesitan **dos terminales** abiertas al mismo tiempo:

**Terminal 1 – Servidor Laravel:**
```bash
php artisan serve
```

**Terminal 2 – Compilar assets (Vite):**
```bash
npm run dev
```

Luego abrir el navegador en: **http://localhost:8000**

---

## Comandos rápidos (resumen)

```bash
git clone https://github.com/TU_USUARIO/NOMBRE_REPO.git
cd NOMBRE_REPO
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan storage:link
php artisan serve   # en una terminal
npm run dev         # en otra terminal
```

---

## Notas adicionales

- Si al migrar aparece un error de SQLite, verificar que la extensión `pdo_sqlite` esté habilitada en `php.ini`.
- Para producción, compilar los assets con `npm run build` en lugar de `npm run dev`.
- Nunca subir el archivo `.env` al repositorio (ya está en `.gitignore`).
