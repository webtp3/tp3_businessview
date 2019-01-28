<?php
defined('TYPO3_MODE') || die('Access denied.');


$_EXTKEY = "tp3_parallax";
/***************
 * Make the extension configuration accessible
 */
if (class_exists('TYPO3\CMS\Core\Configuration\ExtensionConfiguration')) {
    $extensionConfiguration = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
        \TYPO3\CMS\Core\Configuration\ExtensionConfiguration::class
    );
    $tp3modsConfig = $extensionConfiguration->get($_EXTKEY);
} else {
    // Fallback for CMS8
    // @extensionScannerIgnoreLine
    $tp3modsConfig = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];
    if (!is_array($tp3modsConfig)) {
        $tp3modsConfig = unserialize($tp3modsConfig);
    }
}
if (!is_array($tp3modsConfig)) {
    $tp3modsConfig = unserialize($tp3modsConfig);
}

/*
     * parallax in postrenderer
     */
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-postProcess'][] = \Tp3\Tp3mods\Frontend\PageRenderer\Tp3PageRenderer::class . '->render';

