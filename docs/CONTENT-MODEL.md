# Content Model

## Content

One small table supports three editorial types: `page`, `article`, and `event`.

Common fields include title, slug, excerpt, Markdown body, draft/published state, optional publication schedule, cover media reference, SEO title and SEO description.

Events additionally use `starts_at`, `ends_at` and `location`.

This model is intentionally editorial. Project-specific records such as OLS questions, assessments, mastery, bookings, orders or customer workflows must remain in the host application.

## Navigation

Navigation items are grouped by a string `location` such as `main`, `footer` or `student-help`. Each item has a label, URL, position and visibility flag.

## Media

Media stores metadata plus a randomized storage filename. v0.1 accepts JPEG, PNG, WebP, GIF and PDF uploads up to 8 MB through the admin UI.

## Users

The standalone editor supports `admin` and `editor` roles. v0.1 uses local password authentication for the CMS admin surface. Host-application SSO/auth adapters are planned for a later release; the OLS application must not reuse CMS admin sessions as student/application authorization.
