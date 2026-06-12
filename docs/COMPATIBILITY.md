# Compatibility

## Runtime

- Minimum PHP: 8.0
- Target PHP: 8.2
- Minimum WordPress: 6.4
- Target WordPress: current stable

## PHP Constraints

The plugin avoids PHP 8.1+ and PHP 8.2-only language features. Code is written for PHP 8.0 compatibility.

## WordPress Constraints

The plugin uses standard WordPress APIs for custom post types, post meta, admin menus, metaboxes, list table columns, admin filters, activation hooks, and deactivation hooks.

## Frontend

The plugin registers the `[mindgrid_request_flow]` shortcode and conditionally loads its frontend CSS/JS only when the shortcode is present. It does not register frontend routes, request archives, request single views, blocks, or REST endpoints.

## Sprint 2 Notes

- Request IDs are computed from the WordPress post ID as `MRS-{post_id}`.
- Request entity fields are stored only in approved post meta keys.
- Created source is read-only after creation and defaults to `manual_admin` for manual admin-created requests.
- Sprint 2 remains admin-only and does not introduce custom roles.

## Sprint 5 Notes

- The public flow is a Bulgarian Mestimvsichko demo draft.
- The submission engine still uses standard POST and `admin-post.php`.
- The plugin does not add uploads, email, pricing, booking, maps, AI, payments, settings, builder UI, custom roles, or external dependencies.

## Sprint 6 Notes

- The estimate preview is demo-only and uses hardcoded local rules.
- The frontend preview uses existing vanilla JavaScript only.
- The server recalculates the estimate before saving the summary.
- No Google Maps, Stripe, AI, external APIs, admin pricing settings, database tables, or new dependencies are introduced.
