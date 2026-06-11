<?php
/**
 * Request admin list filters.
 *
 * @package MindGrid\RequestSystem
 */

declare(strict_types=1);

namespace MindGrid\RequestSystem\Admin;

use MindGrid\RequestSystem\PostTypes\RequestPostType;
use MindGrid\RequestSystem\Statuses\RequestStatuses;

if (! defined('ABSPATH')) {
    exit;
}

final class RequestListFilters
{
    public static function render_status_filter(string $post_type): void
    {
        if (RequestPostType::POST_TYPE !== $post_type) {
            return;
        }

        $selected = '';

        if (isset($_GET['mgrs_status_filter']) && is_string($_GET['mgrs_status_filter'])) {
            $requested_status = sanitize_key(wp_unslash($_GET['mgrs_status_filter']));
            $selected = RequestStatuses::is_valid($requested_status) ? $requested_status : '';
        }

        echo '<label class="screen-reader-text" for="mgrs_status_filter">' . esc_html__('Filter by request status', 'mindgrid-request-system') . '</label>';
        echo '<select id="mgrs_status_filter" name="mgrs_status_filter">';
        echo '<option value="">' . esc_html__('All statuses', 'mindgrid-request-system') . '</option>';

        foreach (RequestStatuses::all() as $status => $label) {
            echo '<option value="' . esc_attr($status) . '"' . selected($selected, $status, false) . '>' . esc_html($label) . '</option>';
        }

        echo '</select>';
    }

    public static function apply_status_filter(\WP_Query $query): void
    {
        global $pagenow;

        if (! is_admin() || ! $query->is_main_query() || 'edit.php' !== $pagenow) {
            return;
        }

        if (RequestPostType::POST_TYPE !== $query->get('post_type')) {
            return;
        }

        if (! isset($_GET['mgrs_status_filter']) || ! is_string($_GET['mgrs_status_filter'])) {
            return;
        }

        $status = sanitize_key(wp_unslash($_GET['mgrs_status_filter']));

        if (! RequestStatuses::is_valid($status)) {
            return;
        }

        if (RequestStatuses::DEFAULT_STATUS === $status) {
            $query->set(
                'meta_query',
                array(
                    'relation' => 'OR',
                    array(
                        'key' => RequestStatuses::META_KEY,
                        'value' => $status,
                        'compare' => '=',
                    ),
                    array(
                        'key' => RequestStatuses::META_KEY,
                        'compare' => 'NOT EXISTS',
                    ),
                )
            );
            return;
        }

        $query->set(
            'meta_query',
            array(
                array(
                    'key' => RequestStatuses::META_KEY,
                    'value' => $status,
                    'compare' => '=',
                ),
            )
        );
    }
}
