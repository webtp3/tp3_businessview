<?php
if (!defined('TYPO3_MODE')) die ('Access denied.');

// *** pages
// *** static file
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('tp3_news_extend', 'Configuration/TypoScript', 'Tp3NewsExtend');