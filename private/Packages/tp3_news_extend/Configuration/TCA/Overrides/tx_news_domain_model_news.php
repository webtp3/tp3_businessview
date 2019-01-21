<?php
if(!defined ('TYPO3_MODE')) die ('Access denied.');

// *** pages
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
	'tx_news_domain_model_news',
	array(
		'html5video' => array(
            'label' => 'LLL:EXT:tp3_news_extend/Resources/Private/Language/locallang_db.xlf:tx_news_domain_model_news.html5video',
			'config' => array(
				'type' => 'select',
				'items' => array (
                    array('LLL:EXT:tp3_news_extend/Resources/Private/Language/locallang_db.xlf:misc.pleaseChoose', ''),
				),
				'foreign_table' => 'tx_html5videoplayer_domain_model_video',
				'foreign_table_where' => "AND (tx_html5videoplayer_domain_model_video.hidden=0) AND (tx_html5videoplayer_domain_model_video.deleted=0)",
				'minitems' => 0,
				'maxitems' => 1,
                'renderType' => 'selectSingle',

/*
				'appearance' => array(
					'collapse' => 0,
					'newRecordLinkPosition' => 'bottom',
				)
*/
			)
		)
	)
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes("tx_news_domain_model_news","html5video");