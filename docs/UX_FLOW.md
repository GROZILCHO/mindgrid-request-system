# Smart Request Flow UX

Sprint 3 introduced a five-step browser-only prototype. Sprint 4 adds a real final submit action after the review step.

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

The flow blocks Next navigation until required fields in the current step are completed. Sprint 4 repeats required-field validation on the server before any request is created.

## Review And Submit

The final screen shows a readable summary of entered request data. A submit button appears only on this final review screen.

On submit, the browser sends a standard POST request to `admin-post.php`. No AJAX or REST request is used.

Success and failure states are displayed after redirecting back to the flow page.

## Accessibility

- Every field has a visible label.
- Navigation uses native buttons.
- Focus states are visible.
- Errors are textual and not color-only.
- Step and progress status are readable.

## Mobile UX

The layout is mobile-first, single-column by default, and uses full-width action buttons on mobile. Touch targets are at least 44px high.
