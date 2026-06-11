# Frontend Architecture

Sprint 3 introduces a frontend browser prototype for the Smart Request Flow. It is a UX prototype only and does not include a submission engine.

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

## Prototype Boundary

The prototype does not:

- create requests;
- write to the database;
- call AJAX or REST endpoints;
- send email;
- upload files;
- use cookies or localStorage;
- communicate with the admin request entity layer.

All entered state remains in browser memory until the page is refreshed or left.

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

Sprint 4 should define validation, persistence, notifications, and admin mapping rules before any production submission behavior is added.
