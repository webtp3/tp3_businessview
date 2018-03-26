<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function($extKey)
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'Tp3.Tp3Businessview',
            'Tp3businessview',
            'BusinessView'
        );

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
					'icon'   => 'EXT:' . $extKey . '/Resources/Public/Icons/user_mod_tp3businessview.svg',
                    'labels' => 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_tp3businessview.xlf',
                ]
            );

        }

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($extKey, 'Configuration/TypoScript', 'BusinsessView');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_tp3businessview_domain_model_tp3businessview', 'EXT:tp3_businessview/Resources/Private/Language/locallang_csh_tx_tp3businessview_domain_model_tp3businessview.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_tp3businessview_domain_model_tp3businessview');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_tp3businessview_domain_model_businessapp', 'EXT:tp3_businessview/Resources/Private/Language/locallang_csh_tx_tp3businessview_domain_model_businessapp.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_tp3businessview_domain_model_businessapp');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_tp3businessview_domain_model_panoramas', 'EXT:tp3_businessview/Resources/Private/Language/locallang_csh_tx_tp3businessview_domain_model_panoramas.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_tp3businessview_domain_model_panoramas');

    },
    $_EXTKEY
);
