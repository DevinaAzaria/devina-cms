# Quickstart

Devina CMS v0.1 is a small PHP 8.2+ content service with a built-in editorial admin UI and a read-only JSON API. It has no runtime package dependencies.

## Requirements

- PHP 8.2+
- PDO
- SQLite **or** MySQL/MariaDB
- `fileinfo` for media uploads
- Apache/Nginx/PHP-FPM or PHP's built-in server for local development

## Local setup with SQLite

```bash
cp .env.example .env
export DEVINA_CMS_ADMIN_PASSWORD='a-long-random-password'
php bin/setup.php --email=admin@example.com --name='Admin'
php -S 127.0.0.1:8080 -t public public/router.php
```

Then open:

- Admin: `http://127.0.0.1:8080/admin/`
- API health: `http://127.0.0.1:8080/health`
- Contents: `http://127.0.0.1:8080/api/v1/contents`

For Apache, `public/.htaccess` provides API rewrite rules when `mod_rewrite` and overrides are enabled.

## MySQL / MariaDB

Set:

```text
DEVINA_CMS_DSN=mysql:host=127.0.0.1;dbname=devina_cms;charset=utf8mb4
DEVINA_CMS_DB_USER=...
DEVINA_CMS_DB_PASSWORD=...
```

Then run `php bin/setup.php` once.

## Production layout

Point the web server document root at `public/`. Keep `storage/`, `.env`, database files and uploaded originals outside public access when possible.

Do not commit production `.env`, credentials, database dumps or user data.
