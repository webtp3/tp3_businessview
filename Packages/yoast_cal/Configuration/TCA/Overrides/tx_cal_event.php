<?php
$llPrefix = 'LLL:EXT:yoast_cal/Resources/Private/Language/TCA.xlf:';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
    'tx_cal_event',
    [
        'tx_yoastseo_snippetpreview' => [
            'label' => $llPrefix . 'news.field.snippetPreview',
            'exclude' => true,
            'displayCond' => 'REC:NEW:false',
            'config' => [
                'type' => 'text',
                'renderType' => 'snippetPreview',
                'settings' => [
                    'titleField' => 'title',
                    'descriptionField' => 'description'
                ]
            ]
        ],
        'tx_yoastseo_readability_analysis' => [
            'label' => $llPrefix . 'news.field.analysis',
            'exclude' => true,
            'config' => [
                'type' => 'text',
                'renderType' => 'readabilityAnalysis'
            ]
        ],
        'tx_yoastseo_focuskeyword' => [
            'label' => $llPrefix . 'news.field.seoFocusKeyword',
            'exclude' => true,
            'config' => [
                'type' => 'input',
            ]
        ],
        'tx_yoastseo_focuskeyword_analysis' => [
            'label' => $llPrefix . 'news.field.analysis',
            'exclude' => true,
            'config' => [
                'type' => 'input',
                'renderType' => 'focusKeywordAnalysis',
                'settings' => [
                    'focusKeywordField' => 'tx_yoastseo_focuskeyword',
                ]
            ]
        ],

    ]
);
//
//\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
//    'tx_cal_event',
//    'yoast-metadata',
//    '
//    --linebreak--, tx_yoastseo_snippetpreview,
//    --linebreak--, alternative_title,
//    --linebreak--, description,
//    '
//);
//
//\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
//    'tx_cal_event',
//    'yoast-focuskeyword',
//    '
//    --linebreak--, tx_yoastseo_focuskeyword,
//    --linebreak--, tx_yoastseo_focuskeyword_analysis
//    '
//);
//
//\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
//    'tx_cal_event',
//    'yoast-readability',
//    '
//    --linebreak--, tx_yoastseo_readability_analysis
//    '
//);
//
//$GLOBALS['TCA']['tx_cal_event']['palettes']['metatags']['showitem'] =
//    preg_replace('/description(.*,|.*$)/', '', $GLOBALS['TCA']['tx_cal_event']['palettes']['metatags']['showitem']);
//
//$GLOBALS['TCA']['tx_cal_event']['palettes']['alternativeTitles']['showitem'] =
//    preg_replace('/alternative_title(.*,|.*$)/', '', $GLOBALS['TCA']['tx_cal_event']['palettes']['alternativeTitles']['showitem']);
//
//\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
//    'tx_cal_event',
//    '
//    --div--;' . $llPrefix . 'news.tabs.seo,
//        --palette--;' . $llPrefix . 'news.palettes.metadata;yoast-metadata,
//        --palette--;' . $llPrefix . 'news.palettes.readability;yoast-readability,
//        --palette--;' . $llPrefix . 'news.palettes.seo;yoast-focuskeyword,
//    ',
//    '',
//    'after:bodytext'
//);
