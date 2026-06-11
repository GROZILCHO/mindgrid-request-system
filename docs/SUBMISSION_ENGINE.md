# Submission Engine

Sprint 4 adds the first real frontend submission engine for MindGrid Request System.

## Flow

```text
Frontend form
-> POST request
-> admin-post.php
-> SubmissionHandler
-> nonce validation
-> honeypot check
-> sanitization
-> server-side validation
-> RequestCreator
-> wp_insert_post()
-> update_post_meta()
-> redirect to success or failure state
```

## Hooks

- `admin_post_nopriv_mgrs_submit_request`
- `admin_post_mgrs_submit_request`

Public users do not need WordPress capabilities to submit the frontend form. Admin editing remains protected by the existing admin-only logic.

## Security

- Nonce action: `mgrs_submit_request`
- Nonce field: `mgrs_request_flow_nonce`
- Honeypot field: `mgrs_company_website`
- Request method must be POST.
- Spam, missing nonce, invalid nonce, and invalid submissions do not create requests.
- Public failure messages are generic.

## Validation

Required:

- `service_type`
- `contact_name`
- `contact_phone`

Optional:

- `contact_email`
- `city_area`
- `floor`
- `has_elevator`
- `parking_access`
- `items`
- `extra_services`
- `notes`

`service_type` must be one of the allowed values rendered by the frontend flow. Optional email must be valid when present.

## Stored Metadata

Frontend-created requests store:

- `_mgrs_status = new`
- `_mgrs_created_source = frontend_form`
- `_mgrs_contact_name`
- `_mgrs_contact_phone`
- `_mgrs_contact_email`
- `_mgrs_submission_summary`

The plugin must not create `_mgrs_request_id`; request IDs remain computed as `MRS-{post_id}`.

## Out of Scope

Sprint 4 does not include REST, AJAX, uploads, email notifications, autoresponders, price calculation, calendar/reservation, maps, AI, payments, SMS/WhatsApp, user accounts, settings, external services, or client-specific questionnaire logic.
