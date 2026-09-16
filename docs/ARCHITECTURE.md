# Devina CMS — Architecture

Status: `0.1.0-dev` functional foundation / pre-release.

## Purpose

Devina CMS is a reusable public-content layer for products that also have their own application logic. It stays deliberately small so a personal project, company, or GitHub organization can adopt it without coupling business-domain data to CMS internals.

## v0.1 runtime choice

The reference implementation uses **dependency-free PHP 8.2+** with PDO.

Why this baseline:

- deployable on ordinary shared hosting as well as VPS/container environments;
- no Node or package-manager runtime required in production;
- SQLite for small/local deployments;
- MySQL/MariaDB for typical hosted production deployments;
- easy to embed directly in a PHP product;
- still usable by non-PHP products through the read-only JSON API.

## Components

```text
Devina CMS
├── src/                  generic core and repositories
├── public/admin/         small editorial UI
├── public/index.php      public read-only API
├── public/media.php      controlled media proxy
├── bin/setup.php         schema + first admin bootstrap
└── storage/              runtime data; not source-controlled
```

## Editorial responsibilities

Devina CMS owns pages, articles/news, events, navigation, media metadata/uploads, SEO metadata, draft/publish state, scheduled publication, CMS editor/admin operations, and public content delivery interfaces.

The host application owns end-user authentication/RBAC, transactions, domain workflows, private integrations, project-specific business rules/analytics, secrets and production configuration.

## Integration modes

### Library mode

A PHP host loads `bootstrap.php` and uses the repository facade directly. The host owns routes and presentation.

### Service/API mode

A non-PHP or separately deployed host consumes the public read-only API. Editorial writes still happen in the CMS admin surface or a trusted server-side integration.

## Content rendering boundary

Content `body` is stored as Markdown/plain source. Devina CMS v0.1 does not render stored body source into public HTML. The consuming product chooses its Markdown renderer and sanitization/CSP strategy.

## Authentication boundary

The built-in `admin` / `editor` accounts authenticate CMS operators only. They are not application users. A host such as OLS must keep student/mentor/admin product authorization separate from CMS editorial sessions.

## Portability rule

The CMS must not assume that the adopter belongs to DevinaHQ, uses a specific domain, uses OLS roles/schemas, mounts the CMS at `/`, or shares another adopter's database/frontend stack.

## Versioning

Semantic versioning begins with packaged releases. Before `1.0.0`, contracts may evolve, but breaking changes must be documented in `CHANGELOG.md` and migration notes.

## Security model

Security must not rely on source secrecy. Source may contain authentication and authorization implementation, but never production credentials or private state. Production deployments should enforce HTTPS, least privilege, secure secret storage, database backups outside the web root, server-level request/rate controls, and an appropriate CSP in the host product.
