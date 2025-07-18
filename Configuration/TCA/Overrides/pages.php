<?php

/*
 * This file is part of the package web-tp3/tp3-businessview.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
    'pages',
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
                'default' => 0,
                'items' => [
                ],
                'appearance' => [
                    'collapseAll' => false,
                    'levelLinksPosition' => 'top',
                    'useSortable' => true,
                    'showSynchronizationLink' => true,
                    'showAllLocalizationLink' => true,
                    'showPossibleLocalizationRecords' => false,
                    'showRemovedLocalizationRecords' => false,
                    'expandSingle' => true,
                    'enabledControls' => [
                        'localize' => false,
                    ]
                ],
                'behaviour' => [
                    'mode' => 'select',
                    'localizeChildrenAtParentLocalization' => true,
                ]
            ]
        ],
//        'tx_tp3businessview_businessview' => [
//            'label' => 'Businessview',
//            'exclude' => true,
//            'config' => [
//                'type' => 'select',
//                'renderType' => 'selectSingle',
//                'foreign_table' => 'tx_tp3businessview_domain_model_tp3businessview',
//                'minitems' => 0,
//                'maxitems' => 1,
//                'items' => [
//                          [ 0 => ''],
//                ],
//                'appearance' => [
//                    'collapseAll' => false,
//                    'levelLinksPosition' => 'top',
//                    'useSortable' => true,
//                    'showSynchronizationLink' => true,
//                    'showAllLocalizationLink' => true,
//                    'showPossibleLocalizationRecords' => false,
//                    'showRemovedLocalizationRecords' => false,
//                    'expandSingle' => true,
//                    'enabledControls' => [
//                        'localize' => false,
//                    ]
//                ],
//                'behaviour' => [
//                    'mode' => 'select',
//                    'localizeChildrenAtParentLocalization' => true,
//                ]
//            ]
//        ],
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
    'pages',
    'layout',
    '
    --linebreak--, tx_tp3businessview_onpage,
    --linebreak--, tx_tp3businessview_panorama,
    --linebreak--, tx_tp3businessview_injetionpoint,
    '
);
