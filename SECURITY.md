# Security Policy

Devina CMS is intended to be safe to publish as source code. Security must not depend on hiding implementation details.

## Never commit

- passwords or password hashes copied from production;
- API keys, access tokens or private keys;
- `.env` files containing secrets;
- production database dumps;
- private client or user data;
- production backups;
- deployment credentials;
- licensed/private assets that are not redistributable.

Use environment variables or the host application's secret-management mechanism for runtime credentials.

## Authentication and authorization

A host application must enforce authorization on the server side for every protected action. Hiding controls in the UI is not authorization.

Devina CMS may provide generic editorial roles/capabilities, but a host application's business roles and permissions remain the responsibility of that host application.

## Reporting a vulnerability

Please avoid filing a public issue for an exploitable vulnerability. Contact the maintainer privately through an appropriate GitHub-supported private channel when available. Include reproduction steps, affected versions and likely impact.

## Supported versions

Until the first stable release, only the latest development line should be assumed to receive fixes. A formal support matrix will be introduced with stable versioning.
