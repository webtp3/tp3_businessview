<?php
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
                'type' => 'inline',
                'foreign_table' => 'tx_tp3businessview_domain_model_tp3businessview',
                'minitems' => 0,
                'maxitems' => 1,
                'appearance' => [
                    'collapseAll' => 0,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ],

        ]
    ],
    'sorting' => [
        'config' => [
            'type' => 'none',
        ],
    ],
];
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_address',$tmp_tp3_businessview_columns);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
    'tt_address',
    'social',
     ' --linebreak--, googleplus, --linebreak--, cid, --linebreak--,'
);
/*

$GLOBALS['TCA']['tt_address']['types']['Tx_Tp3Businessview_BusinessAdress']['showitem'] .= ',--div--;LLL:EXT:tp3_businessview/Resources/Private/Language/locallang_db.xlf:tx_tp3businessview_domain_model_businessadress,';
$GLOBALS['TCA']['tt_address']['types']['Tx_Tp3Businessview_BusinessAdress']['showitem'] .= 'cid';

*/
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
    'tp3_businessview',
    'EXT:tp3_businessview/Resources/Private/Language/locallang_csh_tt_address.xlf'
);
