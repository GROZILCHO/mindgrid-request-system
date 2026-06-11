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
        update_post_meta($post_id, RequestMetaRegistry::SUBMISSION_SUMMARY, self::build_submission_summary($data));

        return $post_id;
    }

    /**
     * @param array<string, string> $data
     */
    private static function build_submission_summary(array $data): string
    {
        $labels = array(
            'service_type' => __('Service type', 'mindgrid-request-system'),
            'city_area' => __('City / area', 'mindgrid-request-system'),
            'floor' => __('Floor', 'mindgrid-request-system'),
            'has_elevator' => __('Elevator', 'mindgrid-request-system'),
            'parking_access' => __('Parking', 'mindgrid-request-system'),
            'items' => __('Items', 'mindgrid-request-system'),
            'extra_services' => __('Extra services', 'mindgrid-request-system'),
            'notes' => __('Notes', 'mindgrid-request-system'),
        );
        $lines = array();

        foreach ($labels as $key => $label) {
            $value = $data[$key] ?? '';

            if ('' === $value) {
                continue;
            }

            $lines[] = $label . ': ' . $value;
        }

        return implode("\n", $lines);
    }
}
