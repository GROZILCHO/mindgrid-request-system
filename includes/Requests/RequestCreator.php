<?php
/**
 * Request creation service.
 *
 * @package MindGrid\RequestSystem
 */

declare(strict_types=1);

namespace MindGrid\RequestSystem\Requests;

use MindGrid\RequestSystem\Meta\RequestMetaRegistry;
use MindGrid\RequestSystem\PostTypes\RequestPostType;
use MindGrid\RequestSystem\Statuses\RequestStatuses;

if (! defined('ABSPATH')) {
    exit;
}

final class RequestCreator
{
    public const CREATED_SOURCE_FRONTEND_FORM = 'frontend_form';

    /**
     * @param array<string, string> $data
     */
    public static function create_from_frontend_submission(array $data): int
    {
        $post_id = wp_insert_post(
            array(
                'post_type' => RequestPostType::POST_TYPE,
                'post_status' => 'publish',
                'post_title' => __('Frontend Request', 'mindgrid-request-system'),
                'post_content' => '',
            ),
            true
        );

        if (is_wp_error($post_id) || ! is_int($post_id) || $post_id <= 0) {
            return 0;
        }

        wp_update_post(
            array(
                'ID' => $post_id,
                'post_title' => 'MRS-' . $post_id,
            )
        );

        update_post_meta($post_id, RequestStatuses::META_KEY, RequestStatuses::DEFAULT_STATUS);
        update_post_meta($post_id, RequestMetaRegistry::CREATED_SOURCE, self::CREATED_SOURCE_FRONTEND_FORM);
        update_post_meta($post_id, RequestMetaRegistry::CONTACT_NAME, $data['contact_name']);
        update_post_meta($post_id, RequestMetaRegistry::CONTACT_PHONE, $data['contact_phone']);
        update_post_meta($post_id, RequestMetaRegistry::CONTACT_EMAIL, $data['contact_email']);
        update_post_meta($post_id, RequestMetaRegistry::SERVICE_TYPE, $data['service_type']);
        update_post_meta($post_id, RequestMetaRegistry::CONTACT_TIME, $data['contact_time']);
        update_post_meta($post_id, RequestMetaRegistry::REQUEST_URGENCY, $data['request_urgency']);
        update_post_meta($post_id, RequestMetaRegistry::SUBMISSION_SUMMARY, self::build_submission_summary($data));

        return $post_id;
    }

