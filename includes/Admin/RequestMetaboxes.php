<?php
/**
 * Request admin metaboxes and save handling.
 *
 * @package MindGrid\RequestSystem
 */

declare(strict_types=1);

namespace MindGrid\RequestSystem\Admin;

use MindGrid\RequestSystem\Capabilities\Capabilities;
use MindGrid\RequestSystem\Meta\RequestMetaRegistry;
use MindGrid\RequestSystem\PostTypes\RequestPostType;
use MindGrid\RequestSystem\Statuses\RequestStatuses;

if (! defined('ABSPATH')) {
    exit;
}

final class RequestMetaboxes
{
    private const NONCE_ACTION = 'mgrs_save_request_meta';
    private const NONCE_NAME = 'mgrs_request_meta_nonce';

    public static function register(): void
    {
        add_meta_box(
            'mgrs_request_status',
            __('Request Status', 'mindgrid-request-system'),
            array(self::class, 'render_status_metabox'),
            RequestPostType::POST_TYPE,
            'side',
            'high'
        );

        add_meta_box(
            'mgrs_contact_information',
            __('Contact Information', 'mindgrid-request-system'),
            array(self::class, 'render_contact_metabox'),
            RequestPostType::POST_TYPE,
            'normal',
            'default'
        );

        add_meta_box(
            'mgrs_internal_notes',
            __('Internal Notes', 'mindgrid-request-system'),
            array(self::class, 'render_internal_notes_metabox'),
            RequestPostType::POST_TYPE,
            'normal',
            'default'
        );
    }

    public static function render_status_metabox(\WP_Post $post): void
    {
        wp_nonce_field(self::NONCE_ACTION, self::NONCE_NAME);

        $status = self::get_status($post->ID);
        $source = self::get_created_source($post->ID);

        echo '<p><label for="mgrs_status"><strong>' . esc_html__('Status', 'mindgrid-request-system') . '</strong></label></p>';
        echo '<select id="mgrs_status" name="mgrs_status" class="widefat">';

        foreach (RequestStatuses::all() as $value => $label) {
            echo '<option value="' . esc_attr($value) . '"' . selected($status, $value, false) . '>' . esc_html($label) . '</option>';
        }

        echo '</select>';
        echo '<p><strong>' . esc_html__('Request ID', 'mindgrid-request-system') . '</strong><br>' . esc_html(self::format_request_id($post->ID)) . '</p>';
        echo '<p><strong>' . esc_html__('Created Source', 'mindgrid-request-system') . '</strong><br><code>' . esc_html($source) . '</code></p>';
    }

    public static function render_contact_metabox(\WP_Post $post): void
    {
        $fields = array(
            RequestMetaRegistry::CONTACT_NAME => 'mgrs_contact_name',
            RequestMetaRegistry::CONTACT_PHONE => 'mgrs_contact_phone',
            RequestMetaRegistry::CONTACT_EMAIL => 'mgrs_contact_email',
        );
        $registry = RequestMetaRegistry::fields();

        foreach ($fields as $meta_key => $field_name) {
            $value = get_post_meta($post->ID, $meta_key, true);
            $value = is_string($value) ? $value : '';

            echo '<p>';
            echo '<label for="' . esc_attr($field_name) . '"><strong>' . esc_html($registry[$meta_key]['label']) . '</strong></label>';
            echo '<input type="text" id="' . esc_attr($field_name) . '" name="' . esc_attr($field_name) . '" value="' . esc_attr($value) . '" class="widefat">';
            echo '</p>';
        }
    }

    public static function render_internal_notes_metabox(\WP_Post $post): void
    {
        $value = get_post_meta($post->ID, RequestMetaRegistry::INTERNAL_NOTES, true);
        $value = is_string($value) ? $value : '';

        echo '<p><label for="mgrs_internal_notes"><strong>' . esc_html__('Internal Notes', 'mindgrid-request-system') . '</strong></label></p>';
        echo '<textarea id="mgrs_internal_notes" name="mgrs_internal_notes" rows="6" class="widefat">' . esc_textarea($value) . '</textarea>';
    }

    public static function save(int $post_id, \WP_Post $post, bool $update): void
    {
        unset($post, $update);

        if (wp_is_post_autosave($post_id) || wp_is_post_revision($post_id)) {
            return;
        }

        if (! isset($_POST[self::NONCE_NAME]) || ! is_string($_POST[self::NONCE_NAME])) {
            return;
        }

        $nonce = sanitize_text_field(wp_unslash($_POST[self::NONCE_NAME]));

        if (! wp_verify_nonce($nonce, self::NONCE_ACTION)) {
            return;
        }

        if (! current_user_can(Capabilities::admin_capability())) {
            return;
        }

        self::save_field($post_id, RequestStatuses::META_KEY, 'mgrs_status');
        self::save_field($post_id, RequestMetaRegistry::CONTACT_NAME, 'mgrs_contact_name');
        self::save_field($post_id, RequestMetaRegistry::CONTACT_PHONE, 'mgrs_contact_phone');
        self::save_field($post_id, RequestMetaRegistry::CONTACT_EMAIL, 'mgrs_contact_email');
        self::save_field($post_id, RequestMetaRegistry::INTERNAL_NOTES, 'mgrs_internal_notes');

        if (! metadata_exists('post', $post_id, RequestMetaRegistry::CREATED_SOURCE)) {
            update_post_meta($post_id, RequestMetaRegistry::CREATED_SOURCE, RequestMetaRegistry::CREATED_SOURCE_MANUAL_ADMIN);
        }
    }

    public static function format_request_id(int $post_id): string
    {
        return 'MRS-' . $post_id;
    }

    private static function save_field(int $post_id, string $meta_key, string $post_key): void
    {
        if (! isset($_POST[$post_key]) || ! is_string($_POST[$post_key])) {
            return;
        }

        $value = RequestMetaRegistry::sanitize_value($meta_key, wp_unslash($_POST[$post_key]));
        update_post_meta($post_id, $meta_key, $value);
    }

    private static function get_status(int $post_id): string
    {
        $status = get_post_meta($post_id, RequestStatuses::META_KEY, true);

        return is_string($status) && RequestStatuses::is_valid($status) ? $status : RequestStatuses::DEFAULT_STATUS;
    }

    private static function get_created_source(int $post_id): string
    {
        $source = get_post_meta($post_id, RequestMetaRegistry::CREATED_SOURCE, true);

        return is_string($source) && '' !== $source ? $source : RequestMetaRegistry::CREATED_SOURCE_MANUAL_ADMIN;
    }
}
