<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:tp3mods/Resources/Private/Language/locallang_db.xlf:tx_tp3mods_domain_model_tp3mods',
        'label' => 'microdata',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'microdata,konfiguration,snippet_type,main_entry,aggregate_rating,address',
        'iconfile' => 'EXT:tp3mods/Resources/Public/Icons/tx_tp3mods_domain_model_tp3mods.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'hidden, microdata, konfiguration, snippet_type, main_entry, aggregate_rating, address',
    ],
    'types' => [
        '1' => ['showitem' => 'hidden, microdata, konfiguration, snippet_type, main_entry, aggregate_rating, address, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
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
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ]
        ],
        'konfiguration' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tp3mods/Resources/Private/Language/locallang_db.xlf:tx_tp3mods_domain_model_tp3mods.konfiguration',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ]
        ],
        'snippet_type' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tp3mods/Resources/Private/Language/locallang_db.xlf:tx_tp3mods_domain_model_tp3mods.snippet_type',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ]
        ],
        'main_entry' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tp3mods/Resources/Private/Language/locallang_db.xlf:tx_tp3mods_domain_model_tp3mods.main_entry',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ]
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
    
    ],
];
