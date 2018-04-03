<?php
defined('TYPO3_MODE') || die();

$tmp_tp3_businessview_columns = [

    'cid' => [
        'exclude' => true,
        'label' => 'LLL:EXT:tp3_businessview/Resources/Private/Language/locallang_db.xlf:tx_tp3businessview_domain_model_businessadress.cid',
        'config' => [
            'type' => 'input',
            'size' => 30,
            'eval' => 'trim'
        ],
    ],
    'googleplus' => [
        'exclude' => true,
        'label' => 'LLL:EXT:tp3_businessview/Resources/Private/Language/locallang_db.xlf:tx_tp3businessview_domain_model_businessadress.googleplus',
        'config' => [
            'type' => 'input',
            'size' => 30,
            'eval' => 'trim'
        ],
    ],
];

$tmp_tp3_businessview_columns['tp3businessview'] = [
    'config' => [
        'type' => 'passthrough',
    ]
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_address',$tmp_tp3_businessview_columns);



$GLOBALS['TCA']['tt_address']['types']['Tx_Tp3Businessview_BusinessAdress']['showitem'] .= ',--div--;LLL:EXT:tp3_businessview/Resources/Private/Language/locallang_db.xlf:tx_tp3businessview_domain_model_businessadress,';
$GLOBALS['TCA']['tt_address']['types']['Tx_Tp3Businessview_BusinessAdress']['showitem'] .= 'cid';


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
    '',
    'EXT:/Resources/Private/Language/locallang_csh_.xlf'
);
