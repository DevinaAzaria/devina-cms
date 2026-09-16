# Contributing to Devina CMS

Devina CMS is an early-stage public project. Contributions should preserve its main goal: a small, reusable public-content CMS that can be embedded into different host applications without absorbing their business logic.

## Before contributing

Please keep these boundaries in mind:

- generic CMS capability belongs here;
- project-specific workflows belong in the host application;
- secrets, private client data and production configuration never belong in this repository;
- avoid dependencies that materially increase runtime or operational complexity without a clear need;
- preserve backward compatibility when practical and document breaking changes.

## Suggested workflow

1. Open or reference an issue for non-trivial changes.
2. Work in a branch.
3. Add or update tests/documentation where relevant.
4. Open a pull request with the problem, approach and compatibility impact.
5. Keep commits focused and avoid unrelated formatting churn.

## Licensing of contributions

Unless explicitly stated otherwise, contributions intentionally submitted for inclusion in Devina CMS are provided under the Apache License 2.0, consistent with the repository license.

## Security issues

Do not disclose exploitable security vulnerabilities in a public issue. Follow `SECURITY.md`.
