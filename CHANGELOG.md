# Changelog

## 0.6.0 - Unreleased

- Added demo-only indicative estimate preview on the request review screen.
- Added `demo_distance_km` as an optional manually entered demo distance field.
- Added server-side demo estimate recalculation before saving the submission summary.
- Added `_mgrs_submission_summary` sections for indicative price and calculation method.
- Kept pricing rules hardcoded for demo discussion only; no production pricing settings, payments, maps, AI, or external APIs were added.

## 0.5.0 - Unreleased

- Drafted a Bulgarian Mestimvsichko-oriented five-step frontend request flow.
- Added moving/transport service choices for the client demo flow.
- Added reusable frontend metadata for service type, preferred contact time, and request urgency.
- Updated frontend submission validation to require city/area along with service, name, and phone.
- Updated frontend submission summaries to a Bulgarian grouped admin-readable format.
- Kept client-specific request detail fields inside `_mgrs_submission_summary` instead of adding per-field metadata.

## 0.4.0 - 2026-06-11

- Added frontend submission engine using standard POST and WordPress `admin-post.php`.
- Added nonce, honeypot, sanitization, and server-side validation for frontend submissions.
- Added request creation service for frontend-created `mgrs_request` records.
- Added `_mgrs_submission_summary` meta for plain-text submitted request details.
- Added success and failure redirect states for the request flow.
- Added read-only admin display for stored submission summaries.
- Added Sprint 4 submission engine documentation.

## 0.3.0 - 2026-06-11

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
