<?php
/**
 * Request custom post type registration.
 *
 * @package MindGrid\RequestSystem
 */

declare(strict_types=1);

namespace MindGrid\RequestSystem\PostTypes;

use MindGrid\RequestSystem\Capabilities\Capabilities;

if (! defined('ABSPATH')) {
    exit;
}

final class RequestPostType
{
    public const POST_TYPE = 'mgrs_request';

    public static function register(): void
    {
        $labels = array(
            'name' => __('MindGrid Requests', 'mindgrid-request-system'),
            'singular_name' => __('MindGrid Request', 'mindgrid-request-system'),
            'menu_name' => __('MindGrid Requests', 'mindgrid-request-system'),
            'name_admin_bar' => __('MindGrid Request', 'mindgrid-request-system'),
            'add_new' => __('Add New', 'mindgrid-request-system'),
            'add_new_item' => __('Add New Request', 'mindgrid-request-system'),
            'edit_item' => __('Edit Request', 'mindgrid-request-system'),
            'new_item' => __('New Request', 'mindgrid-request-system'),
            'view_item' => __('View Request', 'mindgrid-request-system'),
            'search_items' => __('Search Requests', 'mindgrid-request-system'),
            'not_found' => __('No requests found.', 'mindgrid-request-system'),
            'not_found_in_trash' => __('No requests found in Trash.', 'mindgrid-request-system'),
            'all_items' => __('All Requests', 'mindgrid-request-system'),
        );

        register_post_type(
            self::POST_TYPE,
            array(
                'labels' => $labels,
                'description' => __('Internal request records managed by MindGrid Request System.', 'mindgrid-request-system'),
                'public' => false,
                'publicly_queryable' => false,
                'exclude_from_search' => true,
                'show_ui' => true,
                'show_in_menu' => false,
                'show_in_admin_bar' => true,
                'show_in_nav_menus' => false,
                'show_in_rest' => false,
                'has_archive' => false,
                'rewrite' => false,
                'query_var' => false,
                'supports' => array('title'),
                'capabilities' => Capabilities::administrator_only_post_type_capabilities(),
                'map_meta_cap' => false,
            )
        );
    }
}
