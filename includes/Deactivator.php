<?php
/**
 * Plugin deactivation tasks.
 *
 * @package MindGrid\RequestSystem
 */

declare(strict_types=1);

namespace MindGrid\RequestSystem;

if (! defined('ABSPATH')) {
    exit;
}

final class Deactivator
{
    public static function deactivate(): void
    {
        flush_rewrite_rules();
    }
}
