# Smart Request Flow UX

Sprint 5 drafts a Bulgarian Mestimvsichko-oriented request flow for moving, transport, helper, and clearing requests. The flow is demo/client-discussion ready and is not a final production booking or pricing workflow.

## Steps

1. Каква услуга ви трябва?
   - `service_type`
2. Адрес и достъп
   - `city_area`
   - `from_address`
   - `to_address`
   - `floor`
   - `has_elevator`
   - `parking_access`
3. Какво трябва да се премести?
   - `items_description`
   - `boxes_bags_count`
   - `heavy_items`
   - `disassembly_needed`
4. Допълнителни услуги
   - `extra_services`
   - `notes`
5. Контакт и удобен момент
   - `contact_name`
   - `contact_phone`
   - `contact_email`
   - `contact_time`
   - `request_urgency`

## Required Fields

Required in the browser and repeated on the server:

- `service_type`
- `city_area`
- `contact_name`
- `contact_phone`

Optional email must be valid when present.

## Review And Submit

The final screen shows a readable Bulgarian summary of entered request data. A submit button appears only on this final review screen.

On submit, the browser sends a standard POST request to `admin-post.php`. No AJAX or REST request is used.

Success and failure states are displayed after redirecting back to the flow page.

## User-Facing Notes

The review screen states that:

- the form does not calculate an automatic price;
- a representative will contact the customer to clarify details;
- submission is not a confirmed reservation;
- the final offer is prepared after reviewing the provided information.

## Accessibility

- Every field has a visible label.
- Navigation uses native buttons.
- Focus states are visible.
- Errors are textual and not color-only.
- Step and progress status are readable.

## Mobile UX

The layout is mobile-first, single-column by default, and uses full-width action buttons on mobile. Touch targets are at least 44px high.
