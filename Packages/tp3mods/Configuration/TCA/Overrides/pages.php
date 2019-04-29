<?php

/*
 * This file is part of the web-tp3/tp3mods.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

$extensionKey = 'tp3mods';

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
    'pages',
    'editorial',
    '
    --linebreak--, tp3microdata,
    '
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
    'pages',
    'layout',
    '
    --linebreak--, tp3parallax,
    '
);
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
    'Configuration/PageTS/Page/TCEFORM.tsconfig',
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

\Tp3\Tp3mods\Utility\PageNotFoundHandling::addDoktypeToPages(
    \Tp3\Tp3mods\Configuration\ExtensionConfiguration::EXT_KEY,
    \Tp3\Tp3mods\Configuration\ExtensionConfiguration::get('doktypeError404page'),
    'tp3mods',
    '404'
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
    'tp3mods',
    'Configuration/PageTS/Redirect403.txt',
    'EXT:tp3mods :: Redirect 403 error to login page'
);
