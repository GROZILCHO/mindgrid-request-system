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
            'from_address' => self::sanitize_text_field($input, 'from_address'),
            'to_address' => self::sanitize_text_field($input, 'to_address'),
            'floor' => self::sanitize_text_field($input, 'floor'),
            'has_elevator' => self::sanitize_key_field($input, 'has_elevator'),
            'parking_access' => self::sanitize_text_field($input, 'parking_access'),
            'demo_distance_km' => self::sanitize_number_field($input, 'demo_distance_km', 300),
            'items_description' => self::sanitize_textarea_field($input, 'items_description'),
            'boxes_bags_count' => self::sanitize_text_field($input, 'boxes_bags_count'),
            'heavy_items' => self::sanitize_textarea_field($input, 'heavy_items'),
            'disassembly_needed' => self::sanitize_key_field($input, 'disassembly_needed'),
            'extra_services' => self::sanitize_key_list_field($input, 'extra_services'),
            'notes' => self::sanitize_textarea_field($input, 'notes'),
            'contact_name' => self::sanitize_text_field($input, 'contact_name'),
            'contact_phone' => self::sanitize_text_field($input, 'contact_phone'),
            'contact_email' => self::sanitize_email_field($input, 'contact_email'),
            'contact_time' => self::sanitize_text_field($input, 'contact_time'),
            'request_urgency' => self::sanitize_key_field($input, 'request_urgency'),
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

    private static function sanitize_number_field(array $input, string $key, float $max): string
    {
        $value = str_replace(',', '.', self::string_value($input, $key));

        if ('' === $value || ! is_numeric($value)) {
            return '0';
        }

        $number = min($max, max(0, (float) $value));
        $formatted = number_format($number, 2, '.', '');

        return rtrim(rtrim($formatted, '0'), '.');
    }

    private static function sanitize_key_list_field(array $input, string $key): string
    {
        if (! isset($input[$key]) || ! is_array($input[$key])) {
            return '';
        }

        $values = array();

        foreach ($input[$key] as $value) {
            if (! is_string($value)) {
                continue;
            }

            $sanitized = sanitize_key(wp_unslash($value));

            if ('' !== $sanitized) {
                $values[] = $sanitized;
            }
        }

        return implode(',', array_unique($values));
    }

    private static function string_value(array $input, string $key): string
    {
        if (! isset($input[$key]) || ! is_string($input[$key])) {
            return '';
        }

        return trim(wp_unslash($input[$key]));
    }
}
