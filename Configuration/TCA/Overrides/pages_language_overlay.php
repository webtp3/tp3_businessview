<?php

/*
 * This file is part of the package web-tp3/tp3-businessview.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

$llPrefix = 'LLL:EXT:tp3_businessview/Resources/Private/Language/locallang.xlf:';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
    'pages_language_overlay',
    [
        'tx_tp3businessview_onpage' => [
            'label' => 'Display Businessview on page',
            'exclude' => true,
            'config' => [
                'type' => 'check'
            ]
        ],
        'tx_tp3businessview_panorama' => [
            'label' => 'Panorama',
            'exclude' => true,
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_tp3businessview_domain_model_panoramas',
                'minitems' => 0,
                'maxitems' => 1,
                'items' => [
                    [ ''],
                ],
                'appearance' => [
                    'collapseAll' => 0,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ],
            ]
        ],
        'tx_tp3businessview_injetionpoint' => [
            'label' => 'Businessview  css selector',
            'exclude' => true,
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ]
        ],
    ]
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
    'pages_language_overlay',
    'editorial',
    '
    --linebreak--, tx_tp3businessview_onpage,
    --linebreak--, tx_tp3businessview_panorama,
    --linebreak--, tx_tp3businessview_injetionpoint,
    '
);
//$dokTypes = 1;
//\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
//    'pages_language_overlay',
//    '
//    --div--;' . $llPrefix . 'pages.tabs.layout,
//        --palette--;' . $llPrefix . 'pages.palettes.layout;tx_tp3businessview_onpage,
//        --palette--;' . $llPrefix . 'pages.palettes.layout;tx_tp3businessview_panorama,
//        --palette--;' . $llPrefix . 'pages.palettes.layout;tx_tp3businessview_injetionpoint,
//    ',
//    $dokTypes,
//    'after:subtitle'
//);
