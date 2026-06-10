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
- [ ] Default status displays as `New` when no valid status meta exists.
- [ ] Non-administrator roles cannot access request management in Sprint 1.

## Frontend

- [ ] No frontend archive is available for `mgrs_request`.
- [ ] No single frontend request view is available.
- [ ] No global frontend assets are loaded by the plugin.
- [ ] REST API exposure is disabled for Sprint 1.

## Deactivation

- [ ] Plugin deactivates without fatal errors.
- [ ] Rewrite rules are flushed on deactivation only.
- [ ] Request data remains in the database after deactivation.

## Logs

- [ ] Debug log contains no plugin PHP warnings, notices, or fatal errors.
