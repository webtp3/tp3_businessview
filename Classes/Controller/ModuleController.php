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
use Tp3\Tp3Businessview\Frontend\PageRenderer\Tp3PageRenderer;
use TYPO3\CMS\Backend\Template\Components\ButtonBar;
use TYPO3\CMS\Backend\View\BackendTemplateView;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Localization\Locales;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\FormProtection\FormProtectionFactory;

use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Tp3\Tp3Businessview\Domain\Repository\Tp3BusinessViewRepository;
use Tp3\Tp3Businessview\Domain\Repository\PanoramasRepository;
use Tp3\Tp3Businessview\Domain\Repository\BusinessAdressRepository;
use TYPO3\CMS\Core\DataHandling\DataHandler as DataHandlerCore;
use DateTime;



/**
 * ModuleController
 */
class ModuleController extends ActionController
{

    /**
     * @var IconFactory
     */
    protected $iconFactory;

    /**
     * @var PersistenceManager
     */
    protected $persistenceManager = null;
    /**
     * Backend Template Container.
     * Takes care of outer "docheader" and other stuff this module is embedded in.
     *
     * @var string
     */
    protected $defaultViewObjectName = BackendTemplateView::class;

    /**
     * @var  pageUid
     */
    public  $pageUid= null;
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
     * @var Tp3PageRenderer;
     */
    protected $jsonRenderer;
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
     *
     * @var \Tp3\Tp3Openhours\Domain\Repository\OpenHourRepository;
     */
    public  $openHourRepository = null;
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

        if (TYPO3_MODE === 'BE') {
            $this->registerDocheaderButtons();
        }
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
     * action index
     *
     * @return void
     */
    public function indexAction()
    {
        $publicResourcesPath = ExtensionManagementUtility::extPath('tp3_businessview') ;

            //$publicResourcesPath = "typo3conf/ext/tp3_businessview";

        $this->pageRenderer->addCssFile(
            $publicResourcesPath.'Resources/Public/Css/Backend/Tp3Backend.css','stylesheet', 'all', "tp3businessview be", $compress = false
        );
       /* $this->pageRenderer->addCssFile(
            $publicResourcesPath.'Resources/Public/Css/Tp3App.css','stylesheet', 'all', "tp3businessview preview", $compress = false, false,  '', true,  '|'
        );*/
        $this->pageRenderer->addJsInlineCode("gapikey",'window.apikey = "'. $this->settings["googleMapsJavaScriptApiKey"].'";TYPO3.jQuery.fn.insertElementAtIndex=function(element,index){var lastIndex=this.children().length; if(index<0){index=Math.max(0,lastIndex+ 1+ index)}this.append(element);if(index<lastIndex){this.children().eq(index).before(this.children().last())}return this;}');

        if(is_array($this->settings)) {
            $this->pageRenderer->addJsInlineCode("panoAnmation",'window.AnmationOptions  = {  panoJumpTimer:'.$this->settings["panoJumpTimer"].', panoRotationTimer:'.$this->settings["panoRotationTimer"].', panoRotationFactor:'.$this->settings["panoRotationFactor"].', panoJumpsRandom:'.$this->settings["panoJumpsRandom"].'};');

            $panoramas = [];
            $businessAdresses = [];
            $businessViews = [];

            if ($this->tp3BusinessViewRepository === null) {
                $this->tp3BusinessViewRepository = $this->objectManager->get(Tp3BusinessViewRepository::class);
            }

            if ($this->panoramasRepository === null) {
                $this->panoramasRepository = $this->objectManager->get(PanoramasRepository::class);
            }
            if ($this->businessAdressRepository === null) {
                $this->businessAdressRepository = $this->objectManager->get(BusinessAdressRepository::class);
                if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded ('tp3_openhours')) {
                    if ($this->openHourRepository === null ) {
                        $this->openHourRepository = $this->objectManager->get(\Tp3\Tp3Openhours\Domain\Repository\OpenHourRepository::class);

                    }
                }
            }
            if ($this->jsonRenderer === null) {
                $this->jsonRenderer = $this->objectManager->get(Tp3PageRenderer::class);
            }
            $querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
            $querySettings->setStoragePageIds(array($this->settings["storagePid"]));
            $this->panoramasRepository->setDefaultQuerySettings($querySettings);
            $this->tp3BusinessViewRepository->setDefaultQuerySettings($querySettings);

            $businessViews = $this->tp3BusinessViewRepository->findAll();
        //    $businessView = $businessViews->getFirst();
            if ($businessViews->getFirst() instanceof \Tp3\Tp3BusinessView\Domain\Model\Tp3BusinessView) {
                foreach ($businessViews as $businessView){
                    $panoramas = $this->panoramasRepository->findByList($businessView->getPanoramas());
                    $panoramas_all = $this->panoramasRepository->findAll();
                    //$querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
                    //$querySettings->setRespectStoragePage(true);
                    // $this->businessAdressRepository->setDefaultQuerySettings($querySettings);
                    $bw = $businessView->getPropertiesArray();
                    $bw['contact'] = $this->businessAdressRepository->findByUidArray($businessView->getContact())[0];
                    $businessAdresses[] = $this->businessAdressRepository->findByUid($businessView->getContact());
                    if ($this->openHourRepository !== null ){
                        $openhours = $this->openHourRepository->findByAddress($businessView->getContact());
                        $formattedText = "";
                        $hoursArray = [];
                        foreach ($openhours as $oh){
                            //$dateconv = \date("H:i",$oh->getOpenTime());
                            $formattedText .= $oh->getDayName() . " " .\date("H:i", $oh->getOpenTime())  . "-" . \date("H:i", $oh->getCloseTime()) ."<br>";
                            $hoursArray[] = [\date("H:i", $oh->getOpenTime()),\date("H:i", $oh->getCloseTime())];
                        }
                        $bw['openingHours'] = [
                            "formattedText" => $formattedText,
                            "status"=>true,
                            "hours"=>$hoursArray,
                        ];
                        /*
                        *
                        "openingHours":{"formattedText":"Montag: geschlossen<br>Di - Fr: 10:00 - 18:00 Uhr<br>Sa - So: 10:00 - 18:00 Uhr","status":true,"hours":[null,["9:00","18:00"],["9:00","18:00"],["9:00","18:00"],["9:00","18:00"],["9:00","18:00"],[],[]]},

                        */
                    }
                    $bw['panorama'] = $panoramas[0];
                    $bw['panoramas'] = [$panoramas];
                    // $bw['contact'] = $this->businessadressrepository->findByUid($businessView->getContact()->getFirst()->getUid())[0];
                    $businessViewJson[$businessView->getUid()] = $this->jsonRenderer->JsonRenderer($bw,$panoramas,$this->settings);
                }
            }

        }


