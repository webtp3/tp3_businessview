<?php

/*
 * This file is part of the web-tp3/tp3mods.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function () {
        /***************
         * Make the extension configuration accessible
         */
        if (class_exists('TYPO3\CMS\Core\Configuration\ExtensionConfiguration')) {
            $extensionConfiguration = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
                \TYPO3\CMS\Core\Configuration\ExtensionConfiguration::class
            );
            $tp3modsConfig = $extensionConfiguration->get('tp3mods');
        } else {
            // Fallback for CMS8
            // @extensionScannerIgnoreLine
            $tp3modsConfig = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['tp3mods'];
            if (!is_array($tp3modsConfig)) {
                $tp3modsConfig = unserialize($tp3modsConfig);
            }
        }
        if (!is_array($tp3modsConfig)) {
            $tp3modsConfig = unserialize($tp3modsConfig);
        }

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'Tp3.Tp3mods',
            'Tp3micro',
            'tp3 microdata'
        );

        if (TYPO3_MODE == 'BE' && !class_exists('TYPO3\CMS\Core\Configuration\ExtensionConfiguration')) {
            if ($tp3modsConfig['backendModule']) {
                \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
                    'Tp3.Tp3mods',
                    'tools', // Make module a submodule of 'tools'
                    'tp3backend', // Submodule key
                    '', // Position
                    [
                        'Tp3Mods' => 'list, show',
                        'Tp3Adress' => 'list, show',
                    ],
                    [
                        'access' => 'user,group',
                        'icon' => 'EXT:tp3mods/Resources/Public/Icons/user_mod_tp3backend.svg',
                        'labels' => 'LLL:EXT:tp3mods/Resources/Private/Language/locallang_tp3backend.xlf',
                    ]
                );
            }
        }

        // \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('tp3mods', 'Configuration/TypoScript', 'tp3 Mods');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_tp3mods_domain_model_tp3mods', 'EXT:tp3mods/Resources/Private/Language/locallang_csh_tx_tp3mods_domain_model_tp3mods.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_tp3mods_domain_model_tp3mods');
    }
);
//# EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder
