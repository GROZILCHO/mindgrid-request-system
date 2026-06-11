<?php
/**
 * Smart Request Flow prototype shortcode.
 *
 * @package MindGrid\RequestSystem
 */

declare(strict_types=1);

namespace MindGrid\RequestSystem\Frontend\Shortcodes;

use MindGrid\RequestSystem\Frontend\Assets\FrontendAssets;

if (! defined('ABSPATH')) {
    exit;
}

final class RequestFlowShortcode
{
    public const SHORTCODE = 'mindgrid_request_flow';

    public static function register(): void
    {
        add_shortcode(self::SHORTCODE, array(self::class, 'render'));
    }

    /**
     * @param mixed $atts Shortcode attributes.
     */
    public static function render($atts = array()): string
    {
        unset($atts);

        FrontendAssets::enqueue();

        $template = MGRS_PLUGIN_DIR . 'templates/request-flow.php';

        if (! is_readable($template)) {
            return '';
        }

        ob_start();
        require $template;

        return (string) ob_get_clean();
    }
}
