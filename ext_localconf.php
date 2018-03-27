<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function($extKey)
	{

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'Tp3.Tp3Businessview',
            'Tp3businessview',
            [
                'Tp3BusinessView' => 'display'
            ],
            // non-cacheable actions
            [
                'Tp3BusinessView' => ''
            ]
        );

	// wizards
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
		'mod {
			wizards.newContentElement.wizardItems.plugins {
				elements {
					tp3businessview {
						icon = ' . \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($extKey) . 'Resources/Public/Icons/user_plugin_tp3businessview.svg
						title = LLL:EXT:tp3_businessview/Resources/Private/Language/locallang_db.xlf:tx_tp3_businessview_domain_model_tp3businessview
						description = LLL:EXT:tp3_businessview/Resources/Private/Language/locallang_db.xlf:tx_tp3_businessview_domain_model_tp3businessview.description
						tt_content_defValues {
							CType = list
							list_type = tp3businessview_tp3businessview
						}
					}
				}
				show = *
			}
	   }'
	);
    },
    $_EXTKEY
);
