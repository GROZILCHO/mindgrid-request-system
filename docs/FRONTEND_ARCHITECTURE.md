# Frontend Architecture

Sprint 3 introduced a frontend browser prototype for the Smart Request Flow. Sprint 4 adds the first real submission engine using a standard POST form and WordPress `admin-post.php`. Sprint 5 drafts a Bulgarian Mestimvsichko-oriented demo field set on top of that submission path.

## Shortcode

Use the shortcode:

```text
[mindgrid_request_flow]
```

The shortcode is registered by `MindGrid\RequestSystem\Frontend\Shortcodes\RequestFlowShortcode` and renders `templates/request-flow.php`.

## Asset Loading

Frontend assets are registered through WordPress-native enqueue APIs in `MindGrid\RequestSystem\Frontend\Assets\FrontendAssets`.

Assets:

- `assets/frontend/request-flow.css`
- `assets/frontend/request-flow.js`

Assets are enqueued only when the shortcode is present on a singular page. The shortcode render method also enqueues the assets as a fallback for shortcode execution. Asset versions use `MGRS_VERSION`.

## Submission Engine

Sprint 4 submission uses:

- standard HTML form POST;
- `admin-post.php`;
- `admin_post_nopriv_mgrs_submit_request`;
- `admin_post_mgrs_submit_request`;
- nonce field `mgrs_request_flow_nonce`;
- nonce action `mgrs_submit_request`;
- honeypot field `mgrs_company_website`;
- server-side sanitization and validation;
- redirect-based success/failure states.

The frontend does not:

- call AJAX or REST endpoints;
- send email;
- upload files;
- use cookies or localStorage;
- call external services.

Successful submissions create `mgrs_request` records through `RequestCreator`.

## Sprint 5 Field Set

The frontend flow uses Bulgarian UI copy and these field keys:

- `service_type`
- `city_area`
- `from_address`
- `to_address`
- `floor`
- `has_elevator`
- `parking_access`
- `items_description`
- `boxes_bags_count`
- `heavy_items`
- `disassembly_needed`
- `extra_services`
- `notes`
- `contact_name`
- `contact_phone`
- `contact_email`
- `contact_time`
- `request_urgency`

Reusable metadata stores only service type, contact fields, contact time, urgency, status, created source, and the submission summary. Mestimvsichko-specific operational details are stored inside `_mgrs_submission_summary` and are not promoted to separate meta fields.

Sprint 5 remains demo/client-discussion ready. Future sprints may add production localization, notifications, uploads, exports, settings, pricing, booking, or client-specific workflow hardening only after explicit approval.
