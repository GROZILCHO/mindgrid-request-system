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
    private const ALLOWED_SERVICE_TYPES = array('moving', 'delivery', 'other');

    /**
     * @param array<string, string> $data
     */
    public static function is_valid(array $data): bool
    {
        if (! in_array($data['service_type'] ?? '', self::ALLOWED_SERVICE_TYPES, true)) {
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

        return true;
    }
}
