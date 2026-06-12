# Submission Engine

Sprint 4 adds the first real frontend submission engine for MindGrid Request System. Sprint 5 keeps the same submission architecture and updates the submitted field set for a Bulgarian Mestimvsichko demo flow. Sprint 6 adds a demo-only indicative estimate preview while preserving the same submission path.

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
- `city_area`
- `contact_name`
- `contact_phone`

Optional:

- `contact_email`
- `from_address`
- `to_address`
- `floor`
- `has_elevator`
- `parking_access`
- `demo_distance_km`
- `items_description`
- `boxes_bags_count`
- `heavy_items`
- `disassembly_needed`
- `extra_services`
- `notes`
- `contact_time`
- `request_urgency`

`service_type` must be one of:

- `moving_home`
- `moving_office`
- `moving_helpers`
- `transport_van`
- `clearing`
- `other`

Optional email must be valid when present. Extra service values and request urgency values are whitelisted server-side.

`demo_distance_km` is optional. Empty or invalid values are sanitized to `0`; valid numeric values are clamped between `0` and `300`.

## Demo Estimate Preview

Sprint 6 calculates an indicative price range for demo discussion only. The frontend JavaScript calculates a review-screen preview for UX, but the submitted estimate is not trusted. PHP recalculates the estimate server-side before writing `_mgrs_submission_summary`.

The demo estimate is not final pricing, not a production calculator, and not a legally binding quote. Sprint 6 does not add pricing settings, payment buttons, Google Maps, AI, external APIs, or custom database tables.

## Stored Metadata

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

The plugin must not create `_mgrs_request_id`; request IDs remain computed as `MRS-{post_id}`.

Mestimvsichko-specific operational details such as addresses, floor/access notes, item description, heavy items, extra service choices, demo distance, estimate range, and freeform notes are grouped into `_mgrs_submission_summary` instead of separate meta fields.

## Out of Scope

Sprint 6 does not include REST, AJAX, uploads, email notifications, autoresponders, production price calculation, calendar/reservation, maps, AI, payments, SMS/WhatsApp, user accounts, settings, builder UI, external services, or final production client approval.
