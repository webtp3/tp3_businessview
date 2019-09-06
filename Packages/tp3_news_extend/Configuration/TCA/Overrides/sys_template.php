<?php

/*
 * This file is part of the web-tp3/tp3_news_extend.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

// *** pages
// *** static file
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('tp3_news_extend', 'Configuration/TypoScript', 'Tp3NewsExtend');
