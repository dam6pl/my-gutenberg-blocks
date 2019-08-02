<?php

declare(strict_types=1);

namespace MyCustomBlocks;

use MyCustomBlocks\Blocks\AbstractBlock;
use MyCustomBlocks\Blocks\Loader;
use MyCustomBlocks\Exception\MissingBlockFileException;

/**
 * Class Blocks.
 */
class BlocksManager
{
    /**
     * @var array
     */
    private $_blocks = [];

    /**
     * Blocks constructor.
     *
     * @throws Exception\BlockClassException
     * @throws Exception\MissingBlockFileException
     */
    public function __construct()
    {
        $this->registerBlock('tab-panel-amp', PLUGIN_DIR . 'blocks/tab-panel-amp');

        $this->initBlocks();
    }

    /**
     * Register new block.
     *
     * @param string $name
     * @param string $path
     */
    public function registerBlock(string $name, string $path): void
    {
        $this->_blocks[$name] = $path;
    }

    /**
     * Initialize blocks.
     *
     * @throws Exception\BlockClassException
     * @throws Exception\MissingBlockFileException
     */
    public function initBlocks(): void
    {
        foreach (\apply_filters('MyCustomBlocks\initBlocks', $this->_blocks) as $name => $path) {
            $this->_initBlock($name, $path);
        }
    }

    /**
     * Initialize single block.
     *
     * @param string $name
     * @param string $path
     *
     * @throws Exception\BlockClassException
     * @throws Exception\MissingBlockFileException
     */
    private function _initBlock(string $name, string $path): void
    {
        $this->_validPath($path);
        $block = Loader::createObjectFromPath("{$path}/class-block.php");

        $this->_registerGutenbergBlock($name, $path, $block);

        $config = $block->config();
        if (isset($config['deps']['js']) && \is_array($config['deps']['js'])) {
            foreach ($config['deps']['js'] as $dep) {
                \add_action(
                    'wp_enqueue_scripts',
                    static function () use ($dep): void {
                        \wp_enqueue_script(\basename($dep), $dep);
                    }
                );
            }
        }
    }

    /**
     * Validate block required files.
     *
     * @param string $path
     *
     * @throws Exception\MissingBlockFileException
     */
    private function _validPath(string $path): void
    {
        if (!\file_exists("{$path}/class-block.php")) {
            throw new MissingBlockFileException(
                \__('Missing `/class-block.php` file in the block', DOMAIN)
            );
        }

        if (!\file_exists("{$path}/javascript/build/main.js")) {
            throw new MissingBlockFileException(
                \__('Missing `/javascript/build/main.js` file in the block', DOMAIN)
            );
        }

        if (!\file_exists("{$path}/stylesheets/css/editor.css")) {
            throw new MissingBlockFileException(
                \__('Missing `/stylesheets/css/editor.css` file in the block', DOMAIN)
            );
        }

        if (!\file_exists("{$path}/stylesheets/css/styles.css")) {
            throw new MissingBlockFileException(
                \__('Missing `/stylesheets/css/styles.css` file in the block', DOMAIN)
            );
        }
    }

    /**
     * Register required scripts for WP Gutenberg.
     *
     * @param string        $name
     * @param string        $path
     * @param AbstractBlock $block
     */
    private function _registerGutenbergBlock(string $name, string $path, AbstractBlock $block): void
    {
        $relPath = \str_replace(ABSPATH, '', $path);

        \wp_register_script(
            "{$name}-editor-script",
            "/{$relPath}/javascript/build/main.js",
            ['wp-blocks', 'wp-element', 'wp-editor', 'lodash'],
            \filemtime("{$path}/javascript/build/main.js"),
            true
        );

        \wp_register_style(
            "{$name}-editor-style",
            "/{$relPath}/stylesheets/css/editor.css",
            ['wp-edit-blocks'],
            \filemtime("{$path}/stylesheets/css/editor.css")
        );

        \wp_register_style(
            "{$name}-front-styles",
            "/{$relPath}/stylesheets/css/styles.css",
            [],
            \filemtime("{$path}/stylesheets/css/styles.css")
        );

        \register_block_type(
            "mcb/{$name}",
            [
                'editor_script'   => "{$name}-editor-script",
                'editor_style'    => "{$name}-editor-style",
                'style'           => "{$name}-front-styles",
                'render_callback' => [$block, 'render'],
            ]
        );
    }
}
