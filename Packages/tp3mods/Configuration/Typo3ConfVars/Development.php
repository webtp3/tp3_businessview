<?php

use TYPO3\CMS\Core\Cache\Backend\NullBackend;
use TYPO3\CMS\Core\Cache\Backend\TransientMemoryBackend;
use TYPO3\CMS\Core\Log\LogLevel;
use TYPO3\CMS\Core\Log\Writer\FileWriter;

return [
    'SYS' => [
        // Debug
        'displayErrors' => 1,
        'devIPmask' => '*',
        'enableDeprecationLog' => 'file',
        'exceptionalErrors' => E_WARNING | E_USER_ERROR | E_RECOVERABLE_ERROR | E_DEPRECATED | E_USER_DEPRECATED,
        'systemLogLevel' => 0,
        'caching' => [
            'cacheConfigurations' => [
                // Uncommenting the two lines below will slow down request times dramatically
//                'cache_core' => array(
//                    'backend' => \TYPO3\CMS\Core\Cache\Backend\NullBackend::class,
//                ),
//                'fluid_template' => array(
//                    'backend' => \TYPO3\CMS\Core\Cache\Backend\NullBackend::class,
//                ),
                'cache_hash' => [
                    'backend' => NullBackend::class,
                ],
                'cache_pages' => [
                    'backend' => NullBackend::class,
                ],
                'cache_pagesection' => [
                    'backend' => NullBackend::class,
                ],
                'cache_phpcode' => [
                    'backend' => NullBackend::class,
                ],
                'cache_runtime' => [
                    'backend' => TransientMemoryBackend::class,
                ],
                'cache_rootline' => [
                    'backend' => NullBackend::class,
                ],
                'cache_imagesizes' => [
                    'backend' => NullBackend::class,
                ],
                'l10n' => [
                    'backend' => NullBackend::class,
                ],
                'extbase_object' => [
                    'backend' => NullBackend::class,
                ],
                'extbase_reflection' => [
                    'backend' => NullBackend::class,
                ],
                'extbase_typo3dbbackend_tablecolumns' => [
                    'backend' => NullBackend::class,
                ],
                'extbase_typo3dbbackend_queries' => [
                    'backend' => NullBackend::class,
                ],
                'extbase_datamapfactory_datamap' => [
                    'backend' => NullBackend::class,
                ],
            ]
        ]
    ],
    'BE' => [
        'debug' => true,
        // Convenience
        'sessionTimeout' => 60 * 60 * 24 * 365 // One year!
    ],
    'FE' => [
        'debug' => true,
    ],
    'MAIL' => [
        'transport' => 'mbox',
        'transport_mbox_file' =>  '%env(TYPO3_PATH_COMPOSER_ROOT)%/var/log/sent-mails.log',
    ],
    'LOG' => [
        'writerConfiguration' => [
            LogLevel::DEBUG => [
                FileWriter::class => [
                    'logFile' => '%env(TYPO3_PATH_COMPOSER_ROOT)/var/log/typo3-debug.log'
                ]
            ]
        ]
    ],
];
