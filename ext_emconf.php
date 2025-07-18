<?php

/*
 * This file is part of the package web-tp3/tp3-businessview.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

$EM_CONF['tp3_businessview'] = [
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
    'version' => '1.5.0',
    'constraints' =>
        [
            'depends' =>
                [
                    'typo3' => '11.0.0-12.9.99',
                ],
            'conflicts' =>
                [

                ],
            'suggests' =>
                [
                    'tt_address' => '*',
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
