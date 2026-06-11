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

The plugin does not register frontend routes, frontend assets, archives, single views, shortcodes, blocks, or REST endpoints.

## Sprint 2 Notes

- Request IDs are computed from the WordPress post ID as `MRS-{post_id}`.
- Request entity fields are stored only in approved post meta keys.
- Created source is read-only after creation and defaults to `manual_admin` for manual admin-created requests.
- Sprint 2 remains admin-only and does not introduce custom roles.
