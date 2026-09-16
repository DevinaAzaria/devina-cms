# Adopting Devina CMS

Devina CMS is intended to be reused by projects owned by individuals, companies, or GitHub organizations.

## Basic model

An adopter should consume a released or otherwise pinned version of Devina CMS rather than copying the code into a project and diverging silently.

Target direction:

```text
DevinaAzaria/devina-cms
        │
        ├── v0.x / v1.x releases
        │
        ├── DevinaHQ/olympiad-learning-system
        ├── ClientOrgA/product
        └── OtherOrg/portal
```

The exact package/distribution mechanism will be introduced with the first implementation release.

## Credit

Apache License 2.0 requires preservation of applicable license and NOTICE information when redistributing the software or derivative distributions.

In addition to those legal requirements, adopters are encouraged to provide a human-readable technology credit in project documentation or third-party notices, for example:

> Public content layer powered by Devina CMS — created and maintained by DevinaAzaria.

A visible front-end credit is optional unless a separate agreement requires it.

## Recommended project documentation

An adopting project should record:

- the Devina CMS version or commit used;
- the upstream repository;
- any local modifications;
- required LICENSE/NOTICE attribution;
- integration-specific configuration that is safe to document.

Example:

```text
Content platform: Devina CMS
Upstream: DevinaAzaria/devina-cms
Version: v0.x.y
License: Apache-2.0
Local integration: project-specific adapter only
```

## Upgrade strategy

Projects should avoid modifying CMS core directly. Prefer adapters, configuration and extension hooks. This keeps upstream upgrades reviewable and reduces long-lived forks.

## OLS adoption

`DevinaHQ/olympiad-learning-system` is the planned first production adopter. OLS-specific learning, assessment, mastery, question-bank and competition logic remains in the OLS repository and is not part of Devina CMS.
