<?php
/**
 * Main plugin orchestration.
 *
 * @package MindGrid\RequestSystem
 */

declare(strict_types=1);

namespace MindGrid\RequestSystem;

use MindGrid\RequestSystem\Admin\AdminMenu;
use MindGrid\RequestSystem\Admin\RequestColumns;
use MindGrid\RequestSystem\PostTypes\RequestPostType;
use MindGrid\RequestSystem\Statuses\RequestStatuses;

if (! defined('ABSPATH')) {
    exit;
}

final class Plugin
{
    public function run(): void
    {
        add_action('init', array(RequestPostType::class, 'register'));
        add_action('save_post_' . RequestPostType::POST_TYPE, array(RequestStatuses::class, 'ensure_default_status'), 10, 3);

        if (is_admin()) {
            add_action('admin_menu', array(AdminMenu::class, 'register'));
            add_filter('manage_' . RequestPostType::POST_TYPE . '_posts_columns', array(RequestColumns::class, 'register_columns'));
            add_action('manage_' . RequestPostType::POST_TYPE . '_posts_custom_column', array(RequestColumns::class, 'render_column'), 10, 2);
        }
    }
}
