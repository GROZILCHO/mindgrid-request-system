# Compatibility

## Runtime

- Minimum PHP: 8.0
- Target PHP: 8.2
- Minimum WordPress: 6.4
- Target WordPress: current stable

## PHP Constraints

The plugin avoids PHP 8.1+ and PHP 8.2-only language features. Code is written for PHP 8.0 compatibility.

## WordPress Constraints

The plugin uses standard WordPress APIs for custom post types, post meta, admin menus, list table columns, activation hooks, and deactivation hooks.

## Frontend

Sprint 1 does not register frontend routes, frontend assets, archives, single views, shortcodes, blocks, or REST endpoints.
