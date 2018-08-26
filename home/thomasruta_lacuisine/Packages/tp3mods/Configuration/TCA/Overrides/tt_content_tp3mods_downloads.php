<?php
defined('TYPO3_MODE') || die();
return;
/***************
 * Add Content Element
 */
//$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['media'] = 'mimetypes-x-content-multimedia';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        'LLL:EXT:bootstrap_package/Resources/Private/Language/Backend.xlf:content_element.tp3mods_downloads',
        'tp3mods_downloads',
        'mimetypes-x-content-multimedia'
    ],
    'listgroup',
    'after'
);
if (!is_array($GLOBALS['TCA']['tt_content']['types']['tp3mods_downloads'])) {
    $GLOBALS['TCA']['tt_content']['types']['tp3mods_downloads'] = [];
}
$GLOBALS['TCA']['tt_content']['types']['tp3mods_downloads'] = array_replace_recursive(
    $GLOBALS['TCA']['tt_content']['types']['tp3mods_downloads'],
    [
        'showitem' => '
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.headers;headers,
            --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.media,
                assets,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/Database.xlf:tt_content.palette.mediaAdjustments;mediaAdjustments,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/Database.xlf:tt_content.palette.gallerySettings;gallerySettings,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.imagelinks;imagelinks,
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
            'assets' => [
                'config' => [
                    'filter' => [
                        0 => [
                            'parameters' => [
                                'allowedFileExtensions' => 'pdf, jpg, svg, png, avi, wmv'
                            ]
                        ]
                    ],
                    'overrideChildTca' => [
                        'columns' => [
                            'uid_local' => [
                                'config' => [
                                    'appearance' => [
                                        'elementBrowserAllowed' => 'pdf, jpg, svg, png, avi, wmv'
                                    ]
                                ]
                            ]
                        ]
                    ]
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

       /* 'icon_position' => [
            'label' => 'LLL:EXT:tp3mods/Resources/Private/Language/locallang_tp3backend.xlf:tp3mods_downloads.position',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['LLL:EXT:tp3mods/Resources/Private/Language/locallang_tp3backend.xlf:tp3mods_downloads.left', 'left'],
                    ['LLL:EXT:tp3mods/Resources/Private/Language/locallang_tp3backend.xlf:tp3mods_downloads.right', 'right'],
                    ['LLL:EXT:tp3mods/Resources/Private/Language/locallang_tp3backend.xlf:tp3mods_downloads.center', 'center'],
                ],
            ],
        ],
        'thumbnails' => [
            'label' => 'LLL:EXT:tp3mods/Resources/Private/Language/locallang_tp3backend.xlf:tp3mods_downloads.thumbnails',
           // 'onChange' => 'reload',
            'config' => [
                'type' => 'check',
                'renderType' => 'selectSingle',
                'default' => '0',
                'items' => [
                    ['LLL:EXT:tp3mods/Resources/Private/Language/locallang_tp3backend.xlf:tp3mods_downloads.thumbnails.description', 1],

                ],
            ],
        ],
*/

    ]
);

