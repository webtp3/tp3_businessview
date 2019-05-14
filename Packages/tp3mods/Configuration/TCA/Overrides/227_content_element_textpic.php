<?php

/*
 * This file is part of the package bk2k/bootstrap-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3_MODE') || die();

/***************
 * Add content element PageTSConfig
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
    $extensionKey,
    'Configuration/TsConfig/Page/ContentElement/Element/Textpic.tsconfig',
    'Bootstrap Package Content Element: Text and Images'
);

/***************
 * Add additional fields
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    'file_folder, filelink_sorting',
    'textpic',
    'after:image'
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
