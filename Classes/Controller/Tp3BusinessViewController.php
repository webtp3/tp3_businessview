<?php
namespace Tp3\Tp3Businessview\Controller;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2015 Thomas Ruta <support@r-p-it.de>, tp3
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/***
 *
 * This file is part of the "BusinsessView" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018 Thomas Ruta <support@r-p-it.de>, tp3
 *
 ***/
use TYPO3\CMS\Backend\Template\Components\ButtonBar;
use TYPO3\CMS\Backend\View\BackendTemplateView;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Localization\Locales;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Resource\ResourceStorage;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;

/**
 * Tp3BusinessViewController
 */
class Tp3BusinessViewController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * Backend Template Container.
     * Takes care of outer "docheader" and other stuff this module is embedded in.
     *
     * @var string
     */
    protected $defaultViewObjectName = BackendTemplateView::class;

    /**
     * BackendTemplateContainer
     *
     * @var BackendTemplateView
     */
    protected $view;

    /**
     * @var PageRenderer
     */
    protected $pageRenderer;

    /**
     * @var int
     */
    const FE_PREVIEW_TYPE = 699841589;


    /**
     * @var array
     */
    protected $MOD_MENU;

    /**
     * @var array
     */
    protected $configuration = array(
        'translations' => array(
            'availableLocales' => array(),
            'languageKeyToLocaleMapping' => array()
        ),
        'menuActions' => array(),
        'previewDomain' => null,
        'previewUrlTemplate' => '',
        'viewSettings' => array()
    );

    /**
     * @var Locales
     */
    protected $localeService;

    /**
     * @param ViewInterface $view
     *
     * @return void
     */
    protected function initializeView(ViewInterface $view)
    {
        parent::initializeView($view);

        // Early return for actions without valid view like tcaCreateAction or tcaDeleteAction
        if (!($this->view instanceof BackendTemplateView)) {
            return;
        }

        $this->registerDocheaderButtons();
      //  $this->view->render();
    }

    protected function initializeAction()
    {
        if (array_key_exists('tp3_businessview', $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'])
            && is_array($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['tp3_businessview'])
        ) {
            ArrayUtility::mergeRecursiveWithOverrule(
                $this->configuration,
                $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['tp3_businessview']
            );
        }

        parent::initializeAction();

        if (!($this->localeService instanceof Locales)) {
            $this->localeService = GeneralUtility::makeInstance(Locales::class);
        }
        if (!($this->pageRenderer instanceof PageRenderer)) {
            $this->pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        }


    }
    /**
     * action display
     * 
     * @return void
     */
    public function displayAction()
    {

    }

    /**
     * action list
     * 
     * @return void
     */
    public function listAction()
    {
        $tp3BusinessViews = $this->tp3BusinessViewRepository->findAll();
        $this->view->assign('tp3BusinessViews', $tp3BusinessViews);
    }
    /**
     * action index
     *
     * @return void
     */
    public function indexAction()
    {
        $publicResourcesPath = ExtensionManagementUtility::extRelPath('tp3_businessview') . 'Resources/Public/';

        $this->pageRenderer->addCssFile(
            $publicResourcesPath . 'Css/Backend/Tp3Backend.css'
        );
        $this->pageRenderer->addJsFooterFile(
            $publicResourcesPath . 'Css/JavaScript/Tp3App.js'
        );
        $tp3BusinessViews = [
            "apis" => ["jquery","maps"],
            "js" => ["Tp3App.js"],
        ];
        $this->view->assign('tp3BusinessViews', $tp3BusinessViews);
    }

    /**
     * action show
     * 
     * @param \Tp3\Tp3Businessview\Domain\Model\Tp3BusinessView $tp3BusinessView
     * @return void
     */
    public function showAction(\Tp3\Tp3Businessview\Domain\Model\Tp3BusinessView $tp3BusinessView)
    {
        $this->view->assign('tp3BusinessView', $tp3BusinessView);
    }
    /**
     * @return void
     */
    public function settingsAction()
    {
        $tmp = $GLOBALS['TYPO3_DB']->exec_SELECTgetSingleRow('uid', 'pages', 'deleted=0 AND hidden=0 AND is_siteroot=1');
        $pageId = (int)$tmp['uid'];

        $this->view->assign('pageId', $pageId);
    }

    public function premiumAction()
    {
    }

    public function saveSettingsAction()
    {
        $tmp = $GLOBALS['TYPO3_DB']->exec_SELECTgetSingleRow('uid', 'pages', 'deleted=0 AND hidden=0 AND is_siteroot=1');
        $pageId = (int)$tmp['uid'];

        $languageId = (int)$this->request->getArgument('language');
        $lang = $this->getLanguageService();

        $extraTableRecords = [];

        if ($this->request->hasArgument('twitterImage')) {
            $twitterImage = $this->request->getArgument('twitterImage');

            if (($this->request->hasArgument('twitterDeleteImage') && !empty($this->request->getArgument('twitterDeleteImage'))) ||
                (array_key_exists('tmp_name', $twitterImage) && !empty($twitterImage['tmp_name']))) {
                $GLOBALS['TYPO3_DB']->exec_UPDATEquery(
                    'sys_file_reference',
                    'fieldname="tx_yoastseo_settings_twitter_image" AND uid_foreign=' . $pageId,
                    ['deleted' => 1]
                );
            }
            if (array_key_exists('tmp_name', $twitterImage) && !empty($twitterImage['tmp_name'])) {
                $resourceFactory = \TYPO3\CMS\Core\Resource\ResourceFactory::getInstance();
                $storage = $resourceFactory->getDefaultStorage();

                if ($storage instanceof ResourceStorage) {
                    $newFile = $storage->addFile(
                        $twitterImage['tmp_name'],
                        $storage->getDefaultFolder(),
                        $twitterImage['name']
                    );

                    $newId = 'NEW12345';
                    $extraTableRecords['sys_file_reference'][$newId] = [
                        'table_local' => 'sys_file',
                        'uid_local' => $newFile->getUid(),
                        'tablenames' => 'pages',
                        'uid_foreign' => $pageId,
                        'fieldname' => 'tx_yoastseo_settings_twitter_image',
                        'pid' => $pageId
                    ];
                }
            }
        }

        if ($this->request->hasArgument('facebookImage')) {
            $facebookImage = $this->request->getArgument('facebookImage');
            if (($this->request->hasArgument('facebookDeleteImage') && !empty($this->request->getArgument('facebookDeleteImage'))) ||
                (array_key_exists('tmp_name', $facebookImage) && !empty($facebookImage['tmp_name']))) {
                $GLOBALS['TYPO3_DB']->exec_UPDATEquery(
                    'sys_file_reference',
                    'fieldname="tx_yoastseo_settings_facebook_image" AND uid_foreign=' . $pageId,
                    ['deleted' => 1]
                );
            }
            if (array_key_exists('tmp_name', $facebookImage) && !empty($facebookImage['tmp_name'])) {
                $resourceFactory = \TYPO3\CMS\Core\Resource\ResourceFactory::getInstance();
                $storage = $resourceFactory->getDefaultStorage();

                if ($storage instanceof ResourceStorage) {
                    $newFile = $storage->addFile(
                        $facebookImage['tmp_name'],
                        $storage->getDefaultFolder(),
                        $facebookImage['name']
                    );

                    $newId = 'NEW54321';
                    $extraTableRecords['sys_file_reference'][$newId] = [
                        'table_local' => 'sys_file',
                        'uid_local' => $newFile->getUid(),
                        'tablenames' => 'pages',
                        'uid_foreign' => $pageId,
                        'fieldname' => 'tx_yoastseo_settings_facebook_image',
                        'pid' => $pageId
                    ];
                }
            }
        }

        $tce = GeneralUtility::makeInstance(DataHandler::class);
        $tce->reverseOrder = 1;
        $tce->start($extraTableRecords, array());
        $tce->process_datamap();
        $tce->clear_cacheCmd('pages');

        $message = GeneralUtility::makeInstance(
            FlashMessage::class,
            $lang->sL('LLL:EXT:tp3_businessview/Resources/Private/Language/BackendModule.xlf:saved.description'),
            $lang->sL('LLL:EXT:tp3_businessview/Resources/Private/Language/BackendModule.xlf:saved.title'),
            FlashMessage::OK,
            true
        );

        $flashMessageService = $this->objectManager->get(\TYPO3\CMS\Core\Messaging\FlashMessageService::class);
        $messageQueue = $flashMessageService->getMessageQueueByIdentifier();
        $messageQueue->addMessage($message);

        $returnUrl = '';
        if ($this->request->hasArgument('returnUrl')) {
            $returnUrl = $this->request->getArgument('returnUrl');
        }

        $this->redirect('settings', null, null, array('id' => $pageId, 'language' => $languageId));
    }
    /**
     * Registers the Icons into the docheader
     *
     * @return void
     * @throws \InvalidArgumentException
     */
    protected function registerDocheaderButtons()
    {
        /** @var ButtonBar $buttonBar */
        $buttonBar = $this->view->getModuleTemplate()->getDocHeaderComponent()->getButtonBar();
        $currentRequest = $this->request;
        $moduleName = $currentRequest->getPluginName();
        $lang = $this->getLanguageService();

        $extensionName = $currentRequest->getControllerExtensionName();
        $modulePrefix = strtolower('tx_' . $extensionName . '_' . $moduleName);
        $shortcutName = $this->getLanguageService()->sL(
            'LLL:EXT:beuser/Resources/Private/Language/locallang.xml:backendUsers'
        );
        if ($currentRequest->getControllerName() === 'Module') {
            if ($currentRequest->getControllerActionName() === 'edit') {
                if ($currentRequest->hasArgument('returnUrl') &&
                    $currentRequest->getArgument('returnUrl')) {
                    // CLOSE button:
                    $closeButton = $buttonBar->makeLinkButton()
                        ->setHref(urldecode($currentRequest->getArgument('returnUrl')))
                        ->setClasses('t3js-editform-close')
                        ->setTitle($lang->sL('LLL:EXT:lang/locallang_core.xlf:rm.closeDoc'))
                        ->setIcon($this->view->getModuleTemplate()->getIconFactory()->getIcon(
                            'actions-document-close',
                            Icon::SIZE_SMALL
                        ));
                    $buttonBar->addButton($closeButton, ButtonBar::BUTTON_POSITION_LEFT, 1);
                }

                // SAVE button:
                $saveButton = $buttonBar->makeInputButton()
                    ->setTitle($lang->sL('LLL:EXT:lang/locallang_core.xlf:rm.saveDoc'))
                    ->setName($modulePrefix . '[submit]')
                    ->setValue('Save')
                    ->setForm('editYoastSettings')
                    ->setIcon($this->view->getModuleTemplate()->getIconFactory()->getIcon(
                        'actions-document-save',
                        Icon::SIZE_SMALL
                    ))
                    ->setShowLabelText(true);

                $buttonBar->addButton($saveButton, ButtonBar::BUTTON_POSITION_LEFT, 2);
            }
            if ($currentRequest->getControllerActionName() === 'settings') {
                // SAVE button:
                $saveButton = $buttonBar->makeInputButton()
                    ->setTitle($lang->sL('LLL:EXT:lang/locallang_core.xlf:rm.saveDoc'))
                    ->setName($modulePrefix . '[submit]')
                    ->setValue('Save')
                    ->setForm('editYoastSettings')
                    ->setIcon($this->view->getModuleTemplate()->getIconFactory()->getIcon(
                        'actions-document-save',
                        Icon::SIZE_SMALL
                    ))
                    ->setShowLabelText(true);

                $buttonBar->addButton($saveButton, ButtonBar::BUTTON_POSITION_LEFT, 2);
            }
        }
        $shortcutButton = $buttonBar->makeShortcutButton()
            ->setModuleName($moduleName)
            ->setDisplayName($shortcutName)
            ->setGetVariables(array('id' => (int)GeneralUtility::_GP('id')));
        $buttonBar->addButton($shortcutButton);
    }

    /**
     * Returns LanguageService
     *
     * @return \TYPO3\CMS\Lang\LanguageService
     */
    public function getLanguageService()
    {
        return $GLOBALS['LANG'];
    }

    /**
     * Try to resolve a supported locale based on the user settings
     * take the configured locale dependencies into account
     * so if the TYPO3 interface is tailored for a specific dialect
     * the local of a parent language might be used
     *
     * @return string|null
     */
    protected function getInterfaceLocale()
    {
        $locale = null;
        $languageChain = null;

        if ($GLOBALS['BE_USER'] instanceof BackendUserAuthentication
            && is_array($GLOBALS['BE_USER']->uc)
            && array_key_exists('lang', $GLOBALS['BE_USER']->uc)
            && !empty($GLOBALS['BE_USER']->uc['lang'])
        ) {
            $languageChain = $this->localeService->getLocaleDependencies(
                $GLOBALS['BE_USER']->uc['lang']
            );

            array_unshift($languageChain, $GLOBALS['BE_USER']->uc['lang']);
        }

        // try to find a matching locale available for this plugins UI
        // take configured locale dependencies into account
        if ($languageChain !== null
            && ($suitableLocales = array_intersect(
                $languageChain,
                $this->configuration['translations']['availableLocales']
            )) !== false
            && count($suitableLocales) > 0
        ) {
            $locale = array_shift($suitableLocales);
        }

        // if a locale couldn't be resolved try if an entry of the
        // language dependency chain matches legacy mapping
        if ($locale === null && $languageChain !== null
            && ($suitableLanguageKeys = array_intersect(
                $languageChain,
                array_flip(
                    $this->configuration['translations']['languageKeyToLocaleMapping']
                )
            )) !== false
            && count($suitableLanguageKeys) > 0
        ) {
            $locale =
                $this->configuration['translations']['languageKeyToLocaleMapping'][array_shift($suitableLanguageKeys)];
        }

        return $locale;
    }

    /**
     * Get a CSRF token
     *
     * @param bool $tokenOnly Set it to TRUE to get only the token, otherwise including the &moduleToken= as prefix
     * @return string
     */
    protected function getToken($tokenOnly = false)
    {
        $token = FormProtectionFactory::get()->generateToken('moduleCall', 'tools_Tp3BusinessviewTp3businessview');
        if ($tokenOnly) {
            return $token;
        } else {
            return '&moduleToken=' . $token;
        }
    }
    /**
     * Returns the current BE user.
     *
     * @return \TYPO3\CMS\Core\Authentication\BackendUserAuthentication
     */
    public function getBackendUser()
    {
        return $GLOBALS['BE_USER'];
    }

}
