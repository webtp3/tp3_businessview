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
                'minitems' => 1,
                'maxitems' => 10,
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
/*

$GLOBALS['TCA']['tt_address']['types']['Tx_Tp3Businessview_BusinessAdress']['showitem'] .= ',--div--;LLL:EXT:tp3_businessview/Resources/Private/Language/locallang_db.xlf:tx_tp3businessview_domain_model_businessadress,';
$GLOBALS['TCA']['tt_address']['types']['Tx_Tp3Businessview_BusinessAdress']['showitem'] .= 'cid';

*/
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
    'tp3_businessview',
    'EXT:tp3_businessview/Resources/Private/Language/locallang_csh_tt_address.xlf'
);
