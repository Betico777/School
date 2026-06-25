# School – Sistema de Gestión Escolar

Aplicación web construida con **Laravel 13**, **Livewire 4** y **Flux UI**.

---

## Requisitos previos

Instala estas herramientas antes de comenzar:

| Herramienta | Versión mínima | Descarga |
|---|---|---|
| PHP | 8.3 | https://www.php.net/downloads |
| Composer | 2.x | https://getcomposer.org/download |
| Node.js | 20.19.0+ | https://nodejs.org |
| npm | 10.x o superior | (incluido con Node.js) |
| PostgreSQL (opcional) | 14/15/18 | https://www.postgresql.org/download/ |
| Git | — | https://git-scm.com/downloads |

> **Verificar instalaciones:**
> ```bash
> php -v
> composer -V
> node -v
> npm -v
> git --version
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

### 4. Crear el archivo de entorno

```bash
cp .env.example .env
```

### 5. Generar la clave de la aplicación

```bash
php artisan key:generate
```

### 6. Configurar la base de datos

El proyecto puede usar **SQLite** por defecto o **PostgreSQL**.

#### Opción A: SQLite (configuración por defecto)

En `.env` deja:

```env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

Si quieres usar SQLite, crea el archivo si no existe:

```bash
mkdir -p database
copy NUL database\database.sqlite
```

#### Opción B: PostgreSQL

En `.env` configura tu conexión PostgreSQL:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=school
DB_USERNAME=postgres
DB_PASSWORD=tu_contraseña
```

> Si usas PostgreSQL, asegúrate de que la base de datos `school` ya exista en tu servidor.

### 7. Ejecutar migraciones

```bash
php artisan migrate
```

### 8. Cargar los datos iniciales (seeders)

```bash
php artisan db:seed
```

Esto crea automáticamente:
- Roles: `admin`, `profesor`, `estudiante`
- Cursos del 1er al 6to Grado
- Materias básicas
- Usuario administrador por defecto:
  - Email: `admin@school.com`
  - Contraseña: `Admin@1234`

> Si necesitas reiniciar todo y cargar los seeders nuevamente:
> ```bash
> php artisan migrate:fresh --seed
> ```

### 9. Crear el enlace de almacenamiento público

```bash
php artisan storage:link
```

---

## Arrancar el proyecto

Necesitas dos terminales abiertas al mismo tiempo.

**Terminal 1 — Servidor Laravel:**
```bash
php artisan serve
```

**Terminal 2 — Vite para frontend:**
```bash
npm run dev
```

Luego abre el navegador en:

- `http://127.0.0.1:8000`

Si `php artisan serve` falla, usa este comando alternativo:

```bash
php -S 127.0.0.1:8000 -t public
```

---

## Comandos rápidos (resumen)

```bash
git clone https://github.com/TU_USUARIO/NOMBRE_REPO.git
cd NOMBRE_REPO
composer install
npm install
cp .env.example .env
php artisan key:generate
# Elegir conexión SQLite o PostgreSQL en .env
php artisan migrate
php artisan db:seed
php artisan storage:link
php artisan serve   # en una terminal
npm run dev         # en otra terminal
```

---

## Notas importantes

- `node_modules`, `vendor`, `.env` y archivos temporales ya están en `.gitignore`.
- Para producción, compila los assets con:
  ```bash
  npm run build
  ```
- Si usas PostgreSQL y la app no conecta, limpia la caché de configuración:
  ```bash
  php artisan config:clear
  ```
- El usuario admin por defecto es:
  - Email: `admin@school.com`
  - Contraseña: `Admin@1234`

---

## Si necesitas verificar el usuario admin en la base de datos

En PostgreSQL puedes ejecutar:

```sql
SELECT email FROM users WHERE email = 'admin@school.com';
```

En SQLite, puedes usar cualquier cliente SQLite para abrir `database/database.sqlite`.