    /**
     * @param array<string, string> $data
     */
    private static function build_submission_summary(array $data): string
    {
        $lines = array();
        $estimate = DemoEstimateCalculator::calculate($data);

        $lines[] = __('УСЛУГА', 'mindgrid-request-system');
        $lines[] = self::label_for('service_type', $data['service_type'] ?? '');
        $lines[] = '';
        $lines[] = __('ЛОКАЦИЯ', 'mindgrid-request-system');
        $lines[] = __('Град/район:', 'mindgrid-request-system') . ' ' . self::value_or_dash($data['city_area'] ?? '');
        $lines[] = __('От:', 'mindgrid-request-system') . ' ' . self::value_or_dash($data['from_address'] ?? '');
        $lines[] = __('До:', 'mindgrid-request-system') . ' ' . self::value_or_dash($data['to_address'] ?? '');
        $lines[] = '';
        $lines[] = __('ДОСТЪП', 'mindgrid-request-system');
        $lines[] = __('Етаж:', 'mindgrid-request-system') . ' ' . self::value_or_dash($data['floor'] ?? '');
        $lines[] = __('Асансьор:', 'mindgrid-request-system') . ' ' . self::label_or_dash('yes_no', $data['has_elevator'] ?? '');
        $lines[] = __('Паркиране:', 'mindgrid-request-system') . ' ' . self::value_or_dash($data['parking_access'] ?? '');
        $lines[] = __('Примерно разстояние в км:', 'mindgrid-request-system') . ' ' . self::value_or_dash($data['demo_distance_km'] ?? '');
        $lines[] = '';
        $lines[] = __('ТОВАР', 'mindgrid-request-system');
        $lines[] = __('Описание:', 'mindgrid-request-system') . ' ' . self::value_or_dash($data['items_description'] ?? '');
        $lines[] = __('Кашони/чували:', 'mindgrid-request-system') . ' ' . self::value_or_dash($data['boxes_bags_count'] ?? '');
        $lines[] = __('Тежки предмети:', 'mindgrid-request-system') . ' ' . self::value_or_dash($data['heavy_items'] ?? '');
        $lines[] = __('Разглобяване:', 'mindgrid-request-system') . ' ' . self::label_or_dash('yes_no', $data['disassembly_needed'] ?? '');
        $lines[] = '';
        $lines[] = __('ДОПЪЛНИТЕЛНИ УСЛУГИ', 'mindgrid-request-system');
        $lines[] = self::extra_services_labels($data['extra_services'] ?? '');
        $lines[] = '';
        $lines[] = __('БЕЛЕЖКИ', 'mindgrid-request-system');
        $lines[] = self::value_or_dash($data['notes'] ?? '');
        $lines[] = '';
        $lines[] = __('КОНТАКТ', 'mindgrid-request-system');
        $lines[] = __('Име:', 'mindgrid-request-system') . ' ' . self::value_or_dash($data['contact_name'] ?? '');
        $lines[] = __('Телефон:', 'mindgrid-request-system') . ' ' . self::value_or_dash($data['contact_phone'] ?? '');
        $lines[] = __('Email:', 'mindgrid-request-system') . ' ' . self::value_or_dash($data['contact_email'] ?? '');
        $lines[] = __('Удобно време:', 'mindgrid-request-system') . ' ' . self::value_or_dash($data['contact_time'] ?? '');
        $lines[] = __('Спешност:', 'mindgrid-request-system') . ' ' . self::label_or_not_specified('request_urgency', $data['request_urgency'] ?? '');
        $lines[] = '';
        $lines[] = __('ОРИЕНТИРОВЪЧНА ЦЕНА', 'mindgrid-request-system');
        $lines[] = DemoEstimateCalculator::format_range($estimate);
        $lines[] = '';
        $lines[] = __('МЕТОД НА ИЗЧИСЛЕНИЕ', 'mindgrid-request-system');
        $lines[] = __('Базова услуга + обем + достъп + разстояние + допълнителни услуги', 'mindgrid-request-system');
        $lines[] = __('Тази цена е ориентировъчна и не представлява финална оферта. Крайната цена се потвърждава след преглед на заявката.', 'mindgrid-request-system');

        return implode("\n", $lines);
    }

    private static function value_or_dash(string $value): string
    {
        return '' !== $value ? $value : '-';
    }

    private static function label_or_dash(string $group, string $value): string
    {
        $label = self::label_for($group, $value);

        return '' !== $label ? $label : '-';
    }

    private static function label_or_not_specified(string $group, string $value): string
    {
        $label = self::label_for($group, $value);

        return '' !== $label ? $label : __('Не е посочено', 'mindgrid-request-system');
    }

    private static function label_for(string $group, string $value): string
    {
        $labels = array(
            'service_type' => array(
                'moving_home' => __('Преместване на жилище', 'mindgrid-request-system'),
                'moving_office' => __('Преместване на офис', 'mindgrid-request-system'),
                'moving_helpers' => __('Хамалски услуги', 'mindgrid-request-system'),
                'transport_van' => __('Транспорт с бус', 'mindgrid-request-system'),
                'clearing' => __('Изхвърляне / разчистване', 'mindgrid-request-system'),
                'other' => __('Друго', 'mindgrid-request-system'),
            ),
            'yes_no' => array(
                'yes' => __('Да', 'mindgrid-request-system'),
                'no' => __('Не', 'mindgrid-request-system'),
            ),
            'request_urgency' => array(
                'urgent' => __('Спешно', 'mindgrid-request-system'),
                'this_week' => __('Тази седмица', 'mindgrid-request-system'),
                'flexible' => __('Гъвкаво', 'mindgrid-request-system'),
            ),
            'extra_services' => array(
                'packing' => __('Опаковане', 'mindgrid-request-system'),
                'disassembly' => __('Демонтаж', 'mindgrid-request-system'),
                'assembly' => __('Монтаж', 'mindgrid-request-system'),
                'disposal' => __('Изхвърляне', 'mindgrid-request-system'),
                'carry_up_stairs' => __('Качване по стълби', 'mindgrid-request-system'),
                'carry_down_stairs' => __('Сваляне по стълби', 'mindgrid-request-system'),
            ),
        );

        return $labels[$group][$value] ?? $value;
    }

    private static function extra_services_labels(string $value): string
    {
        if ('' === $value) {
            return '-';
        }

        $labels = array();

        foreach (explode(',', $value) as $item) {
            $labels[] = self::label_for('extra_services', $item);
        }

        return implode(', ', $labels);
    }
}
