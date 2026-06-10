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
