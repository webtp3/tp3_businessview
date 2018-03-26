<?php
defined('TYPO3_MODE') || die();
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['tp3facebook_fbplugin']='layout,select_key,pages,recursive';

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['tp3facebook_fbplugin']='pi_flexform';

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'Tp3.Tp3BusinessView',
    'Tp3BusinessView',
    'Tp3 BusinessView'
);

/* Add the flexforms to the TCA */
//\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('tp3businessview_tp3businessview', 'FILE:EXT:tp3_facebook/Configuration/FlexForms/flexform.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tp3businessview_tp3businessview', 'EXT:tp3_businessview/Resources/Private/Language/locallang_tp3businessview.xlf');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_tp3businessview_domain_model_businessapp', 'EXT:tp3_businessview/Resources/Private/Language/locallang_csh_tx_tp3businessview_domain_model_businessapp.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_tp3businessview_domain_model_panoramas', 'EXT:tp3_businessview/Resources/Private/Language/locallang_csh_tx_tp3businessview_domain_model_panoramas.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_tp3businessview_domain_model_tp3businessview', 'EXT:tp3_businessview/Resources/Private/Language/locallang_csh_tx_tp3businessview_domain_model_tp3businessview.xlf');


