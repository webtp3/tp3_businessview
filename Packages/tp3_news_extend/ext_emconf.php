<?php

/*
 * This file is part of the web-tp3/tp3_news_extend.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

$EM_CONF[$_EXTKEY] = [
    'title' => 'Extend News',
    'description' => '',
    'category' => 'be',
    'version' => '1.1.4',
    'state' => 'stable',
    'uploadfolder' => true,
    'createDirs' => '',
    'clearcacheonload' => true,
    'author' => 'Thomas Ruta',
    'author_email' => 'support@tp3.de',
    'author_company' => 'R&P IT Consulting GmbH',
    'constraints' =>
    [
        'depends' =>
		[
		    'php' => '7.0.0-0.0.0',
			'news' => '*',
            'typo3' => '8.7.0-9.9.99'
        ],
        'conflicts' =>
        [
        ],
        'suggests' =>
        [
        ],
    ]
];
