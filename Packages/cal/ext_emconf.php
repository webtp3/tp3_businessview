<?php

/*
 * This file is part of the web-tp3/cal.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

$EM_CONF [$_EXTKEY] = [
        'title' => 'Calendar Base',
        'description' => 'A calendar combining all the functions of the existing calendar extensions plus adding some new features. It is based on the ical standard',
        'category' => 'plugin',
        'shy' => 0,
        'version' => '1.12.1-dev',
        'loadOrder' => '',
        'state' => 'stable',
        'uploadfolder' => 0,
        'createDirs' => 'uploads/tx_cal/pics,uploads/tx_cal/ics,uploads/tx_cal/media',
        'clearCacheOnLoad' => 0,
        'author' => 'Mario Matzulla, Jeff Segars, Franz Koch, Thomas Kowtsch',
        'author_email' => 'mario@matzullas.de, jeff@webempoweredchurch.org, franz.koch@elements-net.de, typo3@thomas-kowtsch.de',
        'author_company' => '',
        'constraints' => [
                'depends' => [
                        'typo3' => '8.7.0-9.9.99'
                ],
                'suggests' => [
                        'wec_map' => '',
                        'tt_address' => ''
                ]
        ],
        'autoload' => [
            'psr-4' => ['TYPO3\\CMS\\Cal\\'=> 'Classes']
        ],
];
