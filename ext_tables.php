<?php
defined('TYPO3_MODE') || die('Access denied.');




        if (TYPO3_MODE === 'BE') {
            $extKey = "tp3_businessview";
            \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
                'Tp3.Tp3Businessview',
                'web', // Make module a submodule of 'tools'
                'Module', // Submodule key
                '', // Position
                [
                    'Module' => 'index,new,edit,create,update,delete',
                    'Tp3BusinessView' => 'index,new,edit,create,update,delete',
                    'Panoramas' => 'index,new,edit,create,update,delete',

                ],
                [
                    'access' => 'user,group',
					'icon'   => 'EXT:' . $extKey . '/Resources/Public/Icons/user_mod_tp3businessview.svg',
                    'labels' => 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_tp3businessview.xlf',
                ]
            );

        }

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_tp3businessview_domain_model_tp3businessview');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_tp3businessview_domain_model_panoramas');

