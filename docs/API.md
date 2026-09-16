# Public API v1

The v0.1 API is intentionally read-only. Editorial writes happen through the authenticated admin UI or directly through the PHP repository layer inside a trusted host application.

## Health

`GET /health`

## Published content collection

`GET /api/v1/contents`

Query parameters:

- `type`: `page`, `article`, or `event` (optional)
- `limit`: 1–100 (default 20)
- `offset`: non-negative integer

Drafts and future-scheduled content are never returned.

## Published content by slug

`GET /api/v1/content/{type}/{slug}`

## Navigation

`GET /api/v1/navigation/{location}`

Only visible items are returned, ordered by position.

## Media metadata

`GET /api/v1/media/{id}`

The response includes a public `url` for the media proxy. The internal storage filename is not exposed.

## Body format

`body` is stored as Markdown/plain source. Rendering and sanitization belong to the consuming application's presentation layer. Devina CMS does not inject stored body text directly into public HTML.
