<?php

/*
 * This file is part of the web-tp3/tp3mods.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3_MODE') || die();

//if (!isset($GLOBALS['TCA']['tt_address']['ctrl']['type'])) {
//    // no type field defined, so we define it here. This will only happen the first time the extension is installed!!
//    $GLOBALS['TCA']['tt_address']['ctrl']['type'] = 'tx_extbase_type';
//    $tempColumnstx_tp3mods_tt_address = [];
//    $tempColumnstx_tp3mods_tt_address[$GLOBALS['TCA']['tt_address']['ctrl']['type']] = [
//        'exclude' => true,
//        'label'   => 'LLL:EXT:tp3mods/Resources/Private/Language/locallang_db.xlf:tx_tp3mods.tx_extbase_type',
//        'config' => [
//            'type' => 'select',
//            'renderType' => 'selectSingle',
//            'items' => [
//                ['',''],
//                ['Tp3Adress','Tx_Tp3mods_Tp3Adress']
//            ],
//            'default' => 'Tx_Tp3mods_Tp3Adress',
//            'size' => 1,
//            'maxitems' => 1,
//        ]
//
//    ];
//    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_address', $tempColumnstx_tp3mods_tt_address);
//}
//
//\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
//    'tt_address',
//    $GLOBALS['TCA']['tt_address']['ctrl']['type'],
//    '',
//    'after:' . $GLOBALS['TCA']['tt_address']['ctrl']['label']
//);

$tmp_tp3mods_columns = [

    'microdata_adress' => [
        'exclude' => true,
        'label' => 'LLL:EXT:tp3mods/Resources/Private/Language/locallang_db.xlf:tx_tp3mods_domain_model_tp3adress.microdata_adress',
        'config' => [
//            'type' => 'select',
//            'renderType' => 'selectMultipleSideBySide',
//            'foreign_table' => 'tx_tp3mods_domain_model_tp3mods',
//            'MM' => 'tx_tp3mods_domain_model_mm',
//            'MM_opposite_field' => 'address',
            'type' => 'select',
            'renderType' => 'selectSingle',
            'foreign_table' => 'tp3mods_domain_model_tp3mods',

        ]

    ],
//    'tx_extbase_type' => [
//        'config' => [
//            'type' => 'select',
//            'renderType' => 'selectSingle',
//            'items' => [
//                [ ],
//            ],
//            'fieldWizard' => [
//                'selectIcons' => [
//                    'disabled' => false,
//                ],
//            ],
//            'size' => 1,
//            'maxitems' => 1,
//        ]
//    ],

];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_address', $tmp_tp3mods_columns);

/* inherit and extend the show items from the parent class */

//if (isset($GLOBALS['TCA']['tt_address']['types']['0']['showitem'])) {
//    $GLOBALS['TCA']['tt_address']['types']['Tx_Tp3mods_Tp3Adress']['showitem'] = $GLOBALS['TCA']['tt_address']['types']['0']['showitem'];
//} elseif(is_array($GLOBALS['TCA']['tt_address']['types'])) {
//    // use first entry in types array
//    $tt_address_type_definition = reset($GLOBALS['TCA']['tt_address']['types']);
//    $GLOBALS['TCA']['tt_address']['types']['Tx_Tp3mods_Tp3Adress']['showitem'] = $tt_address_type_definition['showitem'];
//} else {
//    $GLOBALS['TCA']['tt_address']['types']['Tx_Tp3mods_Tp3Adress']['showitem'] = '';
//}
//$GLOBALS['TCA']['tt_address']['types']['Tx_Tp3mods_Tp3Adress']['showitem'] .= ',--div--;LLL:EXT:tp3mods/Resources/Private/Language/locallang_db.xlf:tx_tp3mods_domain_model_tp3adress,';
//$GLOBALS['TCA']['tt_address']['types']['Tx_Tp3mods_Tp3Adress']['showitem'] .= 'microdata_adress';
//
//$GLOBALS['TCA']['tt_address']['columns'][$GLOBALS['TCA']['tt_address']['ctrl']['type']]['config']['items'][] = ['LLL:EXT:tp3mods/Resources/Private/Language/locallang_db.xlf:tt_address.tx_extbase_type.Tx_Tp3mods_Tp3Adress','Tx_Tp3mods_Tp3Adress'];

//\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::makeCategorizable(
//   'tp3mods',
//   'tt_address'
//);
