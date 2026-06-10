<?php
/**
 * Central request meta registry.
 *
 * @package MindGrid\RequestSystem
 */

declare(strict_types=1);

namespace MindGrid\RequestSystem\Meta;

use MindGrid\RequestSystem\Statuses\RequestStatuses;

if (! defined('ABSPATH')) {
    exit;
}

final class RequestMetaRegistry
{
    public const CONTACT_NAME = '_mgrs_contact_name';
    public const CONTACT_PHONE = '_mgrs_contact_phone';
    public const CONTACT_EMAIL = '_mgrs_contact_email';
    public const INTERNAL_NOTES = '_mgrs_internal_notes';
    public const CREATED_SOURCE = '_mgrs_created_source';
    public const CREATED_SOURCE_MANUAL_ADMIN = 'manual_admin';

    /**
     * @return array<string, array{key: string, label: string, type: string, sanitize: string, default?: string}>
     */
    public static function fields(): array
    {
        return array(
            RequestStatuses::META_KEY => array(
                'key' => RequestStatuses::META_KEY,
                'label' => __('Status', 'mindgrid-request-system'),
                'type' => 'select',
                'sanitize' => 'status',
                'default' => RequestStatuses::DEFAULT_STATUS,
            ),
            self::CONTACT_NAME => array(
                'key' => self::CONTACT_NAME,
                'label' => __('Contact Name', 'mindgrid-request-system'),
                'type' => 'text',
                'sanitize' => 'text',
                'default' => '',
            ),
            self::CONTACT_PHONE => array(
                'key' => self::CONTACT_PHONE,
                'label' => __('Contact Phone', 'mindgrid-request-system'),
                'type' => 'text',
                'sanitize' => 'text',
                'default' => '',
            ),
            self::CONTACT_EMAIL => array(
                'key' => self::CONTACT_EMAIL,
                'label' => __('Contact Email', 'mindgrid-request-system'),
                'type' => 'email',
                'sanitize' => 'email',
                'default' => '',
            ),
            self::INTERNAL_NOTES => array(
                'key' => self::INTERNAL_NOTES,
                'label' => __('Internal Notes', 'mindgrid-request-system'),
                'type' => 'textarea',
                'sanitize' => 'textarea',
                'default' => '',
            ),
            self::CREATED_SOURCE => array(
                'key' => self::CREATED_SOURCE,
                'label' => __('Created Source', 'mindgrid-request-system'),
                'type' => 'readonly',
                'sanitize' => 'created_source',
                'default' => self::CREATED_SOURCE_MANUAL_ADMIN,
            ),
        );
    }

    public static function sanitize_value(string $key, string $value): string
    {
        $fields = self::fields();
        $strategy = $fields[$key]['sanitize'] ?? 'text';

        if ('status' === $strategy) {
            return RequestStatuses::is_valid($value) ? $value : RequestStatuses::DEFAULT_STATUS;
        }

        if ('email' === $strategy) {
            return sanitize_email($value);
        }

        if ('textarea' === $strategy) {
            return sanitize_textarea_field($value);
        }

        if ('created_source' === $strategy) {
            $source = sanitize_key($value);

            return '' !== $source ? $source : self::CREATED_SOURCE_MANUAL_ADMIN;
        }

        return sanitize_text_field($value);
    }

    public static function default_value(string $key): string
    {
        $fields = self::fields();

        return $fields[$key]['default'] ?? '';
    }
}
