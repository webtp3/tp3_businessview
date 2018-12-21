<?php
defined('TYPO3_MODE') || die();

$tmp_tp3_parallax_columns = [

    'parallax_page' => [
        'exclude' => true,
        'label' => 'LLL:EXT:tp3_parallax/Resources/Private/Language/locallang_db.xlf:tx_tp3parallax_domain_model_collections.parallaxsection',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectTree',
            'MM' => 'tx_tp3_parallax_mm',
            'MM_hasUidField' => true,
            'MM_opposite_field' => 'page_parallax',
            'maxitems' => 100,
            'foreign_table' => 'pages',
            'minitems' => 0,
            'enableMultiSelectFilterTextfield' => true,
            'items' => [
                [ '',  ],
            ],
            'treeConfig' => [
                'parentField' => 'pid',
                'appearance' => [
                    'expandAll' => true,
                    'showHeader' => true,
                ],
            ],
            'appearance' => [
                'collapseAll' => 0,
                'levelLinksPosition' => 'top',
                'showSynchronizationLink' => 1,
                'showPossibleLocalizationRecords' => 1,
                'showAllLocalizationLink' => 1
            ],
        ],

    ],
    'parallax_content' => [
        'exclude' => true,
        'label' => 'LLL:EXT:tp3_parallax/Resources/Private/Language/locallang_db.xlf:tx_tp3parallax_domain_model_collections.parallax_content',
        'config' => [
            'type' => 'text',
            'cols' => 40,
            'rows' => 15,
            'eval' => 'trim'
        ]
    ],

];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('sys_file_collection',$tmp_tp3_parallax_columns);

/* inherit and extend the show items from the parent class */

if (isset($GLOBALS['TCA']['sys_file_collection']['types']['0']['showitem'])) {
    $GLOBALS['TCA']['sys_file_collection']['types']['Tx_Tp3Parallax_Collections']['showitem'] = $GLOBALS['TCA']['sys_file_collection']['types']['0']['showitem'];
} elseif(is_array($GLOBALS['TCA']['sys_file_collection']['types'])) {
    // use first entry in types array
    $sys_file_collection_type_definition = reset($GLOBALS['TCA']['sys_file_collection']['types']);
    $GLOBALS['TCA']['sys_file_collection']['types']['Tx_Tp3Parallax_Collections']['showitem'] = $sys_file_collection_type_definition['showitem'];
} else {
    $GLOBALS['TCA']['sys_file_collection']['types']['Tx_Tp3Parallax_Collections']['showitem'] = '';
}
$GLOBALS['TCA']['sys_file_collection']['types']['Tx_Tp3Parallax_Collections']['showitem'] .= ',--div--;LLL:EXT:tp3_parallax/Resources/Private/Language/locallang_db.xlf:tx_tp3parallax_domain_model_collections,';
$GLOBALS['TCA']['sys_file_collection']['types']['Tx_Tp3Parallax_Collections']['showitem'] .= 'parallax_page, parallax_content';
