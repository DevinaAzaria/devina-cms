# Devina CMS

A lightweight, reusable public-content CMS created and maintained by **DevinaAzaria**.

Devina CMS is designed for websites that need a manageable public content layer while keeping application-specific business logic in a separate web application.

## Status

Early foundation / pre-release.

The first production adopter is planned to be **DevinaHQ / Olympiad Learning System (OLS)**.

## Goals

Devina CMS aims to provide a small, reusable content layer for:

- pages;
- articles / news;
- events;
- navigation;
- media metadata;
- SEO metadata;
- editorial workflow;
- simple admin/editor operations;
- extension hooks for host applications.

It is intentionally **not** intended to become a general-purpose replacement for WordPress or a place for project-specific business logic.

## Architecture principle

```text
Devina CMS
  ├── public/editorial content
  ├── admin/editor UI
  ├── content API / adapters
  └── extension hooks

Host application
  ├── authentication / RBAC
  ├── business workflows
  ├── transactions
  ├── domain data
  └── private integrations
```

A host project may use Devina CMS from a personal account, company account, or GitHub organization. Adoption does not require the project to belong to DevinaHQ.

## First adopter

Planned production adoption:

- `DevinaHQ/olympiad-learning-system` — public content layer for `ols.devina.id`

The OLS application itself remains a separate product and does not become part of this public CMS repository.

## Licensing

Devina CMS is licensed under the **Apache License 2.0**. See [`LICENSE`](./LICENSE) and [`NOTICE`](./NOTICE).

Organizations that redistribute Devina CMS or derivative distributions must preserve the notices required by the Apache License 2.0. Projects may additionally provide a visible technology credit, for example:

> Public content layer powered by Devina CMS — created and maintained by DevinaAzaria.

See [`docs/ADOPTION.md`](./docs/ADOPTION.md) and [`docs/LICENSING.md`](./docs/LICENSING.md).

## Security

Do not commit secrets, API keys, production credentials, private client data, database dumps, or production backups to this repository.

See [`SECURITY.md`](./SECURITY.md).

## Contributing

See [`CONTRIBUTING.md`](./CONTRIBUTING.md).

---

Created and maintained by **DevinaAzaria**.
