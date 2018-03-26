<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}


/***************
 * Make the extension configuration accessible
*/
if (!is_array($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY])) {
	$GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY] = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY]);
}

/***************
 * PageTs
*/

// Add tp3 Content Elements to newContentElement Wizard
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:' . $_EXTKEY . '/Configuration/PageTS/ContentElement.txt">');

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Tp3.' . $_EXTKEY,
	'Tp3businessview',
	array(
		'Tp3BusinessView' => 'display',
		
	),
	// non-cacheable actions
	array(
		'Tp3BusinessView' => '',
		
	)
);
