<?php

/*
 * This file is part of the package web-tp3/tp3-businessview.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

return [
    'ctrl' => [
        'title'	=> 'LLL:EXT:tp3_businessview/Resources/Private/Language/locallang_db.xlf:tx_tp3businessview_domain_model_tp3businessview',
        'label' => 'name',
        'label_alt' => 'created_by',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'rootLevel' => -1,
        'sortby' => 'sorting',
        'languageField' => 'sys_language_uid',

        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'created_by,name,external_links,gallery,intro,description,pano_animation,social_gallery,pano_options,contact,panoramas',
        'iconfile' => 'EXT:tp3_businessview/Resources/Public/Icons/tx_tp3businessview_domain_model_tp3businessview.gif',
        'typeicon_classes' => [
            'default' => 'ext-tp3_businessview-wizard-icon'
        ],
    ],

    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, created_by, name, external_links, gallery, intro, description, pano_animation, social_gallery, pano_options, contact,  panoramas, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'language',
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_tp3businessview_domain_model_tp3businessview',
                'foreign_table_where' => 'AND tx_tp3businessview_domain_model_tp3businessview.pid=###CURRENT_PID### AND tx_tp3businessview_domain_model_tp3businessview.sys_language_uid IN (-1,0)',
                'showIconTable' => false,
                'default' => 0,
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
                'default' => ''

            ],
        ],
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
        'created_by' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tp3_businessview/Resources/Private/Language/locallang_db.xlf:tx_tp3businessview_domain_model_tp3businessview.created_by',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'name' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tp3_businessview/Resources/Private/Language/locallang_db.xlf:tx_tp3businessview_domain_model_tp3businessview.name',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'external_links' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tp3_businessview/Resources/Private/Language/locallang_db.xlf:tx_tp3businessview_domain_model_tp3businessview.external_links',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'gallery' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tp3_businessview/Resources/Private/Language/locallang_db.xlf:tx_tp3businessview_domain_model_tp3businessview.gallery',
            'config' => [
                'type' => 'check'
            ],
        ],
        'intro' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tp3_businessview/Resources/Private/Language/locallang_db.xlf:tx_tp3businessview_domain_model_tp3businessview.intro',
            'config' => [
                'type' => 'check'

            ],
        ],
        'pano_animation' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tp3_businessview/Resources/Private/Language/locallang_db.xlf:tx_tp3businessview_domain_model_tp3businessview.pano_animation',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectCheckBox',
                'items' => [
                    [  'jumps' , 'jumps'],
                    [   'rotation', 'rotation'],

                ],
                'maxitems' => 99,
                'eval' => ''
            ],
        ],
        'social_gallery' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tp3_businessview/Resources/Private/Language/locallang_db.xlf:tx_tp3businessview_domain_model_tp3businessview.social_gallery',
            'config' => [
                'type' => 'check'
            ],
        ],
        'pano_options' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tp3_businessview/Resources/Private/Language/locallang_db.xlf:tx_tp3businessview_domain_model_tp3businessview.pano_options',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectCheckBox',
                'items' => [
                            ['addressControl' , 'addressControl'],
                            ['disableDefaultUI', 'disableDefaultUI'],
                            ['panControl' , 'panControl'],
                            ['scaleControl' , 'scaleControl'],
                            ['scrollwheel' , 'scrollwheel'],
                            ['zoomControl', 'zoomControl'],
                            ['fullScreen', 'fullScreen'],
                    ],
                'maxitems' => 99,
                'eval' => 'trim'
            ],
        ],
        'contact' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tp3_businessview/Resources/Private/Language/locallang_db.xlf:tx_tp3businessview_domain_model_tp3businessview.contact',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    [
                        '', 0
                    ]
                ],
                'foreign_table' => 'tt_address',
          //      'foreign_table_where' => 'AND tx_tp3businessview_domain_model_tp3businessview_mm.uid_local=###THIS_UID###  AND tx_tp3businessview_domain_model_tp3businessview.sys_language_uid IN (-1,0)',
                'foreign_sortby' => 'sorting',
                'MM' => 'tx_tp3businessview_domain_model_tp3businessview_mm',
                'MM_hasUidField' => true,
                'minitems' => 1,
                'maxitems' => 1,
                'size' => 1,
            ],
        ],
        'panoramas' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tp3_businessview/Resources/Private/Language/locallang_db.xlf:tx_tp3businessview_domain_model_tp3businessview.panoramas',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_tp3businessview_domain_model_panoramas',
                'foreign_sortby' => 'sorting',
            //    'foreign_table_where' => 'AND tx_tp3businessview_domain_model_tp3businessview.sys_language_uid IN (-1,0) ',
                'allowed' => 'tx_tp3businessview_domain_model_panoramas',
                'MM' => 'tx_tp3businessview_domain_model_panoramas_mm',
          //      'MM_hasUidField' => true,
                'MM_opposite_field' => 'tp3businessviews',
                'minitems' => 1,
                'maxitems' => 99,

            ],
        ],
        'description' => [
            'exclude' => true,
            'label' => 'LLL:EXT:tp3_businessview/Resources/Private/Language/locallang_db.xlf:tx_tp3businessview_domain_model_tp3businessview.description',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
                'softref' => 'typolink_tag,images,email[subst],url',
                'enableRichtext' => true,
                'richtextConfiguration' => 'default'
            ]
        ],
        'sorting' => [
            'config' => [
                'type' => 'none',
            ],
        ],
    ],
];
