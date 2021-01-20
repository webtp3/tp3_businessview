<?php

/*
 * This file is part of the web-tp3/tp3businessview.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3_MODE') || die('Access denied.');

$extKey = 'tp3_businessview';

        if (TYPO3_MODE === 'BE') {
            if (!$tp3modsConfig['disableBeModuleDesigner']) {
                \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
                    'Tp3.Tp3Businessview',
                    'web', // Make module a submodule of 'tools'
                    'Module', // Submodule key
                    '', // Position
                    [
                        'Module' => 'index,new,edit,create,update,delete',
                        'Tp3BusinessView' => 'index,new,edit,create,update,delete',
                        'Panoramas' => 'index,new,edit,create,update,delete',
                        'BusinessAdress' => 'index,new,edit,create,update,delete',
                    ],
                    [
                        'access' => 'user,group',
                        'icon' => 'EXT:' . $extKey . '/Resources/Public/Icons/user_mod_tp3businessview.svg',
                        'labels' => 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_tp3businessviewdesigner.xlf',
                    ]
                );
            }
            if (!$tp3modsConfig['disableBeModuleBusinessAdress']) {
                \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
                    'Tp3.Tp3Businessview',
                    'web', // Make module a submodule of 'tools'
                    'BusinessAdress', // Submodule key
                    '', // Position
                    [

                        'BusinessAdress' => 'index,new,edit,create,update,delete',
                    ],
                    [
                        'access' => 'user,group',
                        'icon' => 'EXT:' . $extKey . '/Resources/Public/Icons/user_mod_tp3businessview.svg',
                        'labels' => 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_csh_tt_address.xlf',
                    ]
                );
            }
            if (!$tp3modsConfig['disableBeModuleBusinessView']) {
                \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
                    'Tp3.Tp3Businessview',
                    'web', // Make module a submodule of 'tools'
                    'Tp3Businessview', // Submodule key
                    '', // Position
                    [

                        'Tp3BusinessView' => 'index,new,edit,create,update,delete',
                    ],
                    [
                        'access' => 'user,group',
                        'icon' => 'EXT:' . $extKey . '/Resources/Public/Icons/user_mod_tp3businessview.svg',
                        'labels' => 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_tp3businessview.xlf',
                    ]
                );
            }
        }

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_tp3businessview_domain_model_tp3businessview');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_tp3businessview_domain_model_tp3businessview', 'EXT:tx_tp3businessview_domain_model_tp3businessview/Resources/Private/Language/locallang_csh_tx_tp3businessview_domain_model_tp3businessview.xlf');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_tp3businessview_domain_model_panoramas');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_tp3businessview_domain_model_panoramas', 'EXT:tx_tp3businessview_domain_model_panoramas/Resources/Private/Language/locallang_csh_tx_tp3businessview_domain_model_panoramas.xlf');