        $this->view->assign('debugMode', $this->conf["debugMode"]);
        $this->view->assign('conf', $this->conf);
        $this->view->assign('settings', $this->settings);
        $this->view->assign('panoramas', $panoramas);
        $this->view->assign('panoramas_all', $panoramas_all);

        $this->view->assign('businessviews', $businessViews);
        $this->view->assign('addresses', $businessAdresses);
        $this->view->assign('businessViewJson', $businessViewJson);

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
     * action edit


     */
    public function editAction () {

        try {
            $item = GeneralUtility::_GP('tx_tp3businessview_web_tp3businessviewmodule') ? GeneralUtility::_GP('tx_tp3businessview_web_tp3businessviewmodule') : "";
            if(is_array($item['tx_tp3businessview_domain_model_panoramas'])) {
                //  if($item['tx_tp3businessview_domain_model_panoramas']["uid"])
                $pano = $this->dataMapper->map(Panoramas::class,[$item['tx_tp3businessview_domain_model_panoramas']]);

                $panorama = $this->objectManager->get('TYPO3\CMS\Extbase\Property\PropertyMapper')
                    ->convert(
                        $pano[0],
                        Panoramas::class
                    );
                if($item['tx_tp3businessview_domain_model_panoramas']["uid"] == ""){
                    $tcemainData = [
                        'tx_tp3businessview_domain_model_panoramas' => [
                            'NEW' => [
                                $panorama->_getCleanProperties()
                            ]
                        ]
                    ];
                }
                else if($item['tx_tp3businessview_domain_model_panoramas']["uid"] == ""){
                    $tcemainData = [
                        'tx_tp3businessview_domain_model_panoramas' => [
                            'UPDATE' => [
                                $panorama->_getCleanProperties()
                            ]
                        ]
                    ];
                }

                $dataHandler = GeneralUtility::makeInstance(DataHandlerCore::class);
                $dataHandler->start($tcemainData, []);
                $dataHandler->process_datamap();

                $pano = $dataHandler->substNEWwithIDs['NEW'];
                return $pano;
            }
            if(is_array($item['tx_tp3businessview_domain_model_businessadress'])) {
                //  if($item['tx_tp3businessview_domain_model_panoramas']["uid"])
                $address = $this->dataMapper->map(BusinessAdress::class,[$item['tx_tp3businessview_domain_model_businessadress']]);
                if($item['tx_tp3businessview_domain_model_businessadress']["uid"] == "") $this->createadressAction($address[0]);
                else $this->updateadressAction($address[0]);
            }

        } catch (Exception $e) {
            $message = $GLOBALS['LANG']->sL(self::LL_PATH . $e->getMessage());
            throw new \RuntimeException($message);
        }
      //  $this->redirect('index');

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
        $token = FormProtectionFactory::get()->generateToken('web_Tp3BusinessviewModule', 'index');
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
