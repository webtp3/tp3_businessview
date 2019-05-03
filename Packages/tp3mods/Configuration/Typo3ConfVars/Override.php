<?php

use TYPO3\CMS\Core\Log\LogLevel;
use TYPO3\CMS\Core\Log\Writer\FileWriter;

return [
    'SYS' => [
        'systemLog' => false,
        'belogErrorReporting' => 0,
    ],
    'LOG' => [
        'writerConfiguration' => [
            LogLevel::WARNING => [
                FileWriter::class => [
                    'logFile' => '%env(TYPO3_PATH_COMPOSER_ROOT)/var/log/typo3-error.log'
                ]
            ]
        ]
    ],
    'EXTENSIONS' => [
        'backend' => [
            'backendFavicon' => 'EXT:tp3mods/Resources/Public/Icons/favicon_96.png',
            'backendLogo' => 'EXT:tp3mods/Resources/Public/Images/Backend/backend-logo.svg',
            'loginBackgroundImage' => 'EXT:tp3mods/Resources/Public/Images/back.jpg',
            'loginFootnote' => 'tp3 9 Suite',
            'loginHighlightColor' => '#F0AD4E',
            'loginLogo' => 'EXT:tp3mods/Resources/Public/Images/Backend/login-logo.svg',
        ],

    ]
];
