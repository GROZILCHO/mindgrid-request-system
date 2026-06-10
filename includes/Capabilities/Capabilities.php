<?php
/**
 * Capability definitions.
 *
 * @package MindGrid\RequestSystem
 */

declare(strict_types=1);

namespace MindGrid\RequestSystem\Capabilities;

if (! defined('ABSPATH')) {
    exit;
}

final class Capabilities
{
    public const MANAGE_REQUESTS = 'manage_mgrs_requests';

    public static function admin_capability(): string
    {
        return 'manage_options';
    }

    /**
     * Sprint 1 intentionally gates request management to administrators.
     *
     * @return array<string, string>
     */
    public static function administrator_only_post_type_capabilities(): array
    {
        $capability = self::admin_capability();

        return array(
            'edit_post' => $capability,
            'read_post' => $capability,
            'delete_post' => $capability,
            'edit_posts' => $capability,
            'edit_others_posts' => $capability,
            'delete_posts' => $capability,
            'publish_posts' => $capability,
            'read_private_posts' => $capability,
            'delete_private_posts' => $capability,
            'delete_published_posts' => $capability,
            'delete_others_posts' => $capability,
            'edit_private_posts' => $capability,
            'edit_published_posts' => $capability,
        );
    }
}
