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
use MindGrid\RequestSystem\Admin\RequestListFilters;
use MindGrid\RequestSystem\Admin\RequestMetaboxes;
use MindGrid\RequestSystem\Frontend\Assets\FrontendAssets;
use MindGrid\RequestSystem\Frontend\Shortcodes\RequestFlowShortcode;
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
        add_action('init', array(RequestFlowShortcode::class, 'register'));
        add_action('wp_enqueue_scripts', array(FrontendAssets::class, 'register'));
        add_action('wp_enqueue_scripts', array(FrontendAssets::class, 'maybe_enqueue'));
        add_action('save_post_' . RequestPostType::POST_TYPE, array(RequestStatuses::class, 'ensure_default_status'), 10, 3);

        if (is_admin()) {
            add_action('admin_menu', array(AdminMenu::class, 'register'));
            add_action('add_meta_boxes_' . RequestPostType::POST_TYPE, array(RequestMetaboxes::class, 'register'));
            add_action('save_post_' . RequestPostType::POST_TYPE, array(RequestMetaboxes::class, 'save'), 20, 3);
            add_filter('manage_' . RequestPostType::POST_TYPE . '_posts_columns', array(RequestColumns::class, 'register_columns'));
            add_action('manage_' . RequestPostType::POST_TYPE . '_posts_custom_column', array(RequestColumns::class, 'render_column'), 10, 2);
            add_action('restrict_manage_posts', array(RequestListFilters::class, 'render_status_filter'));
            add_action('pre_get_posts', array(RequestListFilters::class, 'apply_status_filter'));
        }
    }
}
