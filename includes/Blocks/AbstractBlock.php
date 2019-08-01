<?php

declare(strict_types=1);

namespace MyCustomBlocks\Blocks;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use const MyCustomBlocks\PLUGIN_DIR;

/**
 * Class AbstractBlock.
 */
abstract class AbstractBlock
{
    /**
     * @var string
     */
    private $_path;

    /**
     * AbstractBlock constructor.
     *
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->_path = $path;
    }

    /**
     * Block configuration
     *
     * @return array
     */
    abstract public function config(): array;

    /**
     * Render block front view
     *
     * @param array $data
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function render(array $data): string
    {
        $twig = new Environment(
            new FilesystemLoader($this->_path . '/views'),
            [
                'cache' => PLUGIN_DIR . '/cache',
            ]
        );

        if (\defined('WP_DEBUG') && WP_DEBUG === true) {
            $twig->enableDebug();
            $twig->enableAutoReload();
            $twig->enableStrictVariables();
        }

        return $twig->render('block.twig', [
            'api'    => $data,
            'module' => $this,
        ]);
    }
}
