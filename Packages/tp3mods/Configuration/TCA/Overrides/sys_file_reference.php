<?php

/*
 * This file is part of the web-tp3/tp3mods.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3_MODE') or die();

//if (\GeorgRinger\News\Utility\EmConfiguration::getSettings()->isAdvancedMediaPreview()) {
//    $fieldConfig = [
//        'type' => 'select',
//        'renderType' => 'selectSingle',
//        'items' => [
//            ['LLL:EXT:news/Resources/Private/Language/locallang_db.xlf:tx_news_domain_model_media.showinviews.0', 0, ''],
//            ['LLL:EXT:news/Resources/Private/Language/locallang_db.xlf:tx_news_domain_model_media.showinviews.1', 1, ''],
//            ['LLL:EXT:news/Resources/Private/Language/locallang_db.xlf:tx_news_domain_model_media.showinviews.2', 2, ''],
//        ],
//        'default' => 0,
//    ];
//} else {
//    $fieldConfig = [
//        'type' => 'check',
//        'default' => 0
//    ];
//}

$newSysFileReferenceColumns = [
    'speed' => [
        'exclude' => true,
        'label' => 'LLL:EXT:tp3mods/Resources/Private/Language/locallang_db.xlf:sys_file_reference.speed',
        'displayCond' => 'FIELD:tp3parallax:REQ:true',
        'config' =>  [
            'type' => 'input',
            'default' => '-20',
            'eval' => 'trim,int',
            'range' => [
                'lower' => -100,
                'upper' => 100,
            ],
            'slider' => [
                'step' => 5,
                'width' => 200,
            ],
        ],

    ],
    'parallax' => [
        'exclude' => true,
        'displayCond' => 'FIELD:tp3parallax:REQ:true',
        'label' => 'LLL:EXT:tp3mods/Resources/Private/Language/locallang_db.xlf:sys_file_reference.parallax',
        'config' => [
            'type' => 'check',
            'default' => 0
        ],
    ],
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('sys_file_reference', $newSysFileReferenceColumns);
//\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette('sys_file_reference', 'layout', 'showinpreview');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette('sys_file_reference', 'imageoverlayPalette', '--linebreak--, parallax, speed', 'after:description');
