<?php

/*
 * This file is part of the package web-tp3/tp3-businessview.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3') or die;
// // Add an entry in the static template list found in sys_templates for static TS

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('tp3_businessview', 'Configuration/TypoScript', 'tp3 Businessview');
