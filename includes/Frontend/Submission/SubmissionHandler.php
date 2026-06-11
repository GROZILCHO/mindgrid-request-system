<?php
/**
 * Frontend request submission handler.
 *
 * @package MindGrid\RequestSystem
 */

declare(strict_types=1);

namespace MindGrid\RequestSystem\Frontend\Submission;

use MindGrid\RequestSystem\Requests\RequestCreator;

if (! defined('ABSPATH')) {
    exit;
}

final class SubmissionHandler
{
    public const ACTION = 'mgrs_submit_request';
    public const NONCE_ACTION = 'mgrs_submit_request';
    public const NONCE_NAME = 'mgrs_request_flow_nonce';
    public const HONEYPOT_NAME = 'mgrs_company_website';

    public static function handle(): void
    {
        if ('POST' !== ($_SERVER['REQUEST_METHOD'] ?? '')) {
            self::redirect_with_failure();
        }

        if (! self::has_valid_nonce()) {
            self::redirect_with_failure();
        }

        if (! self::has_empty_honeypot()) {
            self::redirect_with_failure();
        }

        $data = SubmissionSanitizer::sanitize($_POST);

        if (! SubmissionValidator::is_valid($data)) {
            self::redirect_with_failure();
        }

        $post_id = RequestCreator::create_from_frontend_submission($data);

        if ($post_id <= 0) {
            self::redirect_with_failure();
        }

        self::redirect_with_success($post_id);
    }

    private static function has_valid_nonce(): bool
    {
        if (! isset($_POST[self::NONCE_NAME]) || ! is_string($_POST[self::NONCE_NAME])) {
            return false;
        }

        $nonce = sanitize_text_field(wp_unslash($_POST[self::NONCE_NAME]));

        return (bool) wp_verify_nonce($nonce, self::NONCE_ACTION);
    }

    private static function has_empty_honeypot(): bool
    {
        if (! isset($_POST[self::HONEYPOT_NAME])) {
            return true;
        }

        if (! is_string($_POST[self::HONEYPOT_NAME])) {
            return false;
        }

        return '' === trim(wp_unslash($_POST[self::HONEYPOT_NAME]));
    }

    private static function redirect_with_success(int $post_id): void
    {
        $url = self::redirect_url(
            array(
                'mgrs_flow_status' => 'success',
                'mgrs_request_id' => 'MRS-' . $post_id,
            )
        );

        wp_safe_redirect($url);
        exit;
    }

    private static function redirect_with_failure(): void
    {
        $url = self::redirect_url(
            array(
                'mgrs_flow_status' => 'error',
            )
        );

        wp_safe_redirect($url);
        exit;
    }

    /**
     * @param array<string, string> $args
     */
    private static function redirect_url(array $args): string
    {
        $fallback = home_url('/');
        $referer = wp_get_referer();
        $url = is_string($referer) && '' !== $referer ? $referer : $fallback;
        $url = remove_query_arg(array('mgrs_flow_status', 'mgrs_request_id'), $url);

        return add_query_arg($args, $url);
    }
}
