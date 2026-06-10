<?php
/**
 * Request admin list table columns.
 *
 * @package MindGrid\RequestSystem
 */

declare(strict_types=1);

namespace MindGrid\RequestSystem\Admin;

use MindGrid\RequestSystem\Statuses\RequestStatuses;

if (! defined('ABSPATH')) {
    exit;
}

final class RequestColumns
{
    /**
     * @param array<string, string> $columns Existing columns.
     * @return array<string, string>
     */
    public static function register_columns(array $columns): array
    {
        unset($columns['cb'], $columns['title'], $columns['date']);

        return array(
            'cb' => '<input type="checkbox" />',
            'mgrs_request_id' => __('Request ID', 'mindgrid-request-system'),
            'mgrs_status' => __('Status', 'mindgrid-request-system'),
            'date' => __('Date', 'mindgrid-request-system'),
        );
    }

    public static function render_column(string $column, int $post_id): void
    {
        if ('mgrs_request_id' === $column) {
            echo esc_html((string) $post_id);
            return;
        }

        if ('mgrs_status' === $column) {
            $status = get_post_meta($post_id, RequestStatuses::META_KEY, true);
            $status = is_string($status) && RequestStatuses::is_valid($status) ? $status : RequestStatuses::DEFAULT_STATUS;

            echo esc_html(RequestStatuses::get_label($status));
        }
    }
}
