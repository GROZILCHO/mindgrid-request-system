# Smart Request Flow UX

Sprint 3 provides a five-step browser-only prototype.

## Steps

1. Service Type
   - `service_type`
2. Address & Access
   - `city_area`
   - `floor`
   - `has_elevator`
   - `parking_access`
3. Items & Volume
   - `items`
4. Extra Services & Notes
   - `extra_services`
   - `notes`
5. Contact & Review
   - `contact_name`
   - `contact_phone`
   - `contact_email`

## Required Fields

Sprint 3 requires:

- `service_type`
- `contact_name`
- `contact_phone`

The prototype blocks Next navigation until required fields in the current step are completed.

## Review Screen

The final screen shows a readable summary of entered prototype data and the message:

```text
Prototype only. Submission engine is not active.
```

There is no submit button. No data is sent or saved.

## Accessibility

- Every field has a visible label.
- Navigation uses native buttons.
- Focus states are visible.
- Errors are textual and not color-only.
- Step and progress status are readable.

## Mobile UX

The layout is mobile-first, single-column by default, and uses full-width action buttons on mobile. Touch targets are at least 44px high.
