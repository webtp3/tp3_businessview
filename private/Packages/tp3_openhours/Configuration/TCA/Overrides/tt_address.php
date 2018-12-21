<?php

/*
 * This file is part of the web-tp3/tp3openhours.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3_MODE') || die();

$tmp_tp3_openhours_columns = [
    'open_hours' => [
        'exclude' => true,
        'label' => 'LLL:EXT:tp3_openhours/Resources/Private/Language/locallang_db.xlf:tx_tp3openhours_domain_model_ttaddress.open_hours',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_tp3openhours_domain_model_openhour',
            'foreign_field' => 'ttaddress',
            'foreign_sortby' => 'sorting',
            'maxitems' => 9999,
            'appearance' => [
                'collapseAll' => 0,
                'levelLinksPosition' => 'top',
                'showSynchronizationLink' => 1,
                'showPossibleLocalizationRecords' => 1,
                'useSortable' => 1,
                'showAllLocalizationLink' => 1
            ],
        ],
    ],
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_address', $tmp_tp3_openhours_columns);
 \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
     'tt_address',
     'address',
     'open_hours',
     'after:longitude'
 );
