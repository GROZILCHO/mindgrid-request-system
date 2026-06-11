<?php
/**
 * Request flow prototype template.
 *
 * @package MindGrid\RequestSystem
 */

declare(strict_types=1);

if (! defined('ABSPATH')) {
    exit;
}
?>
<div class="mgrs-flow" data-mgrs-flow>
    <div class="mgrs-flow__header">
        <p class="mgrs-flow__eyebrow"><?php echo esc_html__('Smart Request Flow Prototype', 'mindgrid-request-system'); ?></p>
        <h2 class="mgrs-flow__title"><?php echo esc_html__('Request details', 'mindgrid-request-system'); ?></h2>
        <p class="mgrs-flow__intro"><?php echo esc_html__('Walk through the prototype flow. Data stays in this browser session and is not submitted.', 'mindgrid-request-system'); ?></p>
    </div>

    <div class="mgrs-flow__status" aria-live="polite">
        <span class="mgrs-flow__step-text" data-mgrs-step-text><?php echo esc_html__('Step 1 of 5', 'mindgrid-request-system'); ?></span>
        <span class="mgrs-flow__progress-label" data-mgrs-progress-label><?php echo esc_html__('20% complete', 'mindgrid-request-system'); ?></span>
    </div>

    <div class="mgrs-flow__progress" aria-hidden="true">
        <span class="mgrs-flow__progress-bar" data-mgrs-progress-bar></span>
    </div>

    <p class="mgrs-flow__error" data-mgrs-error hidden></p>

    <div class="mgrs-flow__steps">
        <section class="mgrs-flow__step" data-mgrs-step data-mgrs-step-index="1">
            <h3 class="mgrs-flow__step-title"><?php echo esc_html__('Service Type', 'mindgrid-request-system'); ?></h3>
            <div class="mgrs-flow__field">
                <label class="mgrs-flow__label" for="mgrs_service_type"><?php echo esc_html__('Service type', 'mindgrid-request-system'); ?> <span class="mgrs-flow__required"><?php echo esc_html__('Required', 'mindgrid-request-system'); ?></span></label>
                <select class="mgrs-flow__input" id="mgrs_service_type" name="service_type" data-mgrs-field data-mgrs-required>
                    <option value=""><?php echo esc_html__('Choose a service type', 'mindgrid-request-system'); ?></option>
                    <option value="moving"><?php echo esc_html__('Moving / transport', 'mindgrid-request-system'); ?></option>
                    <option value="delivery"><?php echo esc_html__('Delivery support', 'mindgrid-request-system'); ?></option>
                    <option value="other"><?php echo esc_html__('Other service request', 'mindgrid-request-system'); ?></option>
                </select>
            </div>
        </section>

        <section class="mgrs-flow__step" data-mgrs-step data-mgrs-step-index="2" hidden>
            <h3 class="mgrs-flow__step-title"><?php echo esc_html__('Address & Access', 'mindgrid-request-system'); ?></h3>
            <div class="mgrs-flow__field">
                <label class="mgrs-flow__label" for="mgrs_city_area"><?php echo esc_html__('City / area', 'mindgrid-request-system'); ?></label>
                <input class="mgrs-flow__input" id="mgrs_city_area" name="city_area" type="text" data-mgrs-field>
            </div>
            <div class="mgrs-flow__grid">
                <div class="mgrs-flow__field">
                    <label class="mgrs-flow__label" for="mgrs_floor"><?php echo esc_html__('Floor', 'mindgrid-request-system'); ?></label>
                    <input class="mgrs-flow__input" id="mgrs_floor" name="floor" type="text" data-mgrs-field>
                </div>
                <div class="mgrs-flow__field">
                    <label class="mgrs-flow__label" for="mgrs_has_elevator"><?php echo esc_html__('Elevator access', 'mindgrid-request-system'); ?></label>
                    <select class="mgrs-flow__input" id="mgrs_has_elevator" name="has_elevator" data-mgrs-field>
                        <option value=""><?php echo esc_html__('Not specified', 'mindgrid-request-system'); ?></option>
                        <option value="yes"><?php echo esc_html__('Yes', 'mindgrid-request-system'); ?></option>
                        <option value="no"><?php echo esc_html__('No', 'mindgrid-request-system'); ?></option>
                    </select>
                </div>
            </div>
            <div class="mgrs-flow__field">
                <label class="mgrs-flow__label" for="mgrs_parking_access"><?php echo esc_html__('Parking / loading access', 'mindgrid-request-system'); ?></label>
                <input class="mgrs-flow__input" id="mgrs_parking_access" name="parking_access" type="text" data-mgrs-field>
            </div>
        </section>

        <section class="mgrs-flow__step" data-mgrs-step data-mgrs-step-index="3" hidden>
            <h3 class="mgrs-flow__step-title"><?php echo esc_html__('Items & Volume', 'mindgrid-request-system'); ?></h3>
            <div class="mgrs-flow__field">
                <label class="mgrs-flow__label" for="mgrs_items"><?php echo esc_html__('Items', 'mindgrid-request-system'); ?></label>
                <textarea class="mgrs-flow__textarea" id="mgrs_items" name="items" rows="5" data-mgrs-field></textarea>
            </div>
        </section>

        <section class="mgrs-flow__step" data-mgrs-step data-mgrs-step-index="4" hidden>
            <h3 class="mgrs-flow__step-title"><?php echo esc_html__('Extra Services & Notes', 'mindgrid-request-system'); ?></h3>
            <div class="mgrs-flow__field">
                <label class="mgrs-flow__label" for="mgrs_extra_services"><?php echo esc_html__('Extra services', 'mindgrid-request-system'); ?></label>
                <textarea class="mgrs-flow__textarea" id="mgrs_extra_services" name="extra_services" rows="4" data-mgrs-field></textarea>
            </div>
            <div class="mgrs-flow__field">
                <label class="mgrs-flow__label" for="mgrs_notes"><?php echo esc_html__('Notes', 'mindgrid-request-system'); ?></label>
                <textarea class="mgrs-flow__textarea" id="mgrs_notes" name="notes" rows="4" data-mgrs-field></textarea>
            </div>
        </section>

        <section class="mgrs-flow__step" data-mgrs-step data-mgrs-step-index="5" hidden>
            <h3 class="mgrs-flow__step-title"><?php echo esc_html__('Contact & Review', 'mindgrid-request-system'); ?></h3>
            <div class="mgrs-flow__field">
                <label class="mgrs-flow__label" for="mgrs_contact_name"><?php echo esc_html__('Contact name', 'mindgrid-request-system'); ?> <span class="mgrs-flow__required"><?php echo esc_html__('Required', 'mindgrid-request-system'); ?></span></label>
                <input class="mgrs-flow__input" id="mgrs_contact_name" name="contact_name" type="text" data-mgrs-field data-mgrs-required>
            </div>
            <div class="mgrs-flow__field">
                <label class="mgrs-flow__label" for="mgrs_contact_phone"><?php echo esc_html__('Contact phone', 'mindgrid-request-system'); ?> <span class="mgrs-flow__required"><?php echo esc_html__('Required', 'mindgrid-request-system'); ?></span></label>
                <input class="mgrs-flow__input" id="mgrs_contact_phone" name="contact_phone" type="tel" data-mgrs-field data-mgrs-required>
            </div>
            <div class="mgrs-flow__field">
                <label class="mgrs-flow__label" for="mgrs_contact_email"><?php echo esc_html__('Contact email', 'mindgrid-request-system'); ?></label>
                <input class="mgrs-flow__input" id="mgrs_contact_email" name="contact_email" type="email" data-mgrs-field>
            </div>
        </section>
    </div>

    <section class="mgrs-flow__summary" data-mgrs-summary hidden>
        <h3 class="mgrs-flow__step-title"><?php echo esc_html__('Review / Prototype Summary', 'mindgrid-request-system'); ?></h3>
        <dl class="mgrs-flow__summary-list" data-mgrs-summary-list></dl>
        <p class="mgrs-flow__notice"><?php echo esc_html__('Prototype only. Submission engine is not active.', 'mindgrid-request-system'); ?></p>
    </section>

    <div class="mgrs-flow__actions">
        <button class="mgrs-flow__action mgrs-flow__action--secondary" type="button" data-mgrs-back hidden><?php echo esc_html__('Back', 'mindgrid-request-system'); ?></button>
        <button class="mgrs-flow__action" type="button" data-mgrs-next><?php echo esc_html__('Next', 'mindgrid-request-system'); ?></button>
    </div>
</div>
