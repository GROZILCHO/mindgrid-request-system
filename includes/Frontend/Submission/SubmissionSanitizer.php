<?php
/**
 * Frontend request submission sanitization.
 *
 * @package MindGrid\RequestSystem
 */

declare(strict_types=1);

namespace MindGrid\RequestSystem\Frontend\Submission;

if (! defined('ABSPATH')) {
    exit;
}

final class SubmissionSanitizer
{
    /**
     * @return array<string, string>
     */
    public static function sanitize(array $input): array
    {
        return array(
            'service_type' => self::sanitize_key_field($input, 'service_type'),
            'city_area' => self::sanitize_text_field($input, 'city_area'),
            'floor' => self::sanitize_text_field($input, 'floor'),
            'has_elevator' => self::sanitize_key_field($input, 'has_elevator'),
            'parking_access' => self::sanitize_text_field($input, 'parking_access'),
            'items' => self::sanitize_textarea_field($input, 'items'),
            'extra_services' => self::sanitize_textarea_field($input, 'extra_services'),
            'notes' => self::sanitize_textarea_field($input, 'notes'),
            'contact_name' => self::sanitize_text_field($input, 'contact_name'),
            'contact_phone' => self::sanitize_text_field($input, 'contact_phone'),
            'contact_email' => self::sanitize_email_field($input, 'contact_email'),
        );
    }

    private static function sanitize_key_field(array $input, string $key): string
    {
        $value = self::string_value($input, $key);

        return sanitize_key($value);
    }

    private static function sanitize_text_field(array $input, string $key): string
    {
        $value = self::string_value($input, $key);

        return sanitize_text_field($value);
    }

    private static function sanitize_textarea_field(array $input, string $key): string
    {
        $value = self::string_value($input, $key);
        $value = sanitize_textarea_field($value);

        return substr($value, 0, 2000);
    }

    private static function sanitize_email_field(array $input, string $key): string
    {
        $value = self::string_value($input, $key);

        return sanitize_email($value);
    }

    private static function string_value(array $input, string $key): string
    {
        if (! isset($input[$key]) || ! is_string($input[$key])) {
            return '';
        }

        return trim(wp_unslash($input[$key]));
    }
}
