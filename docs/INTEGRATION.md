# Host Application Integration

Devina CMS can be adopted in two ways.

## 1. PHP library mode

```php
require '/path/to/devina-cms/bootstrap.php';

$cms = new DevinaCms\Cms();
$articles = $cms->contents->published('article', 10);
$mainNav = $cms->navigation->all('main', true);
```

The host application owns templates, routing, Markdown rendering, CSP, page design and business logic.

## 2. Service/API mode

Deploy Devina CMS behind a path or internal service and consume its read-only API from another runtime. This is useful when the host application is not PHP.

Typical integration:

```text
example.com/             -> host public frontend
example.com/articles     -> host renders Devina CMS article data
example.com/login        -> host application auth
example.com/app/*        -> host business application
example.com/cms-admin/*  -> Devina CMS editorial admin (restricted)
```

## Boundary

Devina CMS owns editorial content only. The consuming application owns authentication for its end users, domain records, transactions, business rules, private integrations and sensitive customer data.

For DevinaHQ/OLS, Devina CMS is credited as an upstream dependency; OLS remains the owner of all olympiad-specific application logic.
