<?php

$extensionKey = "tp3_parallax";


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
    'pages',
    [

        'page_parallax' => [
            'label' => 'tp3 parallax',
            'exclude' => true,
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'MM' => 'tx_tp3_parallax_mm',
                'MM_hasUidField' => true,
                'MM_opposite_field' => 'parallax_page',
                'maxitems' => 1,
                'foreign_table' => 'sys_file_collection',
                'minitems' => 0,
                'enableMultiSelectFilterTextfield' => true,
                'items' => [
                    [ '',  ],
                ],
                'appearance' => [
                    'collapseAll' => 0,
                    'levelLinksPosition' => 'top',
                ],
            ]
        ],


    ]
);



\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
    'pages',
    'layout',
    '
    --linebreak--, page_parallax,
    '
);