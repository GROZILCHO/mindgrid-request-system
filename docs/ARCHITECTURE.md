# Architecture

MindGrid Request System v0.1.0 is a reusable WordPress plugin foundation.

## Bootstrap

The root `mindgrid-request-system.php` file defines plugin metadata, constants, a lightweight namespace autoloader, activation/deactivation hooks, and the main plugin startup action.

## Namespacing

All implementation classes use the `MindGrid\RequestSystem` namespace. The autoloader maps classes under that namespace to files in `includes/` without Composer.

## Storage

Requests are stored as WordPress posts using the `mgrs_request` custom post type. Sprint 1 uses core CPT storage only and does not create custom database tables.

## Statuses

Request workflow status is stored as post meta under `_mgrs_status`. Statuses are centralized in `MindGrid\RequestSystem\Statuses\RequestStatuses`.

Approved values:

- `new`
- `reviewing`
- `needs_info`
- `quoted`
- `confirmed`
- `completed`
- `cancelled`

The default status is `new`.

## Admin

Sprint 1 exposes a top-level admin menu labelled `MindGrid Requests`. It links to the internal CPT list table and displays basic columns only.

## Permissions

Sprint 1 uses administrator-only access through WordPress `manage_options`. The future capability constant `manage_mgrs_requests` is defined but not assigned to roles in v0.1.0.
