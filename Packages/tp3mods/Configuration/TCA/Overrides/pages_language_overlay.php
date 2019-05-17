<?php

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
    'pages_language_overlay',
    [
        'tp3microdata' => [
            'label' => 'tp3 microdata',
            'exclude' => true,
            'config' => [
                'type' => 'inline',
                'maxitems' => 1,
                'foreign_table' => 'tx_tp3mods_domain_model_tp3mods',
                'minitems' => 0,
                'items' => [
                    [ ''],
                ],
                'appearance' => [
                    'collapseAll' => 0,
                    'expandSingle' => 1,
                ],

            ]
        ],
        'tp3parallax' => [
            'label' => 'tp3 parallax effect',
            'exclude' => true,
            'config' => [
                'type' => 'check',
                'default' => '1'

            ]
        ],
    ]
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
    'pages_language_overlay',
    'editorial',
    '
    --linebreak--, tp3microdata,'
);
