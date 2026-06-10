<?php
/**
 * Plugin activation tasks.
 *
 * @package MindGrid\RequestSystem
 */

declare(strict_types=1);

namespace MindGrid\RequestSystem;

use MindGrid\RequestSystem\PostTypes\RequestPostType;

if (! defined('ABSPATH')) {
    exit;
}

final class Activator
{
    public static function activate(): void
    {
        RequestPostType::register();
        flush_rewrite_rules();
    }
}
