<?php
return [
    'ctrl' => [
        'title'	=> 'LLL:EXT:tp3_businessview/Resources/Private/Language/locallang_db.xlf:tx_tp3businessview_domain_model_panoramas',
        'label' => 'pano_id',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'rootLevel' => -1,
        'cruser_id' => 'cruser_id',
		'delete' => 'deleted',
		'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
		'searchFields' => 'pano_id,heading,pitch,zoom',
        'iconfile' => 'EXT:tp3_businessview/Resources/Public/Icons/tx_tp3businessview_domain_model_panoramas.gif'
    ],
    'interface' => [
		'showRecordFieldList' => 'hidden, pano_id, heading, pitch, zoom',
    ],
    'types' => [
		'1' => ['showitem' => 'hidden, pano_id, heading, pitch, zoom, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
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
    ],
];
