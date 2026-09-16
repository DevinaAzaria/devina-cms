# Devina CMS — Architecture Baseline

Status: foundation / pre-release

## Purpose

Devina CMS is a reusable public-content layer for projects that also have their own application logic.

It should stay small enough to embed into products owned by individuals, companies or GitHub organizations without forcing the host product to adopt CMS-specific assumptions for its business domain.

## Responsibilities

Devina CMS is responsible for generic editorial concerns such as:

- pages;
- articles/news;
- events;
- navigation;
- media metadata;
- SEO metadata;
- publication state;
- editor/admin operations;
- generic content delivery interfaces;
- extension points for host projects.

The host application remains responsible for:

- end-user authentication and product RBAC;
- transactions;
- learning, commerce, booking, CRM or other domain workflows;
- private integrations;
- project-specific business rules;
- domain-specific analytics;
- project secrets and production configuration.

## Integration model

```text
                       Host Product
                 ┌──────────┴──────────┐
                 ▼                     ▼
          Devina CMS layer       Host application
          public/editorial       domain/business logic
                 │                     │
                 └──────────┬──────────┘
                            ▼
                    shared delivery surface
```

A project may expose both layers on one domain, for example:

```text
example.com/             public content
example.com/articles     CMS content
example.com/events       CMS content
example.com/login        host application
example.com/dashboard    host application
```

## Portability rule

The CMS core must not assume that:

- the adopter belongs to DevinaHQ;
- the adopter uses a particular company domain;
- the adopter uses OLS-specific roles or schemas;
- the adopter exposes the CMS on the site root;
- the host application's database schema is identical to another adopter's schema.

## Data boundary

Generic CMS records may include:

- content identity;
- slug/path;
- title/body/summary;
- type;
- publication state;
- author/editor references;
- publish timestamps;
- navigation metadata;
- SEO metadata;
- media references;
- version/revision metadata.

Private application data should not be pushed into generic CMS tables merely because the CMS already has persistence.

## Extension boundary

Host projects should integrate through documented APIs, adapters or extension hooks rather than editing CMS core files directly whenever practical.

This enables a project to upgrade from one Devina CMS version to another without repeatedly reconciling local edits.

## Versioning direction

Devina CMS will use semantic versioning once packaged releases begin:

- patch: compatible fixes;
- minor: backward-compatible features;
- major: breaking contracts or migrations.

Before `1.0.0`, APIs may still evolve quickly; breaking changes should nevertheless be documented clearly.

## Security model

Security must not rely on source secrecy. Public source may contain authentication and authorization implementation patterns, but no production credentials or private state.

Host applications must apply least privilege, server-side authorization, secure secret storage and secure session handling appropriate to their deployment.
