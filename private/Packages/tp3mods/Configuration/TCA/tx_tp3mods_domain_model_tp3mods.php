<?php

/*
 * This file is part of the web-tp3/tp3mods.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

return [
    'ctrl' => [
        'title' => 'LLL:EXT:tp3mods/Resources/Private/Language/locallang_db.xlf:tx_tp3mods_domain_model_tp3mods',
        'label' => 'snippet_type',
        'label_alt' => 'microdata',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'microdata,konfiguration,snippet_type,main_entry,address',
        'iconfile' => 'EXT:tp3mods/Resources/Public/Icons/tx_tp3mods_domain_model_tp3mods.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'hidden, snippet_type, microdata, konfiguration, main_entry,  address',
    ],
    'types' => [
        '1' => ['showitem' => 'hidden, snippet_type, microdata, konfiguration,  main_entry,  address, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
    ],
    'columns' => [
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/Resources/Private/Language/locallang_core.xlf:labels.enabled'
                    ]
                ],
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'behaviour' => [
                'allowLanguageSynchronization' => true
            ],
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 13,
                'eval' => 'datetime',
                'default' => 0,
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'behaviour' => [
                'allowLanguageSynchronization' => true
            ],
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 13,
                'eval' => 'datetime',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038)
                ],
            ],
        ],

        'microdata' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tp3mods/Resources/Private/Language/locallang_db.xlf:tx_tp3mods_domain_model_tp3mods.microdata',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectCheckBox',
                'items' => [
                    ['WebSite', 'WebSite', '', 'required'],
                    ['SearchAction', 'SearchAction', '', 'indexsearch needed'],
                    ['AggregateRating', 'AggregateRating', '', 'tp3rating needed'],
                    ['BreadcrumbList', 'BreadcrumbList', '', 'bootstrap_package needed'],
                    ['SiteNavigation', 'SiteNavigation', '', 'element configuration'],
                    ['LocalBusiness', 'LocalBusiness', '', 'tt_address needed'],
                    ['openingHours', 'openingHours', '', 'tp3_openhours needed'],

                ],
            ]
        ],
        'konfiguration' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tp3mods/Resources/Private/Language/locallang_db.xlf:tx_tp3mods_domain_model_tp3mods.konfiguration',
            'config' => [
                'type' => 'input',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ]
        ],
        'snippet_type' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tp3mods/Resources/Private/Language/locallang_db.xlf:tx_tp3mods_domain_model_tp3mods.snippet_type',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['WebPage', 'WebPage'],
                    ['AboutPage', 'AboutPage'],
                    ['CheckoutPage', 'CheckoutPage'],
                    ['CollectionPage', 'CollectionPage'],
                    ['ImageGallery', 'ImageGallery'],
                    ['VideoGallery', 'VideoGallery'],
                    ['ContactPage', 'ContactPage'],
                    ['FAQPage', 'FAQPage'],
                    ['MedicalWebPage', 'MedicalWebPage'],
                    ['ProfilePage', 'ProfilePage'],
                    ['QAPage', 'QAPage'],
                    ['SearchResultsPage', 'SearchResultsPage'],

                ],
                'size' => 3,
                'maxitems' => 1,

            ]
        ],
        'main_entry' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tp3mods/Resources/Private/Language/locallang_db.xlf:tx_tp3mods_domain_model_tp3mods.main_entry',
            'config' => [
                'type' => 'input',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ]
        ],
        'address' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tp3mods/Resources/Private/Language/locallang_db.xlf:tx_tp3mods_domain_model_tp3mods.address',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tt_address',
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],
        'aggregate_rating' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tp3mods/Resources/Private/Language/locallang_db.xlf:tx_tp3mods_domain_model_tp3mods.aggregate_rating',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/Resources/Private/Language/locallang_core.xlf:labels.enabled'
                    ]
                ],
                'default' => 0,
            ]

        ],
        'pages' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tp3mods/Resources/Private/Language/locallang_db.xlf:tx_tp3mods_domain_model_tp3mods.pages',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'pages',
                'MM' => 'tx_tp3mods_domain_model_mm',
                'MM_hasUidField' => true,
                'MM_opposite_field' => 'tp3microdata',
                'maxitems' => 10,
                'appearance' => [
                    'showSynchronizationLink' => 1,
                    'showAllLocalizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showRemovedLocalizationRecords' => 1,
                ],
                'behaviour' => [
                    'localizationMode' => 'select',
                ],
            ],
        ],
        'sorting' => [
            'config' => [
                'type' => 'none',
            ],
        ],
    ],
];
