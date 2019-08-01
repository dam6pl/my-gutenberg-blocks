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

//
////Init all blocks from blocks/ directory
//add_action('init', static function () {
//    $plugin_url = plugin_dir_url(__FILE__);
//    $plugin_dir = plugin_dir_path(__FILE__);
//
//    foreach (glob(plugin_dir_path(__FILE__) . 'blocks/*', GLOB_ONLYDIR) as $dir) {
//        $basename = basename($dir);
//
//        /** @noinspection PhpIncludeInspection */
//        $config = require "{$plugin_dir}blocks/{$basename}/config.php";
//
//        wp_register_script(
//            "{$basename}-editor-script",
//            "{$plugin_url}blocks/{$basename}/build/index.js",
//            ['wp-blocks', 'wp-element', 'wp-editor', 'lodash'],
//            filemtime("{$plugin_dir}blocks/{$basename}/build/index.js"),
//            true
//        );
//
//        wp_register_style(
//            "{$basename}-editor-style",
//            "{$plugin_url}blocks/{$basename}/src/stylesheets/editor.css",
//            ['wp-edit-blocks'],
//            filemtime("{$plugin_dir}blocks/{$basename}/src/stylesheets/editor.css")
//        );
//
//        wp_register_style(
//            "{$basename}-front-styles",
//            "{$plugin_url}blocks/{$basename}/src/stylesheets/styles.css",
//            [],
//            filemtime("{$plugin_dir}blocks/{$basename}/src/stylesheets/styles.css")
//        );
//
//        register_block_type(
//            "mcb/{$basename}",
//            [
//                'editor_script'   => "{$basename}-editor-script",
//                'editor_style'    => "{$basename}-editor-style",
//                'style'           => "{$basename}-front-styles",
//                'render_callback' => $config['render_callback']
//            ]
//        );
//
//        if (isset($config['deps']) && is_array($config['deps'])) {
//            foreach ($config['deps'] as $dep) {
//                add_action(
//                    'wp_enqueue_scripts',
//                    static function () use ($dep) {
//                        wp_enqueue_script(basename($dep), $dep);
//                    }
//                );
//            }
//        }
//    }
//});
