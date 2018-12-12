<?php

/*
 * This file is part of the web-tp3/tp3businessview.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

$EM_CONF[$_EXTKEY] = [
    'title' => 'tp3 BusinessView',
    'description' => 'google businessview für typo3 - 360° Panorama Designer für Ihren virtuellen Rundgang',
    'category' => 'plugin',
    'author' => 'Thomas Ruta',
    'author_email' => 'support@r-p-it.de',
    'state' => 'stable',
    'internal' => '',
    'uploadfolder' => '0',
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'version' => '1.0.0',
    'constraints' =>
        [
            'depends' =>
                [
                    'typo3' => '8.7.0-9.9.99',
                    'tt_address' => '*',
                ],
            'conflicts' =>
                [

                ],
            'suggests' =>
                [
                    'tp3_openhours' => '*',
                ],
        ],
    'autoload' =>
        [
            'psr-4' =>
                [
                    'Tp3\\Tp3Businessview\\' => 'Classes',
                ],
        ],
    'clearcacheonload' => false,
    'author_company' => 'tp3',
];
