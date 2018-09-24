<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'Tp3.Tp3mods',
            'Tp3micro',
            [
                'Tp3Mods' => 'list, show',
                'Tp3Adress' => 'list, show'
            ],
            // non-cacheable actions
            [
                'Tp3Mods' => '',
                'Tp3Adress' => ''
            ]
        );

    // wizards
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        'mod {
            wizards.newContentElement.wizardItems.plugins {
                elements {
                    tp3micro {
                        iconIdentifier = tp3mods-plugin-tp3micro
                        title = LLL:EXT:tp3mods/Resources/Private/Language/locallang_db.xlf:tx_tp3mods_tp3micro.name
                        description = LLL:EXT:tp3mods/Resources/Private/Language/locallang_db.xlf:tx_tp3mods_tp3micro.description
                        tt_content_defValues {
                            CType = list
                            list_type = tp3mods_tp3micro
                        }
                    }
                }
                show = *
            }
       }'
    );
		$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
		
			$iconRegistry->registerIcon(
				'tp3mods-plugin-tp3micro',
				\TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
				['source' => 'EXT:tp3mods/Resources/Public/Icons/user_plugin_tp3micro.svg']
			);
		
    }
);
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder