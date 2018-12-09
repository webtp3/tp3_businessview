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
use Tp3\Tp3Businessview\Domain\Model\BusinessAdress;
use Tp3\Tp3Businessview\Domain\Model\Panoramas;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Localization\Locales;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Tp3\Tp3Businessview\Domain\Repository\Tp3BusinessViewRepository;
use Tp3\Tp3Businessview\Domain\Repository\PanoramasRepository;
use Tp3\Tp3Businessview\Domain\Repository\BusinessAdressRepository;
use TYPO3\CMS\Core\DataHandling\DataHandler as DataHandlerCore;


/**
 * Tp3BusinessViewController
 */
class Tp3BusinessViewController extends ActionController
{

    /**

     */
    protected $persistenceManager = null;


    /**
     * @var PageRenderer
     */
    protected $pageRenderer;


    /* @var $dataMapper \TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper */
    protected $dataMapper;
    /**
     *
     */
    public $cObj = null;
    /**
     *
     */
    public  $panoramas = null;
    /**
     *

     */
    public  $businessadress = null;

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
     *
     * @var \Tp3\Tp3Businessview\Domain\Repository\PanoramasRepository;
     */
    public  $panoramasRepository = null;

    /**
     *
     * @var \Tp3\Tp3Businessview\Domain\Repository\Tp3BusinessViewRepository;
     */
    public  $tp3BusinessViewRepository = null;

    /**
     *
     * @var \Tp3\Tp3Businessview\Domain\Repository\BusinessAdressRepository;
     */
    public  $businessAdressRepository = null;
    /**
     * @var Locales
     */
    protected $localeService;


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
        //$this->cObj=  $this->configurationManager->getContentObject();

        parent::initializeAction();

        if (!($this->localeService instanceof Locales)) {
            $this->localeService = GeneralUtility::makeInstance(Locales::class);
        }
        if (!($this->pageRenderer instanceof PageRenderer)) {
            $this->pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        }

        if (!($this->dataMapper instanceof DataMapper)) {
            $this->dataMapper = GeneralUtility::makeInstance(DataMapper::class);
        }
        if ($this->cObj === null) {
            $this->cObj = $this->configurationManager->getContentObject();
        }
        if ($this->conf === null) {
            $this->conf = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);

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
       /* $tp3BusinessViews = $this->tp3BusinessViewRepository->findAll();
        $this->view->assign('tp3BusinessViews', $tp3BusinessViews);*/
       //enable page injection instead of plugin
        $Plugins = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\Tp3\Tp3Businessview\Plugin\BusinessViewPlugin::class)->main($this->cObj,$this->conf);

        $GLOBALS['TSFE']->page['tx_tp3businessview_onpage'] = true;
        $GLOBALS['TSFE']->page['tx_tp3businessview_panorama'] = $Plugins["panoramas"];
        $GLOBALS['TSFE']->page['tx_tp3businessview_injetionpoint'] = $Plugins["selector"];

    }
    /**
     * action index
     *
     * @return void
     */
    public function indexAction()
    {
        $publicResourcesPath = ExtensionManagementUtility::extPath('tp3_businessview') . 'Resources/Public/';

        $this->pageRenderer->addCssFile(
            $publicResourcesPath . 'Css/Backend/Tp3Backend.css'
        );
        $this->pageRenderer->addJsInlineCode("gapikey",'window.apikey = "'.$this->settings["googleMapsJavaScriptApiKey"].'";');

        $panoramas = [];
        $businessAdresses = [];

        if ($this->panoramasRepository === null) {
            $this->panoramasRepository = $this->objectManager->get(PanoramasRepository::class);
        }
        if ($this->businessAdressRepository === null) {
            $this->businessAdressRepository = $this->objectManager->get(BusinessAdressRepository::class);
        }
        $panoramas = $this->panoramasRepository->findAll();
        $businessAdresses = $this->businessAdressRepository->findAll();


        $this->view->assign('panoramas', $panoramas);
        $this->view->assign('addresses', $businessAdresses);

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
     * action new
     *
     * @return void
     */
    public function newAction()
    {
     //   $this->redirect('index');
    }



    /**
     * action updateold
     *
     * @param \Tp3\Tp3Businessview\Domain\Model\Tp3BusinessView $businessview
     * @return void
     */
    public function updateAction(\Tp3\Tp3Businessview\Domain\Model\Tp3BusinessView $businessview)
    {

        $this->persistenceManager = $this->objectManager->get(PersistenceManager::class);
        $this->addFlashMessage('The object was updated.', 'saved', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->tp3BusinessViewRepository->update($businessview);
        $this->persistenceManager->persistAll();

    }

    /**
     * action create
     *
     * @param \Tp3\Tp3Businessview\Domain\Model\Tp3BusinessView  $businessview
     * @return void
     */
    public function createAction(\Tp3\Tp3Businessview\Domain\Model\Tp3BusinessView $businessview)
    {
        $this->persistenceManager = $this->objectManager->get(PersistenceManager::class);
        $this->addFlashMessage('The object was created.', 'created', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->businessvierepository->add($businessview);
        $this->persistenceManager->persistAll();

    }



    public function saveSettingsAction()
    {
        $tmp = $GLOBALS['TYPO3_DB']->exec_SELECTgetSingleRow('uid', 'pages', 'deleted=0 AND hidden=0 AND is_siteroot=1');
        $pageId = (int)$tmp['uid'];

        $languageId = (int)$this->request->getArgument('language');
        $lang = $this->getLanguageService();

        $extraTableRecords = [];

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
        $token = FormProtectionFactory::get()->generateToken('moduleCall', 'web_Tp3BusinessviewModule');
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
    /**
     * @return DatabaseConnection
     */
    protected function getDatabaseConnection()
    {
        return $GLOBALS['TYPO3_DB'];
    }
    /**
     * Inject the DataMapper
     *
     * @param \TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper $dataMapper
     */
    public function injectDataMapper(\TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper $dataMapper)
    {
        $this->dataMapper = $dataMapper;
    }
}
