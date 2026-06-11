<?php
/**
 * Plugin Name: MindGrid Request System
 * Plugin URI: https://mindgridstudio.com/
 * Description: Reusable request management foundation for MindGrid Studio WordPress projects.
 * Version: 0.3.0
 * Requires at least: 6.4
 * Requires PHP: 8.0
 * Author: MindGrid Studio
 * Author URI: https://mindgridstudio.com/
 * Text Domain: mindgrid-request-system
 * Domain Path: /languages
 *
 * @package MindGrid\RequestSystem
 */

declare(strict_types=1);

if (! defined('ABSPATH')) {
    exit;
}

define('MGRS_VERSION', '0.3.0');
define('MGRS_PLUGIN_FILE', __FILE__);
define('MGRS_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('MGRS_PLUGIN_URL', plugin_dir_url(__FILE__));

spl_autoload_register(
    static function (string $class): void {
        $prefix = 'MindGrid\\RequestSystem\\';

        if (strpos($class, $prefix) !== 0) {
            return;
        }

        $relative_class = substr($class, strlen($prefix));
        $file = MGRS_PLUGIN_DIR . 'includes/' . str_replace('\\', '/', $relative_class) . '.php';

        if (is_readable($file)) {
            require_once $file;
        }
    }
);

register_activation_hook(
    __FILE__,
    array(MindGrid\RequestSystem\Activator::class, 'activate')
);

register_deactivation_hook(
    __FILE__,
    array(MindGrid\RequestSystem\Deactivator::class, 'deactivate')
);

add_action(
    'plugins_loaded',
    static function (): void {
        (new MindGrid\RequestSystem\Plugin())->run();
    }
);
