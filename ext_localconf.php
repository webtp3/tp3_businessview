<?php
defined('TYPO3_MODE') || die('Access denied.');

/***************
 * Make the extension configuration accessible
 */
if (class_exists('TYPO3\CMS\Core\Configuration\ExtensionConfiguration')) {
    $extensionConfiguration = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
        \TYPO3\CMS\Core\Configuration\ExtensionConfiguration::class
    );
    $tp3modsConfig = $extensionConfiguration->get('tp3_businessview');
} else {
    // Fallback for CMS8
    // @extensionScannerIgnoreLine
    $tp3modsConfig = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['tp3_businessview'];
    if (!is_array($tp3modsConfig)) {
        $tp3modsConfig = unserialize($tp3modsConfig);
    }
}
if (!is_array($tp3modsConfig)) {
    $tp3modsConfig = unserialize($tp3modsConfig);
}

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
						icon = ' . \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/user_plugin_tp3businessview.svg
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
   