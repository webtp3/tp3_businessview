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
if (!is_array($GLOBALS['TCA']['tt_content']['types']['texticon'])) {
    $GLOBALS['TCA']['tt_content']['types']['texticon'] = [];
}

/***************
 * Add content element PageTSConfig
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
    $extensionKey,
    'Configuration/TsConfig/Page/ContentElement/Element/Texticon.tsconfig',
    'Bootstrap Package Content Element: Text and Icon'
);

/***************
 * Add content element to selector list
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        'LLL:EXT:tp3mods/Resources/Private/Language/Backend.xlf:content_element.texticon',
        'texticon',
        'content-bootstrappackage-texticon'
    ],
    'textcolumn',
    'after'
);

/***************
 * Assign Icon
 */
$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['texticon'] = 'content-bootstrappackage-texticon';

/***************
 * Register palettes
 */
$GLOBALS['TCA']['tt_content']['palettes']['tp3mods_icons'] = [
    'showitem' => '
        icon_position, icon_type, icon_size, --linebreak--,
        icon_color, icon_background, --linebreak--,
        icon_set, --linebreak--,
        icon, icon_file
    '
];

/***************
 * Configure element type
 */
$GLOBALS['TCA']['tt_content']['types']['texticon'] = array_replace_recursive(
    $GLOBALS['TCA']['tt_content']['types']['texticon'],
    [
        'showitem' => '
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.headers;headers,
                bodytext,
            --div--;LLL:EXT:tp3mods/Resources/Private/Language/Backend.xlf:tabs.icon,
                --palette--;LLL:EXT:tp3mods/Resources/Private/Language/Backend.xlf:field.icon;tp3mods_icons,
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
        'icon_set' => [
            'label' => 'LLL:EXT:tp3mods/Resources/Private/Language/Backend.xlf:field.icon_set',
            'onChange' => 'reload',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['LLL:EXT:tp3mods/Resources/Private/Language/Backend.xlf:option.none', ''],
                    ['Ionicons', 'EXT:tp3mods/Resources/Public/Images/Icons/Ionicons/'],
                    ['Glyphicons', 'EXT:tp3mods/Resources/Public/Images/Icons/Glyphicons/'],
                ],
            ],
        ],
        'icon' => [
            'label' => 'LLL:EXT:tp3mods/Resources/Private/Language/Backend.xlf:field.icon',
            'displayCond' => 'FIELD:icon_set:REQ:true',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['LLL:EXT:tp3mods/Resources/Private/Language/Backend.xlf:option.none', 0, 'EXT:tp3mods/Resources/Public/Images/Icons/none.jpg'],
                ],
                'itemsProcFunc' => 'BK2K\BootstrapPackage\Utility\TextIconUtility->addIconItems',
                'fieldWizard' => [
                    'selectIcons' => [
                        'disabled' => false,
                    ],
                ],
            ],
        ],
        'icon_file' => [
            'label' => 'LLL:EXT:tp3mods/Resources/Private/Language/Backend.xlf:field.icon_file',
            'displayCond' => 'FIELD:icon_set:REQ:false',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'icon_file',
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
                    'minitems' => 1,
                    'maxitems' => 1,
                ],
                'gif,png,svg'
            ),
        ],
        'icon_position' => [
            'label' => 'LLL:EXT:tp3mods/Resources/Private/Language/Backend.xlf:field.icon_position',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['LLL:EXT:tp3mods/Resources/Private/Language/Backend.xlf:option.left', 'left'],
                    ['LLL:EXT:tp3mods/Resources/Private/Language/Backend.xlf:option.right', 'right'],
                    ['LLL:EXT:tp3mods/Resources/Private/Language/Backend.xlf:option.top', 'top'],
                ],
            ],
        ],
        'icon_type' => [
            'label' => 'LLL:EXT:tp3mods/Resources/Private/Language/Backend.xlf:field.icon_type',
            'onChange' => 'reload',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 'default',
                'items' => [
                    ['LLL:EXT:tp3mods/Resources/Private/Language/Backend.xlf:option.default', 'default'],
                    ['LLL:EXT:tp3mods/Resources/Private/Language/Backend.xlf:option.square', 'square'],
                    ['LLL:EXT:tp3mods/Resources/Private/Language/Backend.xlf:option.circle', 'circle'],
                ],
            ],
        ],
        'icon_size' => [
            'label' => 'LLL:EXT:tp3mods/Resources/Private/Language/Backend.xlf:field.icon_size',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['LLL:EXT:tp3mods/Resources/Private/Language/Backend.xlf:option.default', 'default'],
                    ['LLL:EXT:tp3mods/Resources/Private/Language/Backend.xlf:option.medium', 'medium'],
                    ['LLL:EXT:tp3mods/Resources/Private/Language/Backend.xlf:option.large', 'large'],
                    ['LLL:EXT:tp3mods/Resources/Private/Language/Backend.xlf:option.awesome', 'awesome'],
                ],
            ],
        ],
        'icon_color' => [
            'displayCond' => 'FIELD:icon_type:!=:default',
            'label' => 'LLL:EXT:tp3mods/Resources/Private/Language/Backend.xlf:field.icon_color',
            'config' => [
                'type' => 'input',
                'renderType' => 'colorpicker',
                'default' => '#FFFFFF',
            ],
        ],
        'icon_background' => [
            'displayCond' => 'FIELD:icon_type:!=:default',
            'label' => 'LLL:EXT:tp3mods/Resources/Private/Language/Backend.xlf:field.icon_background',
            'config' => [
                'type' => 'input',
                'renderType' => 'colorpicker',
                'default' => '#333333',
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
