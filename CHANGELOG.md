# Changelog

## 0.3.0 - Unreleased

- Added frontend Smart Request Flow prototype shortcode `[mindgrid_request_flow]`.
- Added vanilla JavaScript step navigation and browser-memory review summary.
- Added scoped frontend CSS for the prototype flow.
- Added conditional frontend asset loading when the shortcode is present.
- Added Sprint 3 frontend architecture and UX flow documentation.

## 0.2.0 - 2026-06-11

- Added central request meta registry for approved Sprint 2 metadata.
- Added computed request ID display using `MRS-{post_id}` without storing `_mgrs_request_id`.
- Added admin request status metabox using the existing status registry.
- Added contact information and internal notes metaboxes.
- Added immutable created source handling with `manual_admin` fallback.
- Added status filtering to the request admin list table.
- Updated admin list Request ID display and localized status labels.

## 0.1.0 - 2026-06-10

- Added initial WordPress plugin bootstrap.
- Added no-Composer namespace autoloading.
- Added `mgrs_request` custom post type for admin-only request storage.
- Added `_mgrs_status` meta-based status registry.
- Added top-level `MindGrid Requests` admin menu.
- Added Request ID, Status, and Date admin columns.
- Added safe activation/deactivation hooks.
- Added Sprint 1 documentation set.
