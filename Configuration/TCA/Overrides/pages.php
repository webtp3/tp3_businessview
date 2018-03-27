<?php

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
    'pages',
    [


        'tx_tp3businessview_onpage' => [
            'label' => 'Display on page',
            'exclude' => true,
            'config' => [
                'type' => 'check'
            ]
        ],
        'tx_tp3businessview_panorama' => [
            'label' => 'Display on page',
            'exclude' => true,
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_tp3businessview_domain_model_panoramas',
                'maxitems' => 9999,
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
            'label' => '',
            'exclude' => true,
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ]
        ],
    ]
);

