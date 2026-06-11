<?php
/**
 * Frontend request submission validation.
 *
 * @package MindGrid\RequestSystem
 */

declare(strict_types=1);

namespace MindGrid\RequestSystem\Frontend\Submission;

if (! defined('ABSPATH')) {
    exit;
}

final class SubmissionValidator
{
    /**
     * @var string[]
     */
    private const ALLOWED_SERVICE_TYPES = array('moving_home', 'moving_office', 'moving_helpers', 'transport_van', 'clearing', 'other');

    /**
     * @var string[]
     */
    private const ALLOWED_EXTRA_SERVICES = array('packing', 'disassembly', 'assembly', 'disposal', 'carry_up_stairs', 'carry_down_stairs');

    /**
     * @var string[]
     */
    private const ALLOWED_REQUEST_URGENCIES = array('urgent', 'this_week', 'flexible');

    /**
     * @param array<string, string> $data
     */
    public static function is_valid(array $data): bool
    {
        if (! in_array($data['service_type'] ?? '', self::ALLOWED_SERVICE_TYPES, true)) {
            return false;
        }

        if ('' === ($data['city_area'] ?? '')) {
            return false;
        }

        if ('' === ($data['contact_name'] ?? '')) {
            return false;
        }

        if ('' === ($data['contact_phone'] ?? '')) {
            return false;
        }

        if ('' !== ($data['contact_email'] ?? '') && ! is_email($data['contact_email'])) {
            return false;
        }

        if (! self::is_allowed_list($data['extra_services'] ?? '', self::ALLOWED_EXTRA_SERVICES)) {
            return false;
        }

        if ('' !== ($data['request_urgency'] ?? '') && ! in_array($data['request_urgency'], self::ALLOWED_REQUEST_URGENCIES, true)) {
            return false;
        }

        return true;
    }

    /**
     * @param string[] $allowed
     */
    private static function is_allowed_list(string $value, array $allowed): bool
    {
        if ('' === $value) {
            return true;
        }

        foreach (explode(',', $value) as $item) {
            if (! in_array($item, $allowed, true)) {
                return false;
            }
        }

        return true;
    }
}
