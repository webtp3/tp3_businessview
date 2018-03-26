<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'Tp3businessview',
	'BusinessView'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'BusinsessView');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_tp3businessview_domain_model_tp3businessview', 'EXT:tp3_businessview/Resources/Private/Language/locallang_csh_tx_tp3businessview_domain_model_tp3businessview.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_tp3businessview_domain_model_tp3businessview');
$GLOBALS['TCA']['tx_tp3businessview_domain_model_tp3businessview'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:tp3_businessview/Resources/Private/Language/locallang_db.xlf:tx_tp3businessview_domain_model_tp3businessview',
		'label' => 'created_by',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,

		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'created_by,name,external_links,gallery,intro,pano_animation,social_gallery,pano_options,contact,app,panoramas,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Tp3BusinessView.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_tp3businessview_domain_model_tp3businessview.gif'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_tp3businessview_domain_model_businessapp', 'EXT:tp3_businessview/Resources/Private/Language/locallang_csh_tx_tp3businessview_domain_model_businessapp.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_tp3businessview_domain_model_businessapp');
$GLOBALS['TCA']['tx_tp3businessview_domain_model_businessapp'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:tp3_businessview/Resources/Private/Language/locallang_db.xlf:tx_tp3businessview_domain_model_businessapp',
		'label' => 'businessview_id',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,

		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'businessview_id,google_maps_java_script_api_key,businessview_canvas_selector,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/BusinessApp.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_tp3businessview_domain_model_businessapp.gif'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_tp3businessview_domain_model_panoramas', 'EXT:tp3_businessview/Resources/Private/Language/locallang_csh_tx_tp3businessview_domain_model_panoramas.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_tp3businessview_domain_model_panoramas');
$GLOBALS['TCA']['tx_tp3businessview_domain_model_panoramas'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:tp3_businessview/Resources/Private/Language/locallang_db.xlf:tx_tp3businessview_domain_model_panoramas',
		'label' => 'pano_id',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,

		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'pano_id,heading,pitch,zoom,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Panoramas.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_tp3businessview_domain_model_panoramas.gif'
	),
);

if (!isset($GLOBALS['TCA']['tt_address']['ctrl']['type'])) {
	if (file_exists($GLOBALS['TCA']['tt_address']['ctrl']['dynamicConfigFile'])) {
		require_once($GLOBALS['TCA']['tt_address']['ctrl']['dynamicConfigFile']);
	}
	// no type field defined, so we define it here. This will only happen the first time the extension is installed!!
	$GLOBALS['TCA']['tt_address']['ctrl']['type'] = 'tx_extbase_type';
	$tempColumns = array();
	$tempColumns[$GLOBALS['TCA']['tt_address']['ctrl']['type']] = array(
		'exclude' => 1,
		'label'   => 'LLL:EXT:tp3_businessview/Resources/Private/Language/locallang_db.xlf:tx_tp3businessview.tx_extbase_type',
		'config' => array(
			'type' => 'select',
			'items' => array(),
			'size' => 1,
			'maxitems' => 1,
		)
	);
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_address', $tempColumns, 1);
}

$GLOBALS['TCA']['tt_address']['types']['Tx_Tp3Businessview_BusinessAdress']['showitem'] = $TCA['tt_address']['types']['1']['showitem'];
$GLOBALS['TCA']['tt_address']['types']['Tx_Tp3Businessview_BusinessAdress']['showitem'] .= ',--div--;LLL:EXT:tp3_businessview/Resources/Private/Language/locallang_db.xlf:tx_tp3businessview_domain_model_businessadress,';
$GLOBALS['TCA']['tt_address']['types']['Tx_Tp3Businessview_BusinessAdress']['showitem'] .= '';

$GLOBALS['TCA']['tt_address']['columns'][$TCA['tt_address']['ctrl']['type']]['config']['items'][] = array('LLL:EXT:tp3_businessview/Resources/Private/Language/locallang_db.xlf:tt_address.tx_extbase_type.Tx_Tp3Businessview_BusinessAdress','Tx_Tp3Businessview_BusinessAdress');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tt_address', $GLOBALS['TCA']['tt_address']['ctrl']['type'],'','after:' . $TCA['tt_address']['ctrl']['label']);
