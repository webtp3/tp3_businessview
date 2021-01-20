<?php

/*
 * This file is part of the web-tp3/tp3businessview.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

return [
    'ctrl' => [
        'title'	=> 'LLL:EXT:tp3_businessview/Resources/Private/Language/locallang_db.xlf:tx_tp3businessview_domain_model_panoramas',
        'label' => 'title',
        'label_alt' => 'pano_id',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'rootLevel' => -1,
        'sortby' => 'sorting',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'title,pano_id,heading,pitch,zoom',
        'iconfile' => 'EXT:tp3_businessview/Resources/Public/Icons/user_plugin_tp3businessview.svg',
        'typeicon_classes' => [
            'default' => 'ext-tp3_businessview-wizard-icon'
        ],
    ],
    'interface' => [
        'showRecordFieldList' => 'hidden, title, pano_id, heading, pitch, zoom, position, tp3businessviews,',
    ],
    'types' => [
        '1' => ['showitem' => 'hidden, title, pano_id, heading, pitch, zoom, tp3businessviews, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
    ],
    'columns' => [
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
                    ]
                ],
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'size' => 13,
                'eval' => 'datetime',
                'renderType' => 'inputDateTime',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ]
            ]
        ],
        'endtime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'size' => 13,
                'eval' => 'datetime',
                'renderType' => 'inputDateTime',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038)
                ]
            ],
        ],
        'title' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tp3_businessview/Resources/Private/Language/locallang_db.xlf:tx_tp3businessview_domain_model_panoramas.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'pano_id' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tp3_businessview/Resources/Private/Language/locallang_db.xlf:tx_tp3businessview_domain_model_panoramas.pano_id',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ],
        ],
        'heading' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tp3_businessview/Resources/Private/Language/locallang_db.xlf:tx_tp3businessview_domain_model_panoramas.heading',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],

        'pitch' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tp3_businessview/Resources/Private/Language/locallang_db.xlf:tx_tp3businessview_domain_model_panoramas.pitch',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'zoom' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tp3_businessview/Resources/Private/Language/locallang_db.xlf:tx_tp3businessview_domain_model_panoramas.zoom',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'position' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tp3_businessview/Resources/Private/Language/locallang_db.xlf:tx_tp3businessview_domain_model_panoramas.position',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'tp3businessviews' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tp3_businessview/Resources/Private/Language/locallang_db.xlf:tx_tp3businessview_domain_model_tp3businessview.panoramas',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingleBox',
                'items' => [
                    [
                        '', 0
                    ]
                ],
                'foreign_table' => 'tx_tp3businessview_domain_model_tp3businessview',
              //  'foreign_table_where' => 'AND  tx_tp3businessview_domain_model_panoramas_mm.uid_local=###THIS_UID###',
               // 'foreign_table_where' => 'AND tx_tp3businessview_domain_model_panoramas_mm.pid=###CURRENT_PID### AND tx_tp3businessview_domain_model_panoramas_mm.uid_local!=###THIS_UID###',
                'foreign_sortby' => 'sorting',
                'allowed' => 'tx_tp3businessview_domain_model_tp3businessview',
                'MM' => 'tx_tp3businessview_domain_model_panoramas_mm',
                'MM_opposite_field' => 'panoramas',
                'minitems' => 1,
                'maxitems' => 10,
                'size' => 1,
            ],
        ],
        'sorting' => [
            'config' => [
                'type' => 'none',
            ],
        ],
    ]
];
//tx_tp3businessview_domain_model_tp3businessview.pid=###CURRENT_PID### AND
