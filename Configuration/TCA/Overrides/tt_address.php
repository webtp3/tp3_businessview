<?php

/*
 * This file is part of the web-tp3/tp3businessview.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3_MODE') || die();

$tmp_tp3_businessview_columns = [

    'cid' => [
        'exclude' => true,
        'label' => 'LLL:EXT:tp3_businessview/Resources/Private/Language/locallang_csh_tt_address.xlf:tx_tp3businessview_domain_model_businessadress.cid',
        'config' => [
            'type' => 'input',
            'size' => 30,
            'eval' => 'trim'
        ],
    ],
    'googleplus' => [
        'exclude' => true,
        'label' => 'LLL:EXT:tp3_businessview/Resources/Private/Language/locallang_csh_tt_address.xlf:tx_tp3businessview_domain_model_businessadress.googleplus',
        'config' => [
            'type' => 'input',
            'size' => 30,
            'eval' => 'trim'
        ],
    ],
    'tp3businessview' => [
        'label' => 'LLL:EXT:tp3_businessview/Resources/Private/Language/locallang_csh_tt_address.xlf:tx_tp3businessview_domain_model_tp3businessview.tp3businessview',

            'config' => [
                'type' => 'select',
                'renderType' => 'selectCheckBox',
                'items' => [
                    [
                        '', 0
                    ]
                ],
                'foreign_table' => 'tx_tp3businessview_domain_model_tp3businessview',
                //  'foreign_table_where' => 'AND  tx_tp3businessview_domain_model_panoramas_mm.uid_local=###THIS_UID###',
              //  'foreign_table_where' => 'AND tx_styleguide_inline_mm.pid=###CURRENT_PID### AND tx_styleguide_inline_mm.sys_language_uid IN (-1,0)',
                'foreign_sortby' => 'sorting',
                'allowed' => 'tx_tp3businessview_domain_model_tp3businessview',
                'MM' => 'tx_tp3businessview_domain_model_tp3businessview_mm',
                'enableMultiSelectFilterTextfield' => true,
                'minitems' => 0,
                'maxitems' => 100,
                'size' => 1,

        ]
    ],
    'sorting' => [
        'config' => [
            'type' => 'none',
        ],
    ],
];
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_address', $tmp_tp3_businessview_columns);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
    'tt_address',
    'social',
    ' --linebreak--, googleplus, --linebreak--, cid, --linebreak--, tp3businessview, --linebreak--,'
);

//if (isset($GLOBALS['TCA']['tt_address']['types']['0']['showitem'])) {
//    $GLOBALS['TCA']['tt_address']['types']['Tx_Tp3Businessview_BusinessAdress']['showitem'] = $GLOBALS['TCA']['tt_address']['types']['0']['showitem'];
//} elseif(is_array($GLOBALS['TCA']['tt_address']['types'])) {
//    // use first entry in types array
//    $tt_address_type_definition = reset($GLOBALS['TCA']['tt_address']['types']);
//    $GLOBALS['TCA']['tt_address']['types']['Tx_Tp3Businessview_BusinessAdress']['showitem'] = $tt_address_type_definition['showitem'];
//} else {
//    $GLOBALS['TCA']['tt_address']['types']['Tx_Tp3Businessview_BusinessAdress']['showitem'] = '';
//}
//
//$GLOBALS['TCA']['tt_address']['types']['Tx_Tp3Businessview_BusinessAdress']['showitem'] .= ',--div--;LLL:EXT:tp3_businessview/Resources/Private/Language/locallang_db.xlf:tx_tp3businessview_domain_model_businessadress,';
//$GLOBALS['TCA']['tt_address']['types']['Tx_Tp3Businessview_BusinessAdress']['showitem'] .= 'cid';
//
//$GLOBALS['TCA']['tt_address']['columns'][$GLOBALS['TCA']['tt_address']['ctrl']['type']]['config']['items'][] = ['LLL:EXT:tp3_businessview/Resources/Private/Language/locallang_db.xlf:tt_address.tx_extbase_type.Tx_Tp3Businessview_BusinessAdress','Tx_Tp3Businessview_BusinessAdress'];
//

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
    'tp3_businessview',
    'EXT:tp3_businessview/Resources/Private/Language/locallang_csh_tt_address.xlf'
);
