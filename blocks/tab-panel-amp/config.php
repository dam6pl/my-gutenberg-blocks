<?php
declare(strict_types=1);

return [
    'deps' => [
        'https://cdn.ampproject.org/v0.js',
        'https://cdn.ampproject.org/v0/amp-selector-0.1.js'
    ],
    'render_callback' => static function(array $block) {
        ob_start(); ?>
            <amp-selector id="tab-<?= $block['hash'] ?? 1 ?>" class="tabs-with-flex" role="tablist">
                <?php foreach ($block['tabs'] as $key => $tab): ?>
                    <div id="tab-<?= $block['hash'] ?? 1 ?>-<?= $tab['hash'] ?? $key ?>"
                         aria-controls="tabpanel-<?= $block['hash'] ?? 1 ?>-<?= $tab['hash'] ?? $key ?>"
                         role="tab" option <?= $key === 0 ? 'selected' : '' ?>><?= $tab['title'] ?></div>
                    <div id="tabpanel-<?= $block['hash'] ?? 1 ?>-<?= $tab['hash'] ?? $key ?>" role="tabpanel"
                         aria-labelledby="tab-<?= $block['hash'] ?? 1 ?>-<?= $tab['hash'] ?? $key ?>">
                        <?= $tab['content'] ?? 'Tab title goes here...' ?>
                    </div>
                <?php endforeach; ?>
            </amp-selector>
        <?php return ob_get_clean();
    }
];