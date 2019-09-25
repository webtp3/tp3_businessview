<?php

/*
 * This file is part of the web-tp3/tp3_jobs.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3_MODE') || die('Access denied.');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_tp3jobs_domain_model_joboffer');
//\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_tp3businessview_domain_model_tp3businessview', 'EXT:tx_tp3businessview_domain_model_tp3businessview/Resources/Private/Language/locallang_csh_tx_tp3businessview_domain_model_tp3businessview.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_tp3jobs_domain_model_joboffer', 'EXT:tp3_jobs/Resources/Private/Language/locallang_csh_tx_tp3jobs_domain_model_joboffer.xlf');
