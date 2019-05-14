<?php

/*
 * This file is part of the web-tp3/tp3mods.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3_MODE') || die('Access denied.');

$_EXTKEY = 'tp3mods';
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

// Override local page not found handling configuration
$GLOBALS['TYPO3_CONF_VARS']['FE']['pageNotFound_handling'] = \Tp3\Tp3mods\Utility\PageNotFoundHandling::class . '->pageNotFound';

// Define global hooks array
if (!isset($tp3modsConfig['errorHandlers'])) {
    $tp3modsConfig['errorHandlers'] = [];
}

if (TYPO3_MODE == 'BE') {
    /***************
     * Add default RTE configuration for tp3mods
     */
    if (!$tp3modsConfig['disableConfigRTE'] == 0 || $tp3modsConfig['disableConfigRTE'] == false) {
        $GLOBALS['TYPO3_CONF_VARS']['RTE']['Presets']['bootstrap'] = 'EXT:tp3mods/Configuration/RTE/Default.yaml';
    }
    if (!$tp3modsConfig['disablePageTs'] == 0 || $tp3modsConfig['disablePageTs'] == false) {
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:' . $_EXTKEY . '/Configuration/PageTS/Page/TCEFORM.tsconfig">');
        // \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:tp3mods/Configuration/TypoScript/PageTS/setup.txt">');
    }

    /***************
     * Register Icons
     */
    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
    $iconRegistry->registerIcon(
        'tp3mods-tp3mods-downloads',
        \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        ['source' => 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/user_mod_tp3backend.svg']
    );
    $iconRegistry->registerIcon(
        'tp3mods-plugin-tp3micro',
        \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        ['source' => 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/user_plugin_tp3micro.svg']
    );

    $icons = [
        'accordion',
        'accordion-item',
        'card-group',
        'card-group-item',
        'carousel',
        'carousel-item',
        'carousel-item-backgroundimage',
        'carousel-item-calltoaction',
        'carousel-item-header',
        'carousel-item-html',
        'carousel-item-image',
        'carousel-item-textandimage',
        'beside-text-img-centered-left',
        'beside-text-img-centered-right',
        'csv',
        'externalmedia',
        'icon-group',
        'icon-group-item',
        'listgroup',
        'menu-card',
        'social-links',
        'tab',
        'tab-item',
        'texticon',
        'timeline',
        'timeline-item'
    ];
    foreach ($icons as $icon) {
        $iconRegistry->registerIcon(
            'content-bootstrappackage-' . $icon,
            \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
            ['source' => 'EXT:tp3mods/Resources/Public/Icons/ContentElements/' . $icon . '.svg']
        );
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
} else {

    /*
     * webapp
     *
     */
    $GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['webapp'] = \Tp3\Tp3mods\Hooks\GoogleWebApp::class . '::getManifest';

    /*
    * Rich snippets hook in postrenderer
    */
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-postProcess'][] = \Tp3\Tp3mods\Frontend\PageRenderer\Tp3RichSnippetsRenderer::class . '->render';

    //call only on FE
    /*
    * dsvgo hook
    */
    if (!$tp3modsConfig['cookieconsent'] == 0) {
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-postProcess'][] = \Tp3\Tp3mods\Hooks\GoogleAnalyticsFehook::class . '->intPages';
        $GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['consent'] = \Tp3\Tp3mods\Hooks\GoogleAnalyticsFehook::class . '::setTracking';//Tp3\Tp3ratings\Controller\RatingsdataController::class . '->RatingAction';//
    }
}
//// Cache configuration
////if (!is_array($TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations'][\R3H6\Error404page\Domain\Cache\ErrorHandlerCache::IDENTIFIER])) {
////    $TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations'][\R3H6\Error404page\Domain\Cache\ErrorHandlerCache::IDENTIFIER] = array();
////}
//
//// Debug log
//if (\Tp3\Tp3mods\Configuration\ExtensionConfiguration::is('debugMode')) {
//    $GLOBALS['TYPO3_CONF_VARS']['LOG']['R3H6']['Error404page']['writerConfiguration'] = array(
//        \TYPO3\CMS\Core\Log\LogLevel::DEBUG => array(
//            'TYPO3\\CMS\\Core\\Log\\Writer\\FileWriter' => array(
//                'logFile' => 'typo3temp/logs/debug.log',
//            ),
//        ),
//    );
//}

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

$GLOBALS['TYPO3_CONF_VARS']['FE']['addRootLineFields'] .= ($GLOBALS['TYPO3_CONF_VARS']['FE']['addRootLineFields'] ? ',' : '') . 'subtitle,author,keywords,description,title,abstract,media,tsconfig,tp3microdata';
//$GLOBALS['TYPO3_CONF_VARS']['FE']['pageOverlayFields'] .= ($GLOBALS['TYPO3_CONF_VARS']['FE']['pageOverlayFields'] ? ',' : '' ) . 'media';
/*  \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
      'mod {
          wizards.newContentElement.wizardItems.common{
              elements {
                  tp3mods_downloads {
                      icon = ' . \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/user_plugin_tp3micro.svg
                      title = LLL:EXT:tp3mods/Resources/Private/Language/locallang_db.xlf:tp3mods_downloads
                      description = LLL:EXT:tp3mods/Resources/Private/Language/locallang_db.xlf:tp3mods_downloads.description
                      tt_content_defValues {
                          CType = tp3mods_downloads

                      }
                  }
              }
              show = *
          }
     }'
  );*/
