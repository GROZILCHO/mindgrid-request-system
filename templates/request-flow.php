<?php
/**
 * Request flow template.
 *
 * @package MindGrid\RequestSystem
 */

declare(strict_types=1);

if (! defined('ABSPATH')) {
    exit;
}

$flow_status = isset($_GET['mgrs_flow_status']) && is_string($_GET['mgrs_flow_status']) ? sanitize_key(wp_unslash($_GET['mgrs_flow_status'])) : '';
$request_id = isset($_GET['mgrs_request_id']) && is_string($_GET['mgrs_request_id']) ? sanitize_text_field(wp_unslash($_GET['mgrs_request_id'])) : '';
?>
<div class="mgrs-flow" data-mgrs-flow>
    <?php if ('success' === $flow_status) : ?>
        <div class="mgrs-flow__message mgrs-flow__message--success" role="status">
            <p><?php echo esc_html__('Заявката е изпратена успешно.', 'mindgrid-request-system'); ?></p>
            <?php if ('' !== $request_id) : ?>
                <p><?php echo esc_html__('Номер на заявка:', 'mindgrid-request-system'); ?> <strong><?php echo esc_html($request_id); ?></strong></p>
            <?php endif; ?>
        </div>
    <?php elseif ('error' === $flow_status) : ?>
        <div class="mgrs-flow__message mgrs-flow__message--error" role="alert">
            <p><?php echo esc_html__('Заявката не беше изпратена. Моля, проверете задължителните полета и опитайте отново.', 'mindgrid-request-system'); ?></p>
        </div>
    <?php endif; ?>

    <div class="mgrs-flow__header">
        <p class="mgrs-flow__eyebrow"><?php echo esc_html__('СИСТЕМА ЗА ЗАЯВКИ', 'mindgrid-request-system'); ?></p>
        <h2 class="mgrs-flow__title"><?php echo esc_html__('Подробна заявка', 'mindgrid-request-system'); ?></h2>
        <p class="mgrs-flow__intro"><?php echo esc_html__('Попълнете кратката форма и ни изпратете информация за вашата задача. Колкото повече подробности получим, толкова по-бързо и точно ще можем да ви съдействаме.', 'mindgrid-request-system'); ?></p>
    </div>

    <form class="mgrs-flow__form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" data-mgrs-form>
        <input type="hidden" name="action" value="mgrs_submit_request">
        <?php wp_nonce_field('mgrs_submit_request', 'mgrs_request_flow_nonce'); ?>
        <div class="mgrs-flow__honeypot" aria-hidden="true">
            <label for="mgrs_company_website"><?php echo esc_html__('Company website', 'mindgrid-request-system'); ?></label>
            <input id="mgrs_company_website" name="mgrs_company_website" type="text" tabindex="-1" autocomplete="off">
        </div>

        <div class="mgrs-flow__status" aria-live="polite">
            <span class="mgrs-flow__step-text" data-mgrs-step-text><?php echo esc_html__('Стъпка 1 от 5', 'mindgrid-request-system'); ?></span>
            <span class="mgrs-flow__progress-label" data-mgrs-progress-label><?php echo esc_html__('20% завършено', 'mindgrid-request-system'); ?></span>
        </div>

        <div class="mgrs-flow__progress" aria-hidden="true">
            <span class="mgrs-flow__progress-bar" data-mgrs-progress-bar></span>
        </div>

        <p class="mgrs-flow__error" data-mgrs-error hidden></p>

        <div class="mgrs-flow__steps">
            <section class="mgrs-flow__step" data-mgrs-step data-mgrs-step-index="1">
                <h3 class="mgrs-flow__step-title"><?php echo esc_html__('Каква услуга ви трябва?', 'mindgrid-request-system'); ?></h3>
                <p class="mgrs-flow__step-intro"><?php echo esc_html__('Изберете услугата, която най-добре отговаря на вашата нужда.', 'mindgrid-request-system'); ?></p>
                <div class="mgrs-flow__field">
                    <label class="mgrs-flow__label" for="mgrs_service_type"><?php echo esc_html__('Услуга', 'mindgrid-request-system'); ?> <span class="mgrs-flow__required"><?php echo esc_html__('Задължително', 'mindgrid-request-system'); ?></span></label>
                    <select class="mgrs-flow__input" id="mgrs_service_type" name="service_type" data-mgrs-field data-mgrs-required>
                        <option value=""><?php echo esc_html__('Изберете услуга', 'mindgrid-request-system'); ?></option>
                        <option value="moving_home"><?php echo esc_html__('Преместване на жилище', 'mindgrid-request-system'); ?></option>
                        <option value="moving_office"><?php echo esc_html__('Преместване на офис', 'mindgrid-request-system'); ?></option>
                        <option value="moving_helpers"><?php echo esc_html__('Хамалски услуги', 'mindgrid-request-system'); ?></option>
                        <option value="transport_van"><?php echo esc_html__('Транспорт с бус', 'mindgrid-request-system'); ?></option>
                        <option value="clearing"><?php echo esc_html__('Изхвърляне / разчистване', 'mindgrid-request-system'); ?></option>
                        <option value="other"><?php echo esc_html__('Друго', 'mindgrid-request-system'); ?></option>
                    </select>
                </div>
            </section>

            <section class="mgrs-flow__step" data-mgrs-step data-mgrs-step-index="2" hidden>
                <h3 class="mgrs-flow__step-title"><?php echo esc_html__('Адрес и достъп', 'mindgrid-request-system'); ?></h3>
                <div class="mgrs-flow__field">
                    <label class="mgrs-flow__label" for="mgrs_city_area"><?php echo esc_html__('Град / район', 'mindgrid-request-system'); ?> <span class="mgrs-flow__required"><?php echo esc_html__('Задължително', 'mindgrid-request-system'); ?></span></label>
                    <input class="mgrs-flow__input" id="mgrs_city_area" name="city_area" type="text" data-mgrs-field data-mgrs-required>
                </div>
                <div class="mgrs-flow__grid">
                    <div class="mgrs-flow__field">
                        <label class="mgrs-flow__label" for="mgrs_from_address"><?php echo esc_html__('От адрес', 'mindgrid-request-system'); ?></label>
                        <input class="mgrs-flow__input" id="mgrs_from_address" name="from_address" type="text" data-mgrs-field>
                    </div>
                    <div class="mgrs-flow__field">
                        <label class="mgrs-flow__label" for="mgrs_to_address"><?php echo esc_html__('До адрес', 'mindgrid-request-system'); ?></label>
                        <input class="mgrs-flow__input" id="mgrs_to_address" name="to_address" type="text" data-mgrs-field>
                    </div>
                </div>
                <div class="mgrs-flow__grid">
                    <div class="mgrs-flow__field">
                        <label class="mgrs-flow__label" for="mgrs_floor"><?php echo esc_html__('Етаж', 'mindgrid-request-system'); ?></label>
                        <input class="mgrs-flow__input" id="mgrs_floor" name="floor" type="text" data-mgrs-field>
                    </div>
                    <div class="mgrs-flow__field">
                        <label class="mgrs-flow__label" for="mgrs_has_elevator"><?php echo esc_html__('Има ли асансьор?', 'mindgrid-request-system'); ?></label>
                        <select class="mgrs-flow__input" id="mgrs_has_elevator" name="has_elevator" data-mgrs-field>
                            <option value=""><?php echo esc_html__('Не е посочено', 'mindgrid-request-system'); ?></option>
                            <option value="yes"><?php echo esc_html__('Да', 'mindgrid-request-system'); ?></option>
                            <option value="no"><?php echo esc_html__('Не', 'mindgrid-request-system'); ?></option>
                        </select>
                    </div>
                </div>
                <div class="mgrs-flow__field">
                    <label class="mgrs-flow__label" for="mgrs_parking_access"><?php echo esc_html__('Може ли бусът да спре близо?', 'mindgrid-request-system'); ?></label>
                    <input class="mgrs-flow__input" id="mgrs_parking_access" name="parking_access" type="text" data-mgrs-field>
                </div>
            </section>

            <section class="mgrs-flow__step" data-mgrs-step data-mgrs-step-index="3" hidden>
                <h3 class="mgrs-flow__step-title"><?php echo esc_html__('Какво трябва да се премести?', 'mindgrid-request-system'); ?></h3>
                <div class="mgrs-flow__field">
                    <label class="mgrs-flow__label" for="mgrs_items_description"><?php echo esc_html__('Кратко описание', 'mindgrid-request-system'); ?></label>
                    <textarea class="mgrs-flow__textarea" id="mgrs_items_description" name="items_description" rows="4" data-mgrs-field></textarea>
                </div>
                <div class="mgrs-flow__grid">
                    <div class="mgrs-flow__field">
                        <label class="mgrs-flow__label" for="mgrs_boxes_bags_count"><?php echo esc_html__('Брой кашони / чували', 'mindgrid-request-system'); ?></label>
                        <input class="mgrs-flow__input" id="mgrs_boxes_bags_count" name="boxes_bags_count" type="text" data-mgrs-field>
                    </div>
                    <div class="mgrs-flow__field">
                        <label class="mgrs-flow__label" for="mgrs_disassembly_needed"><?php echo esc_html__('Нужно ли е разглобяване?', 'mindgrid-request-system'); ?></label>
                        <select class="mgrs-flow__input" id="mgrs_disassembly_needed" name="disassembly_needed" data-mgrs-field>
                            <option value=""><?php echo esc_html__('Не е посочено', 'mindgrid-request-system'); ?></option>
                            <option value="yes"><?php echo esc_html__('Да', 'mindgrid-request-system'); ?></option>
                            <option value="no"><?php echo esc_html__('Не', 'mindgrid-request-system'); ?></option>
                        </select>
                    </div>
                </div>
                <div class="mgrs-flow__field">
                    <label class="mgrs-flow__label" for="mgrs_heavy_items"><?php echo esc_html__('Тежки или специфични предмети', 'mindgrid-request-system'); ?></label>
                    <textarea class="mgrs-flow__textarea" id="mgrs_heavy_items" name="heavy_items" rows="3" data-mgrs-field></textarea>
                </div>
            </section>

            <section class="mgrs-flow__step" data-mgrs-step data-mgrs-step-index="4" hidden>
                <h3 class="mgrs-flow__step-title"><?php echo esc_html__('Допълнителни услуги', 'mindgrid-request-system'); ?></h3>
                <div class="mgrs-flow__field">
                    <span class="mgrs-flow__label"><?php echo esc_html__('Допълнителни услуги', 'mindgrid-request-system'); ?></span>
                    <div class="mgrs-flow__checks">
                        <label class="mgrs-flow__check"><input name="extra_services[]" type="checkbox" value="packing" data-mgrs-field> <span><?php echo esc_html__('Опаковане', 'mindgrid-request-system'); ?></span></label>
                        <label class="mgrs-flow__check"><input name="extra_services[]" type="checkbox" value="disassembly" data-mgrs-field> <span><?php echo esc_html__('Демонтаж', 'mindgrid-request-system'); ?></span></label>
                        <label class="mgrs-flow__check"><input name="extra_services[]" type="checkbox" value="assembly" data-mgrs-field> <span><?php echo esc_html__('Монтаж', 'mindgrid-request-system'); ?></span></label>
                        <label class="mgrs-flow__check"><input name="extra_services[]" type="checkbox" value="disposal" data-mgrs-field> <span><?php echo esc_html__('Изхвърляне', 'mindgrid-request-system'); ?></span></label>
                        <label class="mgrs-flow__check"><input name="extra_services[]" type="checkbox" value="carry_up_stairs" data-mgrs-field> <span><?php echo esc_html__('Качване по стълби', 'mindgrid-request-system'); ?></span></label>
                        <label class="mgrs-flow__check"><input name="extra_services[]" type="checkbox" value="carry_down_stairs" data-mgrs-field> <span><?php echo esc_html__('Сваляне по стълби', 'mindgrid-request-system'); ?></span></label>
                    </div>
                </div>
                <div class="mgrs-flow__field">
                    <label class="mgrs-flow__label" for="mgrs_notes"><?php echo esc_html__('Допълнителни бележки', 'mindgrid-request-system'); ?></label>
                    <textarea class="mgrs-flow__textarea" id="mgrs_notes" name="notes" rows="4" data-mgrs-field></textarea>
                </div>
            </section>

            <section class="mgrs-flow__step" data-mgrs-step data-mgrs-step-index="5" hidden>
                <h3 class="mgrs-flow__step-title"><?php echo esc_html__('Контакт и удобен момент', 'mindgrid-request-system'); ?></h3>
                <div class="mgrs-flow__field">
                    <label class="mgrs-flow__label" for="mgrs_contact_name"><?php echo esc_html__('Име', 'mindgrid-request-system'); ?> <span class="mgrs-flow__required"><?php echo esc_html__('Задължително', 'mindgrid-request-system'); ?></span></label>
                    <input class="mgrs-flow__input" id="mgrs_contact_name" name="contact_name" type="text" data-mgrs-field data-mgrs-required>
                </div>
                <div class="mgrs-flow__field">
                    <label class="mgrs-flow__label" for="mgrs_contact_phone"><?php echo esc_html__('Телефон', 'mindgrid-request-system'); ?> <span class="mgrs-flow__required"><?php echo esc_html__('Задължително', 'mindgrid-request-system'); ?></span></label>
                    <input class="mgrs-flow__input" id="mgrs_contact_phone" name="contact_phone" type="tel" data-mgrs-field data-mgrs-required>
                </div>
                <div class="mgrs-flow__field">
                    <label class="mgrs-flow__label" for="mgrs_contact_email"><?php echo esc_html__('Email', 'mindgrid-request-system'); ?></label>
                    <input class="mgrs-flow__input" id="mgrs_contact_email" name="contact_email" type="email" data-mgrs-field>
                </div>
                <div class="mgrs-flow__grid">
                    <div class="mgrs-flow__field">
                        <label class="mgrs-flow__label" for="mgrs_contact_time"><?php echo esc_html__('Удобно време за обаждане', 'mindgrid-request-system'); ?></label>
                        <input class="mgrs-flow__input" id="mgrs_contact_time" name="contact_time" type="text" data-mgrs-field>
                    </div>
                    <div class="mgrs-flow__field">
                        <label class="mgrs-flow__label" for="mgrs_request_urgency"><?php echo esc_html__('Колко спешна е заявката?', 'mindgrid-request-system'); ?></label>
                        <select class="mgrs-flow__input" id="mgrs_request_urgency" name="request_urgency" data-mgrs-field>
                            <option value=""><?php echo esc_html__('Не е посочено', 'mindgrid-request-system'); ?></option>
                            <option value="urgent"><?php echo esc_html__('Спешно', 'mindgrid-request-system'); ?></option>
                            <option value="this_week"><?php echo esc_html__('Тази седмица', 'mindgrid-request-system'); ?></option>
                            <option value="flexible"><?php echo esc_html__('Гъвкаво', 'mindgrid-request-system'); ?></option>
                        </select>
                    </div>
                </div>
            </section>
        </div>

        <section class="mgrs-flow__summary" data-mgrs-summary hidden>
            <h3 class="mgrs-flow__step-title"><?php echo esc_html__('Преглед на заявката', 'mindgrid-request-system'); ?></h3>
            <dl class="mgrs-flow__summary-list" data-mgrs-summary-list></dl>
            <p class="mgrs-flow__notice"><?php echo esc_html__('Моля, прегледайте информацията преди изпращане.', 'mindgrid-request-system'); ?></p>
            <ul class="mgrs-flow__notes">
                <li><?php echo esc_html__('Тази форма не изчислява автоматична цена.', 'mindgrid-request-system'); ?></li>
                <li><?php echo esc_html__('След изпращане на заявката наш представител ще се свърже с вас за уточняване на детайлите.', 'mindgrid-request-system'); ?></li>
                <li><?php echo esc_html__('Изпращането на заявката не представлява потвърдена резервация.', 'mindgrid-request-system'); ?></li>
                <li><?php echo esc_html__('Окончателната оферта се изготвя след преглед на предоставената информация.', 'mindgrid-request-system'); ?></li>
            </ul>
        </section>

        <div class="mgrs-flow__actions">
            <button class="mgrs-flow__action mgrs-flow__action--secondary" type="button" data-mgrs-back hidden><?php echo esc_html__('Назад', 'mindgrid-request-system'); ?></button>
            <button class="mgrs-flow__action" type="button" data-mgrs-next><?php echo esc_html__('Напред', 'mindgrid-request-system'); ?></button>
            <button class="mgrs-flow__action" type="submit" data-mgrs-submit hidden><?php echo esc_html__('Изпрати заявка', 'mindgrid-request-system'); ?></button>
        </div>
    </form>
</div>
