<?php

/*
 * This file is part of the package web-tp3/tp3-businessview.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3') || die('Access denied.');
$_EXTKEY = 'tp3_businessview';

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Tp3.Tp3Businessview',
    'Tp3businessview',
    [
        \Tp3\Tp3Businessview\Controller\Tp3BusinessViewController::class => 'list,show,new,update,edit',
        \Tp3\Tp3Businessview\Controller\PanoramasController::class => 'index,new,edit,create,update,delete',
        \Tp3\Tp3Businessview\Controller\BusinessAdressController::class => 'index,new,edit,create,update,delete',
    ],
    // non-cacheable actions
    [
        \Tp3\Tp3Businessview\Controller\Tp3BusinessViewController::class => 'createpano,create',
        \Tp3\Tp3Businessview\Controller\PanoramasController::class => 'create',
        \Tp3\Tp3Businessview\Controller\BusinessAdressController::class => 'create',
    ]
);

// wizards
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
    'mod {
			wizards.newContentElement.wizardItems.plugins {
				elements {
					tp3businessview {
                        iconIdentifier = ext-' . $_EXTKEY . '-wizard-icon
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
// Icons
if (\TYPO3\CMS\Core\Http\ApplicationType::fromRequest($GLOBALS['TYPO3_REQUEST'])->isBackend()) {
    $icons = [
        'ext-' . $_EXTKEY . '-wizard-icon' => 'user_plugin_tp3businessview.svg',
    ];
    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
    foreach ($icons as $identifier => $path) {
        $iconRegistry->registerIcon(
            $identifier,
            \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
            ['source' => 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/' . $path]
        );
    }
}
//output thru hook
if (\TYPO3\CMS\Core\Http\ApplicationType::fromRequest($GLOBALS['TYPO3_REQUEST'])->isFrontend()) {
    if (class_exists(\Tp3\Tp3Businessview\Frontend\PageRenderer\Tp3PageRenderer::class)) {
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-postProcess'][] = \Tp3\Tp3Businessview\Frontend\PageRenderer\Tp3PageRenderer::class . '->render';
    }
}
