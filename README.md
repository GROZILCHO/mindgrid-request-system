# MindGrid Request System

Reusable WordPress plugin foundation for MindGrid Studio request workflows.

## Sprint 1 Scope

- Plugin bootstrap with version constant `MGRS_VERSION`.
- PHP namespace `MindGrid\RequestSystem`.
- No-Composer PSR-4-style autoloader for `includes/`.
- Admin-only custom post type storage using `mgrs_request`.
- Meta-based request status registry using `_mgrs_status`.
- Top-level WordPress admin menu: `MindGrid Requests`.
- Basic admin list columns for Request ID, Status, and Date.
- Safe activation/deactivation hooks with rewrite flushing only.

## Requirements

- PHP 8.0 or newer.
- WordPress 6.4 or newer.

## Out of Scope for v0.1.0

No frontend form, shortcode, block, uploads, email, exports, settings page, custom database tables, REST API, Composer, npm, external services, or global frontend assets are included in Sprint 1.

## Request Flow Shortcode

The Smart Request Flow shortcode is:

```text
[mindgrid_request_flow]
```

As of Sprint 6, the shortcode renders a Bulgarian five-step demo flow for the Mestimvsichko moving/transport use case with a demo-only indicative estimate preview. It submits through WordPress `admin-post.php`; successful submissions create `mgrs_request` records and store approved reusable metadata plus a grouped plain-text submission summary. Frontend assets load only when the shortcode is present.

The Sprint 6 estimate is demo/client-discussion ready, not final pricing, a production calculator, or a legally binding quote. It does not use REST, AJAX, uploads, email, external services, payments, Google Maps, AI, calendar booking, user accounts, settings, builder UI, or custom database tables.
