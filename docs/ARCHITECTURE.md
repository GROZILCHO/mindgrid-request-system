# Architecture

MindGrid Request System is a reusable WordPress plugin foundation for admin-managed request workflows.

## Bootstrap

The root `mindgrid-request-system.php` file defines plugin metadata, constants, a lightweight namespace autoloader, activation/deactivation hooks, and the main plugin startup action.

## Namespacing

All implementation classes use the `MindGrid\RequestSystem` namespace. The autoloader maps classes under that namespace to files in `includes/` without Composer.

## Storage

Requests are stored as WordPress posts using the `mgrs_request` custom post type. The plugin uses core CPT and post meta storage only and does not create custom database tables.

## Request Entity

Sprint 2 adds the request entity foundation on top of the CPT. The human-facing request ID is computed as `MRS-{post_id}` and is not stored in post meta.

Approved request metadata is centralized in `MindGrid\RequestSystem\Meta\RequestMetaRegistry`.

Approved meta fields:

- `_mgrs_status`
- `_mgrs_contact_name`
- `_mgrs_contact_phone`
- `_mgrs_contact_email`
- `_mgrs_internal_notes`
- `_mgrs_created_source`
- `_mgrs_submission_summary`
- `_mgrs_service_type`
- `_mgrs_contact_time`
- `_mgrs_request_urgency`

The plugin must not create `_mgrs_request_id`.

## Submission Engine

Sprint 4 adds the first frontend submission engine. The request flow submits a standard POST request to WordPress `admin-post.php`.

Submission path:

Frontend form -> `admin-post.php` -> `SubmissionHandler` -> nonce validation -> honeypot check -> sanitization -> server-side validation -> `RequestCreator` -> `wp_insert_post()` -> approved post meta storage -> redirect to success or failure state.

The submission engine does not use REST, AJAX, uploads, email, external services, or custom database tables.

Frontend-created requests store:

- `_mgrs_status = new`
- `_mgrs_created_source = frontend_form`
- `_mgrs_contact_name`
- `_mgrs_contact_phone`
- `_mgrs_contact_email`
- `_mgrs_service_type`
- `_mgrs_contact_time`
- `_mgrs_request_urgency`
- `_mgrs_submission_summary`

## Sprint 5 Bulgarian UX Draft

Sprint 5 updates the frontend flow into a Bulgarian Mestimvsichko-oriented demo field set for moving, transport, helper, and clearing requests. The flow remains a demo/client-discussion draft, not a final production booking or pricing workflow.

Most service-specific details are intentionally stored only in `_mgrs_submission_summary` as grouped plain text. The plugin does not add separate meta fields for addresses, floors, item descriptions, heavy items, extra service choices, or notes.

The only Sprint 5 reusable metadata additions are:

- `_mgrs_service_type`
- `_mgrs_contact_time`
- `_mgrs_request_urgency`

Sprint 5 does not add uploads, email notifications, autoresponders, price calculation, calendar/reservation logic, maps, AI, payments, SMS/WhatsApp, settings, builder UI, custom roles, external services, or theme changes.

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

The default status is `new`. Invalid or missing status values fall back to `new`.

## Admin

The admin exposes a top-level menu labelled `MindGrid Requests`. It links to the internal CPT list table.

Sprint 2 admin editing includes:

- Request Status metabox.
- Contact Information metabox.
- Internal Notes metabox.
- Read-only Created Source display.
- Status filter on the request list table.

## Permissions

Sprint 2 remains administrator-only through WordPress `manage_options`. The future capability constant `manage_mgrs_requests` remains defined but is not assigned to roles.

## Created Source

Manual admin-created requests default to `_mgrs_created_source = manual_admin`. Frontend-created requests use `_mgrs_created_source = frontend_form`. Created source is treated as immutable after creation. Existing Sprint 1 requests without source metadata display the `manual_admin` fallback safely.
