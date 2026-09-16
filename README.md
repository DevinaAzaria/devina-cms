# Devina CMS

A lightweight, reusable public-content CMS created and maintained by **DevinaAzaria**.

Devina CMS is designed for products that need manageable public/editorial content while keeping product-specific business logic in a separate host application.

**Current version:** `0.1.0-dev` — functional foundation, pre-release.

## What v0.1 includes

- Pages, articles/news, and events
- Draft / publish state and scheduled publication
- Navigation locations
- Media metadata and controlled uploads
- SEO title and description
- Small session-based admin/editor UI
- Read-only public JSON API
- SQLite and MySQL/MariaDB persistence
- PHP library integration for host applications
- No runtime package dependencies

Devina CMS intentionally does **not** contain learning, commerce, booking, CRM, assessment, customer workflows, or other project-specific business logic.

## Architecture

```text
Host Product
├── Devina CMS       public/editorial
└── Host application domain/business logic
```

A host may integrate Devina CMS as a PHP library or consume its read-only API from another runtime.

## Quick start

Requires PHP 8.2+ with PDO and either SQLite or MySQL/MariaDB.

```bash
cp .env.example .env
export DEVINA_CMS_ADMIN_PASSWORD='a-long-random-password'
php bin/setup.php --email=admin@example.com --name='Admin'
php -S 127.0.0.1:8080 -t public public/router.php
```

Open Admin at `http://127.0.0.1:8080/admin/` and API health at `http://127.0.0.1:8080/health`.

See [`docs/QUICKSTART.md`](./docs/QUICKSTART.md), [`docs/API.md`](./docs/API.md), and [`docs/INTEGRATION.md`](./docs/INTEGRATION.md).

## First adopter

Planned production adoption: `DevinaHQ/olympiad-learning-system` as the public/editorial content layer for `ols.devina.id`.

OLS remains a separate application and keeps its olympiad-specific engines and business logic outside this repository.

## Security boundary

Never commit production `.env`, API keys, credentials, customer/user data, database dumps, or production backups. Uploaded files and runtime storage are ignored by Git.

See [`SECURITY.md`](./SECURITY.md).

## Licensing and attribution

Devina CMS is licensed under the **Apache License 2.0**. See [`LICENSE`](./LICENSE), [`NOTICE`](./NOTICE), and [`docs/LICENSING.md`](./docs/LICENSING.md).

Recommended adopter credit:

> Devina CMS — created and maintained by DevinaAzaria, licensed under Apache License 2.0.

## Contributing

See [`CONTRIBUTING.md`](./CONTRIBUTING.md).

---

Created and maintained by **DevinaAzaria**.
