<?php
/*
 * Plugin Name: My custom Gutenberg blocks
 * Plugin URI: https://dnowak.dev
 * Description: The custom Gutenberg blocks with AMP support
 * Version: 1.0.0
 * Author: Damian Nowak
 * Author URI: https://dnowak.dev
 * Text Domain: my-custom-blocks
 * License: GPLv2 or later
 * License URI:	http://www.gnu.org/licenses/gpl-2.0.html
 */

declare(strict_types=1);

namespace MyCustomBlocks;

// Exit if accessed directly
defined('ABSPATH') || exit;

\define('MyCustomBlocks\PLUGIN_URL', plugin_dir_url(__FILE__));
\define('MyCustomBlocks\PLUGIN_DIR', plugin_dir_path(__FILE__));
\define('MyCustomBlocks\DOMAIN', 'my-custom-blocks');

include_once 'vendor/autoload.php';

/**
 * Class Bootstrap
 */
class Bootstrap
{
    /**
     * Bootstrap constructor
     */
    public function __construct()
    {
        \add_action('init', [$this, 'initBlocks']);
    }

    /**
     * Initialize Blocks
     */
    public function initBlocks(): void
    {
        new Blocks();
    }
}

new Bootstrap();
