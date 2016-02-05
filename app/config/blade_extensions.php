<?php
/**
 * Part of Radic - Blade Extensions
 *
 * @author         Robin Radic
 * @license        MIT License - http://radic.mit-license.org
 * @copyright  (c) 2011-2015, Robin Radic - Radic Technologies
 * @link           http://radic.nl
 */

return [
    'blacklist' => [],
    'markdown'  => [
        'enabled'  => env('BLADE_EXTENSIONS_MARKDOWN_ENABLED', false),
        'renderer' => 'Sebwite\Development\BladeExtensions\Renderers\ParsedownRenderer',
        'views'    => env('BLADE_EXTENSIONS_MARKDOWN_VIEWS', false)
    ],
    'overrides' => [],
    'example_views' => env('BLADE_EXTENSIONS_EXAMPLE_VIEWS', false)
];
