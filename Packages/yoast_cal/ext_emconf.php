<?php
$EM_CONF['yoast_cal'] = [
    'title' => 'Yoast SEO for TYPO3 - EXT:cal',
    'description' => 'Integrate Yoast SEO for TYPO3 in EXT:cal',
    'category' => 'fe',
    'state' => 'stable',
    'author' => 'Thomas Ruta',
    'author_email' => 'email@thomasruta.de',
    'version' => '1.1.0',
    'constraints' => [
        'depends' => [
            'cal' => '',
            'yoast_seo' => '',
            'typo3' => '7.6.31-8.7.99'
        ],
        'conflicts' => [],
        'suggests' => []
    ],
];
