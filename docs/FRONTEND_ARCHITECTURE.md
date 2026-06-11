# Frontend Architecture

Sprint 3 introduced a frontend browser prototype for the Smart Request Flow. Sprint 4 adds the first real submission engine using a standard POST form and WordPress `admin-post.php`.

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

## Sprint 4 Bridge

The field keys are reserved for future mapping in a separately approved submission engine:

- `service_type`
- `city_area`
- `floor`
- `has_elevator`
- `parking_access`
- `items`
- `extra_services`
- `notes`
- `contact_name`
- `contact_phone`
- `contact_email`

The Sprint 4 submission engine maps approved frontend fields into request records and stores non-contact request detail text in `_mgrs_submission_summary`. Future sprints may add notifications, uploads, exports, settings, or client-specific field sets only after explicit approval.
