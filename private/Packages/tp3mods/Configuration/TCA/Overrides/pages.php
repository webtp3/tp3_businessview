<?php

/*
 * This file is part of the web-tp3/tp3mods.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

$extensionKey = 'tp3mods';

// RTE Config (Old style)
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
    'tp3mods',
    'Configuration/PageTS/setup.txt',
    'EXT:tp3mods :: mods for tp3 special Pages old RTE etc.'
);

// Layouts as Newsletter ...

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
    'tp3mods',
    'Configuration/PageTS/Mod/WebLayout/BackendLayouts.txt',
    'EXT:tp3mods :: Backendlayouts for tp3'
);

// TCEFORM
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
    $extensionKey,
    'Configuration/PageTS/TCEFORM.txt',
    'EXT:tp3mods : TCEFORM'
);

// TtContent Previews
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
    $extensionKey,
    'Configuration/PageTS/Mod/WebLayout/TtContent/preview.txt',
    'EXT:tp3mods : Content Previews'
);

// New Content element wizards
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
    $extensionKey,
    'Configuration/PageTS/Mod/Wizards/newContentElement.txt',
    'EXT:tp3mods : New Content Element Wizards'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
    'pages',
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
                    'collapseAll' => 1,
                    'expandSingle' => 1,
                ],

            ]
        ],

    ]
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
    'pages',
    'editorial',
    '
    --linebreak--, tp3microdata,
    '
);
