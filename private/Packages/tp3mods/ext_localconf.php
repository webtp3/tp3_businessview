<?php
defined('TYPO3_MODE') || die('Access denied.');

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-postProcess'][] = \Tp3\Tp3mods\Frontend\PageRenderer\Tp3PageRenderer::class . '->render';

$_EXTKEY = "tp3mods";
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
/***************
 * Add default RTE configuration for tp3mods
 */
if (!$tp3modsConfig['disableConfigRTE'] == 0 || $tp3modsConfig['disableConfigRTE'] == false) {
    $GLOBALS['TYPO3_CONF_VARS']['RTE']['Presets']['bootstrap'] = 'EXT:tp3mods/Configuration/RTE/Default.yaml';
}


\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Tp3.Tp3mods',
    'Tp3micro',
    [
        'Tp3Mods' => 'list, show',
        'Tp3Adress' => 'list, show'
    ],
    // non-cacheable actions
    [
        'Tp3Mods' => '',
        'Tp3Adress' => ''
    ]
);


// wizards
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
    'mod {
            wizards.newContentElement.wizardItems.plugins {
                elements {
                    tp3micro {
                        iconIdentifier = tp3mods-plugin-tp3micro
                        title = LLL:EXT:tp3mods/Resources/Private/Language/locallang_db.xlf:tx_tp3mods_tp3micro.name
                        description = LLL:EXT:tp3mods/Resources/Private/Language/locallang_db.xlf:tx_tp3mods_tp3micro.description
                        tt_content_defValues {
                            CType = list
                            list_type = tp3mods_tp3micro
                        }
                    }
                }
                show = *
            }
       }'
);
$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);

/***************
 * Register Icons
 */
$iconRegistry->registerIcon(
    'content-tp3mods-downloads',
    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
    ['source' => 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/user_mod_tp3backend.svg']
);
$iconRegistry->registerIcon(
    'plugin-tp3mods-tp3micro',
    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
    ['source' => 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/user_plugin_tp3micro.svg']
);



if (!$tp3modsConfig['cookieconsent'] == 0 ){
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-postProcess'][] = \Tp3\Tp3mods\Hooks\GoogleAnalyticsFehook::class .'->intPages';
    $GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['consent'] = \Tp3\Tp3mods\Hooks\GoogleAnalyticsFehook::class .'::setTracking';//Tp3\Tp3ratings\Controller\RatingsdataController::class . '->RatingAction';//
}

/***************
 * Backend Styling for CMS8
 * Please see \BK2K\BootstrapPackage\Service\BrandingService for CMS9
 */
if (TYPO3_MODE == 'BE' && !class_exists('TYPO3\CMS\Core\Configuration\ExtensionConfiguration')) {


    if (!$tp3modsConfig['disablePageTsBackendLogo'] == 0 || $tp3modsConfig['disablePageTsBackendLogo'] == false) {
        /**
         * Configure Backend Extension
         */

        // Login Logo
        if (!is_array($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['backend'])) {
            $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['backend'] = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['backend']);
        }

        if (isset($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['backend']['loginLogo'])
            || empty(trim($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['backend']['loginLogo']))
        ) {
            $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['backend']['loginLogo'] = 'EXT:tp3mods/Resources/Public/Images/Backend/login-logo.svg';
        }
        // Login Background
        if (isset($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['backend']['loginBackgroundImage'])
            || empty(trim($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['backend']['loginBackgroundImage']))
        ) {
            $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['backend']['loginBackgroundImage'] = 'EXT:tp3mods/Resources/Public/Images/Backend/login-background-image.jpg';
        }
        // Backend Logo
        if (isset($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['backend']['backendLogo'])
            || empty(trim($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['backend']['backendLogo']))
        ) {
            $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['backend']['backendLogo'] = 'EXT:tp3mods/Resources/Public/Images/Backend/backend-logo.svg';
        }
        if (is_array($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['backend'])) {
            $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['backend'] = serialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['backend']);
        }
    }
}
