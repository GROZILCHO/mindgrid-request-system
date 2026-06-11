<?php
/**
 * Frontend asset loading.
 *
 * @package MindGrid\RequestSystem
 */

declare(strict_types=1);

namespace MindGrid\RequestSystem\Frontend\Assets;

if (! defined('ABSPATH')) {
    exit;
}

final class FrontendAssets
{
    public const STYLE_HANDLE = 'mgrs-request-flow';
    public const SCRIPT_HANDLE = 'mgrs-request-flow';

    public static function register(): void
    {
        wp_register_style(
            self::STYLE_HANDLE,
            MGRS_PLUGIN_URL . 'assets/frontend/request-flow.css',
            array(),
            MGRS_VERSION
        );

        wp_register_script(
            self::SCRIPT_HANDLE,
            MGRS_PLUGIN_URL . 'assets/frontend/request-flow.js',
            array(),
            MGRS_VERSION,
            true
        );
    }

    public static function maybe_enqueue(): void
    {
        if (! is_singular()) {
            return;
        }

        $post = get_post();

        if (! $post instanceof \WP_Post || ! has_shortcode($post->post_content, 'mindgrid_request_flow')) {
            return;
        }

        self::enqueue();
    }

    public static function enqueue(): void
    {
        wp_enqueue_style(self::STYLE_HANDLE);
        wp_enqueue_script(self::SCRIPT_HANDLE);
    }
}
