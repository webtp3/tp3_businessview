<?php

/*
 * This file is part of the web-tp3/tp3businessview.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Tp3\Tp3Businessview\Controller;

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
use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Backend\Template\Components\ButtonBar;
use TYPO3\CMS\Backend\View\BackendTemplateView;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\FormProtection\FormProtectionFactory;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Localization\Locales;
use TYPO3\CMS\Core\Page\PageRenderer;

use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

/**
 * BusinessAdressController
 */
class BusinessAdressController extends ActionController
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
     * @var  rootLine
     */
    public $rootLine= null;

    /**
     * @var  pageUid
     */
    public $pageUid= null;
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
                $this->conf,
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

        if (!($this->dataMapper instanceof DataMapper)) {
            $this->dataMapper = GeneralUtility::makeInstance(DataMapper::class);
        }
        if ($this->cObj === null) {
            $this->cObj = $this->configurationManager->getContentObject();
        }
        if ($this->conf === null) {
            $this->conf = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
        }
        $this->pageUid = GeneralUtility::_GP('id');

        $sysPageObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Frontend\Page\PageRepository::class);
        $this->rootLine = $sysPageObj->getRootLine($this->pageUid);
    }
    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $businessAdresses = $this->businessAdressRepository->findAll();
        $this->view->assign('businessAdresses', $businessAdresses);
    }
    /**
     * action index
     *
     * @return void
     */
    public function indexAction()
    {
        if ($GLOBALS['BE_USER']->user['usergroup'] > 0 || $GLOBALS['BE_USER']->user['admin']) {
            if (!isset($this->conf['persistence']['storagePid']) ||$this->conf['persistence']['storagePid']=='') {
                $storage_id = $this->pageUid;
            } else {
                $storage_id = $this->conf['persistence']['storagePid'];
            }

            // Weiterleitung
            $urlParameters = [
                'id' => $storage_id,
                'table' => 'tt_address',
                'search_levels' => 1
            ];
            $uriBuilder = GeneralUtility::makeInstance(UriBuilder::class);

            $url = (string)$uriBuilder->buildUriFromRoute('web_list', $urlParameters);
            $this->redirectToURI($_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/' . $url);
            exit;
        }
        $businessAdresses = $this->businessAdressRepository->findAll();
        $this->view->assign('businessAdresses', $businessAdresses);
    }
    /**
     * action show
     *
     * @param \Tp3\Tp3Businessview\Domain\Model\BusinessAdress $businessAdress
     * @return void
     */
    public function showAction(\Tp3\Tp3Businessview\Domain\Model\BusinessAdress $businessAdress)
    {
        $this->view->assign('businessAdress', $businessAdress);
    }

    /**
     * action create
     *
     * @param \Tp3\Tp3Businessview\Domain\Model\BusinessAdress  $adress
     * @return void
     */
    public function createAction(\Tp3\Tp3Businessview\Domain\Model\BusinessAdress $adress)
    {
        $this->persistenceManager = $this->objectManager->get(PersistenceManager::class);
        if ($this->businessadressrepository === null) {
            $this->businessadressrepository = $this->objectManager->get(BusinessAdressRepository::class);
        }
        $this->addFlashMessage('The object was created.', 'created', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->businessadressrepository->add($adress);
        $this->persistenceManager->persistAll();
    }

    /**
     * action update
     *
     * @param \Tp3\Tp3Businessview\Domain\Model\BusinessAdress $adress
     * @return void
     */
    public function updateAction(\Tp3\Tp3Businessview\Domain\Model\BusinessAdress $adress)
    {
        $this->persistenceManager = $this->objectManager->get(PersistenceManager::class);
        if ($this->businessadressrepository === null) {
            $this->businessadressrepository = $this->objectManager->get(BusinessAdressRepository::class);
        }
        $this->addFlashMessage('The object was updated.', 'saved', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->businessadressrepository->update($adress);
        $this->persistenceManager->persistAll();
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
            ->setGetVariables(['id' => (int)GeneralUtility::_GP('id')]);
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
        $token = FormProtectionFactory::get()->generateToken('web_Tp3BusinessviewBusinessAdress', 'index');
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
}
