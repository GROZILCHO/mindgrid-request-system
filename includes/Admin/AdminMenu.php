<?php
/**
 * Admin menu registration.
 *
 * @package MindGrid\RequestSystem
 */

declare(strict_types=1);

namespace MindGrid\RequestSystem\Admin;

use MindGrid\RequestSystem\Capabilities\Capabilities;
use MindGrid\RequestSystem\PostTypes\RequestPostType;

if (! defined('ABSPATH')) {
    exit;
}

final class AdminMenu
{
    public static function register(): void
    {
        add_menu_page(
            __('MindGrid Requests', 'mindgrid-request-system'),
            __('MindGrid Requests', 'mindgrid-request-system'),
            Capabilities::admin_capability(),
            'edit.php?post_type=' . RequestPostType::POST_TYPE,
            '',
            'dashicons-feedback',
            26
        );
    }
}
