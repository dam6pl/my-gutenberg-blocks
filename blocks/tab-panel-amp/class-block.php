<?php

declare(strict_types=1);

namespace MyCustomBlocks\Blocks;

class TabPanelAMP extends AbstractBlock
{
    /**
     * {@inheritdoc}
     */
    public function config(): array
    {
        return [
            'deps' => [
                'js' => [
                    'https://cdn.ampproject.org/v0.js',
                    'https://cdn.ampproject.org/v0/amp-selector-0.1.js',
                ],
                'css' => [],
            ],
        ];
    }
}
