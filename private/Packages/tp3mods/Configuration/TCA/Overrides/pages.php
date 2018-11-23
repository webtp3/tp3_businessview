<?php

// RTE Config (Old style)
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
    'tp3mods',
    'Configuration/PageTS/setup.txt',
    'EXT:tp3mods :: mods for tp3 special Pages');

// Layouts as Newsletter ...

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
    'tp3mods',
    'Configuration/PageTS/Mod/WebLayout/BackendLayouts.txt',
    'EXT:tp3mods :: Backendlayouts for tp3');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
    'pages',
    [

        'tp3microdata' => [
            'label' => 'tp3 microdata',
            'exclude' => true,
            'config' => [
                'type' => 'selectSingle',
                'MM' => 'tx_tp3mods_domain_model_mm',
                'MM_hasUidField' => true,
                'MM_opposite_field' => 'pages',
                'maxitems' => 100,
                'foreign_table' => 'tx_tp3mods_domain_model_tp3mods',
                'minitems' => 0,
                'items' => [
                    [ '',  ],
                ],
                'appearance' => [
                    'collapseAll' => 0,
                    'levelLinksPosition' => 'top',
                ],
            ]
        ],

    ]
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
    'pages',
    'layout',
    '
    --linebreak--, tp3microdata,
    '
);