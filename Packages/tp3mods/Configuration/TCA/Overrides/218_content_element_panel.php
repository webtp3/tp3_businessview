<?php

/*
 * This file is part of the package bk2k/bootstrap-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3_MODE') || die();

/***************
 * Add Content Element
 */
if (!is_array($GLOBALS['TCA']['tt_content']['types']['panel'])) {
    $GLOBALS['TCA']['tt_content']['types']['panel'] = [];
}

/***************
 * Add content element PageTSConfig
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
    $extensionKey,
    'Configuration/TsConfig/Page/ContentElement/Element/Panel.tsconfig',
    'Bootstrap Package Content Element: Panel'
);

/***************
 * Add content element to selector list
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        'LLL:EXT:tp3mods/Resources/Private/Language/Backend.xlf:content_element.panel',
        'panel',
        'content-panel'
    ],
    'menu_thumbnail_dir',
    'after'
);

/***************
 * Assign Icon
 */
$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['panel'] = 'content-panel';

/***************
 * Configure element type
 */
$GLOBALS['TCA']['tt_content']['types']['panel'] = array_replace_recursive(
    $GLOBALS['TCA']['tt_content']['types']['panel'],
    [
        'showitem' => '
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.header;header_minimal,
                bodytext,
                panel_class,
            --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.frames;frames,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.appearanceLinks;appearanceLinks,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
                --palette--;;language,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                --palette--;;hidden,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories,
                categories,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes,
                rowDescription,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,
        ',
        'columnsOverrides' => [
            'bodytext' => [
                'label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:bodytext_formlabel',
                'config' => [
                    'enableRichtext' => true,
                    'richtextConfiguration' => 'default'
                ]
            ]
        ]
    ]
);

/***************
 * Register fields
 */
$GLOBALS['TCA']['tt_content']['columns'] = array_replace_recursive(
    $GLOBALS['TCA']['tt_content']['columns'],
    [
        'panel_class' => [
            'label' => 'LLL:EXT:tp3mods/Resources/Private/Language/Backend.xlf:field.panel_class',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['LLL:EXT:tp3mods/Resources/Private/Language/Backend.xlf:option.default', 'default'],
                    ['LLL:EXT:tp3mods/Resources/Private/Language/Backend.xlf:option.primary', 'primary'],
                    ['LLL:EXT:tp3mods/Resources/Private/Language/Backend.xlf:option.success', 'success'],
                    ['LLL:EXT:tp3mods/Resources/Private/Language/Backend.xlf:option.info', 'info'],
                    ['LLL:EXT:tp3mods/Resources/Private/Language/Backend.xlf:option.warning', 'warning'],
                    ['LLL:EXT:tp3mods/Resources/Private/Language/Backend.xlf:option.danger', 'danger'],
                ],
            ],
        ],
    ]
);

/***************
 * Adjust columns for generic usage
 */
$GLOBALS['TCA']['tt_content']['columns']['background_color_class'] = [
    'exclude' => true,
    'displayCond' => 'FIELD:frame_class:!=:none',
    'label' => 'LLL:EXT:tp3mods/Resources/Private/Language/Backend.xlf:field.background_color_class',
    'config' => [
        'type' => 'select',
        'renderType' => 'selectSingle',
        'items' => [
            ['none', 'none'],
            ['primary', 'primary'],
            ['secondary', 'secondary'],
            ['light', 'light'],
            ['dark', 'dark']
        ]
    ],
    'l10n_mode' => 'exclude',
];
$GLOBALS['TCA']['tt_content']['columns']['background_image'] = [
    'exclude' => true,
    'displayCond' => 'FIELD:frame_class:!=:none',
    'label' => 'LLL:EXT:tp3mods/Resources/Private/Language/Backend.xlf:field.background_image',
    'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
        'background_image',
        [
            'appearance' => [
                'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference'
            ],
            'overrideChildTca' => [
                'types' => [
                    \TYPO3\CMS\Core\Resource\File::FILETYPE_UNKNOWN => [
                        'showitem' => '
                            --palette--;;filePalette
                        '
                    ],
                    \TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => [
                        'showitem' => '
                            --palette--;;filePalette
                        '
                    ],
                    \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                        'showitem' => '
                            crop,
                            --palette--;;filePalette
                        '
                    ],
                    \TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => [
                        'showitem' => '
                            --palette--;;filePalette
                        '
                    ],
                    \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => [
                        'showitem' => '
                            --palette--;;filePalette
                        '
                    ],
                    \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => [
                        'showitem' => '
                            --palette--;;filePalette
                        '
                    ],
                ],
            ],
            'minitems' => 0,
            'maxitems' => 1,
        ],
        $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
    ),
    'l10n_mode' => 'exclude',
];
$GLOBALS['TCA']['tt_content']['columns']['background_image_options'] = [
    'exclude' => true,
    'displayCond' => 'FIELD:frame_class:!=:none',
    'label' => 'LLL:EXT:tp3mods/Resources/Private/Language/Backend.xlf:field.background_image_options',
    'config' => [
        'type' => 'flex',
        'ds' => [
            'default' => 'FILE:EXT:tp3mods/Configuration/FlexForms/BackgroundImage.xml',
        ],
    ],
    'l10n_mode' => 'exclude',
];
