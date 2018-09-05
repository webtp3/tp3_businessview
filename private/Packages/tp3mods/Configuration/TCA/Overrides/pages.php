<?php
defined('TYPO3_MODE') or die();

// RTE Config (Old style)
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
    'tp3mods',
    'Configuration/PageTS/setup.txt',
    'EXT:tp3mods :: mods for tp3 special Pages');

// Layouts as Newsletter ...

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
    'tp3mods',
    'Configuration/PageTS/Mod/WebLayout/BackendLayouts.txt',
    'EXT:tp3mods :: Backendlayouts for tp3');