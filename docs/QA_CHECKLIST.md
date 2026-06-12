# QA Checklist

## Environment

- [ ] PHP version is 8.0 or newer.
- [ ] WordPress version is 6.4 or newer.
- [ ] `WP_DEBUG_LOG` is enabled for local validation if available.

## Activation

- [ ] Plugin activates without fatal errors.
- [ ] Rewrite rules are flushed on activation only.
- [ ] No data is deleted on activation.

## Admin

- [ ] Top-level `MindGrid Requests` menu appears for administrators.
- [ ] `mgrs_request` list table is visible in admin.
- [ ] List table shows Request ID, Status, and Date columns.
- [ ] Request ID displays as `MRS-{post_id}`.
- [ ] No `_mgrs_request_id` meta is created.
- [ ] Default status displays as `Нова` when no valid status meta exists.
- [ ] Status filter appears on the request list table.
- [ ] Status filter returns matching requests.
- [ ] Non-administrator roles cannot access request management.

## Request Edit Screen

- [ ] Request Status metabox loads.
- [ ] Status dropdown contains the approved status registry values.
- [ ] Status saves and reloads.
- [ ] Invalid status values fall back to `new`.
- [ ] Contact name saves and reloads.
- [ ] Contact phone saves and reloads.
- [ ] Contact email saves and reloads.
- [ ] Internal notes save and reload.
- [ ] Created source displays as `manual_admin` for manual admin-created requests.
- [ ] Created source is read-only and immutable after creation.
- [ ] Existing Sprint 1 requests without source metadata load safely with `manual_admin` fallback.
- [ ] Frontend submission summary displays as read-only plain text.

## Frontend

- [ ] No frontend archive is available for `mgrs_request`.
- [ ] No single frontend request view is available.
- [ ] Frontend request flow assets load only on pages containing `[mindgrid_request_flow]`.
- [ ] REST API exposure remains disabled.

## Sprint 5 Request Flow

- [ ] `[mindgrid_request_flow]` renders a five-step Bulgarian flow.
- [ ] Service options are `moving_home`, `moving_office`, `moving_helpers`, `transport_van`, `clearing`, and `other`.
- [ ] Next and Back navigation works by keyboard and pointer.
- [ ] Step indicator and progress indicator update correctly.
- [ ] Required `service_type`, `city_area`, `contact_name`, and `contact_phone` fields block continuation when empty.
- [ ] Review screen shows entered request data.
- [ ] Review screen shows an indicative estimate range.
- [ ] Review screen states that the estimate is indicative and not a final offer.
- [ ] Review screen states that submission is not a confirmed reservation.
- [ ] Submit button appears only on the final review screen.
- [ ] Submit button disables on click.
- [ ] No localStorage, cookies, AJAX, or REST is used.
- [ ] Layout has no horizontal overflow at 375px and remains usable at 390px, 768px, and desktop widths.

## Submission Engine

- [ ] Successful frontend submission creates a new `mgrs_request`.
- [ ] Successful submission redirects back with success state.
- [ ] Success state shows `Заявката е изпратена успешно.`
- [ ] Success state shows `Номер на заявка: MRS-{post_id}`.
- [ ] Failed submission redirects back with generic error state.
- [ ] Missing nonce does not create a request.
- [ ] Invalid nonce does not create a request.
- [ ] Filled honeypot does not create a request.
- [ ] Invalid `service_type` does not create a request.
- [ ] Missing `city_area` does not create a request.
- [ ] Missing `contact_name` does not create a request.
- [ ] Missing `contact_phone` does not create a request.
- [ ] Invalid optional `contact_email` does not create a request.
- [ ] Invalid extra service values do not create a request.
- [ ] Invalid request urgency values do not create a request.
- [ ] Empty or invalid `demo_distance_km` does not block submission and is treated as `0`.
- [ ] `demo_distance_km` values above `300` are clamped to `300`.
- [ ] Frontend-created request status is `new`.
- [ ] Frontend-created request source is `frontend_form`.
- [ ] Contact fields are populated in admin.
- [ ] `_mgrs_service_type`, `_mgrs_contact_time`, and `_mgrs_request_urgency` are populated when submitted.
- [ ] `_mgrs_submission_summary` is populated with Bulgarian grouped plain-text submitted details.
- [ ] `_mgrs_submission_summary` includes the indicative estimate range and calculation method.
- [ ] `_mgrs_request_id` is not created.

## Deactivation

- [ ] Plugin deactivates without fatal errors.
- [ ] Rewrite rules are flushed on deactivation only.
- [ ] Request data remains in the database after deactivation.

## Logs

- [ ] Debug log contains no plugin PHP warnings, notices, or fatal errors.
