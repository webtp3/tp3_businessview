<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function() {



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

        $iconRegistry->registerIcon(
            'tp3mods-plugin-tp3micro',
            \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
            ['source' => 'EXT:tp3mods/Resources/Public/Icons/user_plugin_tp3micro.svg']
        );


    }
);
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder
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

    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-postProcess'][] = \Tp3\Tp3mods\Frontend\PageRenderer\Tp3PageRenderer::class . '->render';
