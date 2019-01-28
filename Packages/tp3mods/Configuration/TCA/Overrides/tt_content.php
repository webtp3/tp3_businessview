<?php

/*
 * This file is part of the web-tp3/tp3mods.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3_MODE') || die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'Tp3.Tp3mods',
    'Tp3micro',
    'tp3 microdata'
);

/*
 * add contentelement to "Type" dropdown
 */
/*
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(
    array(
        'LLL:EXT:tp3mods/Resources/Private/Language/locallang_tp3backend.xlf:tp3mods_downloads.wizard.title',
        'tp3mods_downloads',
        'EXT:tp3mods/Resources/Public/Icons/tx_tp3mods_domain_model_tp3mods.gif'
    ),
    'CType',
    'tp3mods_downloads'
);*/
