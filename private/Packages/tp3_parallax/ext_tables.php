<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('tp3_parallax', 'Configuration/TypoScript', 'tp3 Parallax');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_tp3parallax_domain_model_section', 'EXT:tp3_parallax/Resources/Private/Language/locallang_csh_tx_tp3parallax_domain_model_section.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_tp3parallax_domain_model_section');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_tp3parallax_domain_model_collections', 'EXT:tp3_parallax/Resources/Private/Language/locallang_csh_tx_tp3parallax_domain_model_collections.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_tp3parallax_domain_model_collections');

    }
);
