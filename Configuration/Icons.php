<?php

/*
 * This file is part of the package web-tp3/tp3-businessview.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

return [
    'plugins_tp3businessview_tp3businessview' => [
        'provider' => \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        'source' => 'EXT:tp3_businessview/Resources/Public/Icons/user_plugin_tp3businessview.svg',
    ],
    'ext-tp3_businessview-module-icon' => [
        'provider' => \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        'source' => 'EXT:tp3_businessview/Resources/Public/Icons/user_mod_tp3businessview.svg',
    ],
];
