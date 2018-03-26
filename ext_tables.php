<?php
defined('TYPO3_MODE') || die('Access denied.');




        if (TYPO3_MODE === 'BE') {

            \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
                'Tp3.Tp3Businessview',
                'tools', // Make module a submodule of 'tools'
                'tp3businessview', // Submodule key
                '', // Position
                [
                    'Tp3BusinessView' => 'display',
                ],
                [
                    'access' => 'user,group',
					'icon'   => 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/user_mod_tp3businessview.svg',
                    'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_tp3businessview.xlf',
                ]
            );

        }



        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_tp3businessview_domain_model_tp3businessview');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_tp3businessview_domain_model_businessapp');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_tp3businessview_domain_model_panoramas');

