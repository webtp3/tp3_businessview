<?php
defined('TYPO3_MODE') || die('Access denied.');

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

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Tp3.Tp3mods',
        'Tp3micro',
        [
            'Tp3Mods' => 'list, show, edit, update'
        ],
        // non-cacheable actions
        [
            'Tp3Mods' => 'update'
        ]
    );
        // Register for hook to show preview of tt_content element of CType="tp3mods_downloads" in page module
         //      $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['tt_content_drawItem']['tp3mods_downloads'] =            \Tp3\Tp3mods\Hooks\PageLayoutView\Downloads::class;

    //    $GLOBALS["TYPO3_CONF_VARS"]['EXTCONF']['realurl']['_DEFAULT'] = $TYPO3_CONF_VARS['EXTCONF']['realurl']['_DEFAULT'];
     //   $GLOBALS["TYPO3_CONF_VARS"]['EXTCONF']['realurl']['_DEFAULT']['pagePath']['rootpage_id'] = 0;
     //   $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['checkAlternativeIdMethods-PostProc']['realurl'] = 'Tp3\\Tp3mods\\Exception\\Error404->pageNotFound';


        if (!$tp3modsConfig['cookieconsent'] == 0 || $tp3modsConfig['cookieconsent'] == false){
            $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-postProcess'][] = \Tp3\Tp3mods\Hooks\GoogleAnalyticsFehook::class .'->intPages';
            $GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['consent'] = \Tp3\Tp3mods\Hooks\GoogleAnalyticsFehook::class .'::setTracking';//Tp3\Tp3ratings\Controller\RatingsdataController::class . '->RatingAction';//
        }





        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
            'mod {
                wizards.newContentElement.wizardItems.plugins{
                    elements {
                        tp3micro {
                            iconIdentifier = ext-tp3mods-tp3micro
                            title = LLL:EXT:tp3mods/Resources/Private/Language/locallang_db.xlf:tx_tp3mods_domain_model_tp3micro
                            description = LLL:EXT:tp3mods/Resources/Private/Language/locallang_db.xlf:tx_tp3mods_domain_model_tp3micro.description
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
    /***************
     * Add default RTE configuration for tp3mods
     */
    if (!$tp3modsConfig['disableConfigRTE'] == 0 || $tp3modsConfig['disableConfigRTE'] == false) {
        $GLOBALS['TYPO3_CONF_VARS']['RTE']['Presets']['bootstrap'] = 'EXT:tp3mods/Configuration/RTE/Default.yaml';
    }
    if (!$tp3modsConfig['disablePageTs'] == 0 || $tp3modsConfig['disablePageTs'] == false) {
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:tp3mods/Configuration/TypoScript/PageTS/setup.txt">');
    }


    if (TYPO3_MODE == 'BE') {

        /***************
         * Register Icons
         */
        $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
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

        /*\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
            'tp3mods',
            'Configuration/TypoScript/PageTS',
            'tp3mods TS'
        );*/

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

