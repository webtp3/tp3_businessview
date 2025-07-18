<?php

/*
 * This file is part of the package web-tp3/tp3-businessview.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3_MODE') || die();
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['tp3businessview_tp3businessview']='layout,select_key,pages,recursive';

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['tp3businessview_tp3businessview']='pi_flexform';

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'tp3_businessView',
    'Tp3BusinessView',
    'Tp3 BusinessView',
    'EXT:tp3_businessview/Resources/Public/Icons/user_plugin_tp3businessview.svg'
);

// Add the flexforms to the TCA
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('tp3businessview_tp3businessview', 'FILE:EXT:tp3_businessview/Configuration/FlexForms/flexform.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tp3businessview_tp3businessview', 'EXT:tp3_businessview/Resources/Private/Language/locallang_tp3businessview.xlf');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_tp3businessview_domain_model_panoramas', 'EXT:tp3_businessview/Resources/Private/Language/locallang_csh_tx_tp3businessview_domain_model_panoramas.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_tp3businessview_domain_model_tp3businessview', 'EXT:tp3_businessview/Resources/Private/Language/locallang_csh_tx_tp3businessview_domain_model_tp3businessview.xlf');
