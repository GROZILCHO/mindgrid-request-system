# MindGrid Request System v0.1.0 — Foundation Release

MindGrid Request System v0.1.0 is an infrastructure and foundation release. It establishes the plugin structure, storage model, admin visibility, and documentation baseline. It is not an end-user MVP.

## What Is Included

- WordPress plugin bootstrap for `mindgrid-request-system`.
- PHP namespace `MindGrid\RequestSystem`.
- No-Composer autoloading strategy.
- `mgrs_request` custom post type for request storage.
- Meta-based request status registry using `_mgrs_status`.
- Default request status: `new`.
- Top-level admin menu: `MindGrid Requests`.
- Basic admin columns: Request ID, Status, Date.
- Administrator-only access for Sprint 1.
- Safe activation and deactivation hooks.
- Architecture, compatibility, QA, release, roadmap, README, and changelog documentation.

## What Is Explicitly Not Included

- Frontend request form.
- Shortcode or Gutenberg block.
- Uploads.
- Email notifications or auto-replies.
- Export tools.
- Settings page.
- Custom database tables.
- REST API exposure.
- AI, maps, calendar, payments, or other external services.
- Custom roles.
- Theme changes.
- Mestimvsichko.bg-specific fields or logic.

## Runtime QA Summary

Staging runtime QA passed for the Sprint 1 foundation:

- Activation: PASS.
- Admin menu: PASS.
- CPT admin screen: PASS.
- Manual request creation: PASS.
- Default status fallback: PASS, displayed as `New`.
- CPT public archive: blocked.
- `?post_type=mgrs_request`: did not expose requests.
- Deactivation/reactivation: PASS.
- Frontend regression: PASS.

## Known Minor Observations

- Numeric WordPress post ID is used as the Request ID for now.
- Status label displays `New`.
- The standard WordPress publish box may show `Visibility: Public`, even though the CPT is not publicly queryable.
- Debug log was unavailable during staging QA.

## Compatibility Baseline

- Minimum PHP: 8.0.
- Target PHP: 8.2.
- Tested staging PHP: 8.3.
- Minimum WordPress: 6.4.
- Tested staging WordPress: 7.0.

## Next Planned Direction

Future work should build on this generic product foundation. Planned directions include a dedicated request editing experience, migration toward the future `manage_mgrs_requests` capability, and approved product features such as intake UI, notifications, export tools, or settings only when those scopes are explicitly authorized.
