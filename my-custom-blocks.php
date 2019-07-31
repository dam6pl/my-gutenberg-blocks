<?php
/*
 * Plugin Name: My custom Gutenberg blocks
 * Plugin URI: http://gutenberg.pagebox.docker.localhost/
 * Description: My custom gutenberg blocks
 * Version: 1.0.0
 * Author: Damian Nowak
 * Author URI: https://dnowak.dev
 * Text Domain: gutenberg-my-custom-blocks
 * Domain Path:	/languages
 * License: GPLv2 or later
 * License URI:	http://www.gnu.org/licenses/gpl-2.0.html
 */

declare(strict_types=1);

// Exit if accessed directly
defined('ABSPATH') || exit;

//Init all blocks from blocks/ directory
add_action('init', static function () {
    $plugin_url = plugin_dir_url(__FILE__);
    $plugin_dir = plugin_dir_path(__FILE__);

    foreach (glob(plugin_dir_path(__FILE__) . 'blocks/*', GLOB_ONLYDIR) as $dir) {
        $basename = basename($dir);

        /** @noinspection PhpIncludeInspection */
        $config = require "{$plugin_dir}blocks/{$basename}/config.php";

        wp_register_script(
            "{$basename}-editor-script",
            "{$plugin_url}blocks/{$basename}/build/index.js",
            ['wp-blocks', 'wp-element', 'wp-editor', 'lodash'],
            filemtime("{$plugin_dir}blocks/{$basename}/build/index.js"),
            true
        );

        wp_register_style(
            "{$basename}-editor-style",
            "{$plugin_url}blocks/{$basename}/src/stylesheets/editor.css",
            ['wp-edit-blocks'],
            filemtime("{$plugin_dir}blocks/{$basename}/src/stylesheets/editor.css")
        );

        wp_register_style(
            "{$basename}-front-styles",
            "{$plugin_url}blocks/{$basename}/src/stylesheets/styles.css",
            [],
            filemtime("{$plugin_dir}blocks/{$basename}/src/stylesheets/styles.css")
        );

        register_block_type(
            "mcb/{$basename}",
            [
                'editor_script'   => "{$basename}-editor-script",
                'editor_style'    => "{$basename}-editor-style",
                'style'           => "{$basename}-front-styles",
                'render_callback' => $config['render_callback']
            ]
        );

        if (isset($config['deps']) && is_array($config['deps'])) {
            foreach ($config['deps'] as $dep) {
                add_action(
                    'wp_enqueue_scripts',
                    static function () use ($dep) {
                        wp_enqueue_script(basename($dep), $dep);
                    }
                );
            }
        }
    }
});
