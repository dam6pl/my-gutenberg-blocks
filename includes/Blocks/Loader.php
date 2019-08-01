<?php

declare(strict_types=1);

namespace MyCustomBlocks\Blocks;

use const MyCustomBlocks\DOMAIN;
use MyCustomBlocks\Exception\BlockClassException;
use MyCustomBlocks\Exception\MissingBlockFileException;

class Loader
{
    /**
     * @param string $file
     *
     * @throws BlockClassException
     * @throws MissingBlockFileException
     *
     * @return AbstractBlock
     */
    public static function createObjectFromPath(string $file): AbstractBlock
    {
        $file = \str_replace('\\', '/', $file);

        if (\is_file($file)) {
            \ob_start();
            /** @noinspection PhpIncludeInspection */
            include $file;
            \ob_end_clean();

            $lastClasses = \get_declared_classes();
            $moduleClass = \end($lastClasses); // return false if no elements.

            if (false !== $moduleClass) {
                return self::createBlock($moduleClass, $file);
            }

            throw new BlockClassException(
                \__('<code>get_declared_class()</code> is empty!', DOMAIN)
            );
        }

        throw new MissingBlockFileException(
            \__('Missing `/class-block.php` file in the block', DOMAIN)
        );
    }

    /**
     * @param string $namespace
     * @param string $file
     *
     * @throws BlockClassException
     *
     * @return AbstractBlock
     */
    private static function createBlock(string $namespace, string $file): AbstractBlock
    {
        $fileDir = \dirname($file);

        // Test namespace format is valid
        if (!\preg_match('/^(\\\\?[A-Z][a-zA-Z0-9]+)+$/', $namespace)) {
            throw new BlockClassException(
                \__('Incorrect `/class-block.php` class name format', DOMAIN)
            );
        }

        try {
            $module = new $namespace($fileDir);

            if (!$module instanceof AbstractBlock) {
                throw new BlockClassException(
                    \__('Class `/class-block.php` should extends AbstractBlock class', DOMAIN)
                );
            }

            return $module;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
