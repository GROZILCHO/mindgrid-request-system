<?php
/**
 * Request status registry.
 *
 * @package MindGrid\RequestSystem
 */

declare(strict_types=1);

namespace MindGrid\RequestSystem\Statuses;

if (! defined('ABSPATH')) {
    exit;
}

final class RequestStatuses
{
    public const META_KEY = '_mgrs_status';
    public const DEFAULT_STATUS = 'new';

    /**
     * @return array<string, string>
     */
    public static function all(): array
    {
        return array(
            'new' => __('New', 'mindgrid-request-system'),
            'reviewing' => __('Reviewing', 'mindgrid-request-system'),
            'needs_info' => __('Needs Info', 'mindgrid-request-system'),
            'quoted' => __('Quoted', 'mindgrid-request-system'),
            'confirmed' => __('Confirmed', 'mindgrid-request-system'),
            'completed' => __('Completed', 'mindgrid-request-system'),
            'cancelled' => __('Cancelled', 'mindgrid-request-system'),
        );
    }

    public static function is_valid(string $status): bool
    {
        return array_key_exists($status, self::all());
    }

    public static function get_label(string $status): string
    {
        $statuses = self::all();

        return $statuses[$status] ?? $statuses[self::DEFAULT_STATUS];
    }

    public static function ensure_default_status(int $post_id, \WP_Post $post, bool $update): void
    {
        unset($post, $update);

        if (wp_is_post_revision($post_id) || wp_is_post_autosave($post_id)) {
            return;
        }

        $current_status = get_post_meta($post_id, self::META_KEY, true);

        if (! is_string($current_status) || ! self::is_valid($current_status)) {
            update_post_meta($post_id, self::META_KEY, self::DEFAULT_STATUS);
        }
    }
}
