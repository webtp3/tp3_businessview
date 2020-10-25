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

use Tp3\Tp3Businessview\Domain\Model\Panoramas;
use Tp3\Tp3Businessview\Domain\Model\Tp3BusinessView;
use Tp3\Tp3Businessview\Domain\Repository\PanoramasRepository;
use Tp3\Tp3Businessview\Domain\Repository\Tp3BusinessViewRepository;
use TYPO3\CMS\Backend\View\BackendTemplateView;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\DataHandling\DataHandler as DataHandlerCore;

use TYPO3\CMS\Core\Localization\Locales;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

/**
 * PanoramasController
 */
class PanoramasController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
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
    protected $configuration = [
        'translations' => [
            'availableLocales' => [],
            'languageKeyToLocaleMapping' => []
        ],
        'menuActions' => [],
        'previewDomain' => null,
        'previewUrlTemplate' => '',
        'viewSettings' => []
    ];

    /* @var $dataMapper \TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper */
    protected $dataMapper;
    /**
     *
     */
    public $cObj = null;
    /**
     *
     */
    public $panoramas = null;
    /**
     *
     */
    public $tp3businessview = null;
    /**
     *

     */
    public $businessadress = null;

    /**
     *
     * @var \Tp3\Tp3Businessview\Domain\Repository\PanoramasRepository;
     */
    public $panoramasRepository = null;
    /**
     *
     * @var \Tp3\Tp3Businessview\Domain\Repository\Tp3BusinessViewRepository;
     */
    public $tp3BusinessViewRepository = null;

    /**
     *
     * @var \Tp3\Tp3Businessview\Domain\Repository\BusinessAdressRepository;
     */
    public $businessadressrepository = null;
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

        if ($this->request->hasArgument('panoramas')) {
            if (!($this->persistenceManager instanceof PersistenceManager)) {
                $this->persistenceManager = $this->objectManager->get(PersistenceManager::class);
            }
            $pano_array = $this->request->getArgument('panoramas');
            $this->request->SetArgument('panoramas', $pano_array);
            if ($pano_array['tp3businessviews'] > 0) {
                $this->request->SetArgument('tp3businessview', ['uid'=>$pano_array['tp3businessviews']]);
                /* mm relations */
                if (!($this->tp3BusinessViewRepository instanceof Tp3BusinessViewRepository)) {
                    $this->tp3BusinessViewRepository = $this->objectManager->get(Tp3BusinessViewRepository::class);
                }
            }
        }
        if ($this->cObj === null) {
            $this->cObj = $this->configurationManager->getContentObject();
        }
        if ($this->conf === null) {
            $this->conf = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
        }
    }
    /**
     * initialize create action
     *
     * @return void
     */
    public function initializeCreateAction()
    {
        $this->arguments->getArgument('panoramas')->getPropertyMappingConfiguration()->allowAllProperties();
        $this->arguments->getArgument('panoramas')->getPropertyMappingConfiguration()->setTargetTypeForSubProperty('uid', 'string');
    }
    /**
     * initialize create action
     *
     * @return void
     */
    public function initializeUpdateAction()
    {
        $this->arguments->getArgument('panoramas')->getPropertyMappingConfiguration()->allowAllProperties();
        $this->arguments->getArgument('panoramas')->getPropertyMappingConfiguration()->setTargetTypeForSubProperty('uid', 'string');
    }
    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $panoramas = $this->panoramasRepository->findAll();
        $this->view->assign('panoramas', $panoramas);
    }

    /**
     * action show
     *
     * @param \Tp3\Tp3Businessview\Domain\Model\Panoramas $panoramas
     * @return void
     */
    public function showAction(\Tp3\Tp3Businessview\Domain\Model\Panoramas $panoramas)
    {
        $this->view->assign('panoramas', $panoramas);
    }
    /**
     * action update
     *
     * @param \Tp3\Tp3Businessview\Domain\Model\Panoramas $panoramas
     * @return void
     */
    public function updateAction(\Tp3\Tp3Businessview\Domain\Model\Panoramas $panoramas)
    {
        if ($panoramas->uid == 'NEW') {
            $this->redirect('create');
        }

        if ($this->panoramasRepository === null) {
            $this->panoramasRepository = $this->objectManager->get(PanoramasRepository::class);
        }
        $this->panoramasRepository->add($panoramas);
        /* mm */
        if ($this->request->hasArgument('tp3businessview')) {
            $this->tp3businessview= $this->tp3BusinessViewRepository->findByUid(intval($this->request->getArgument('tp3businessview')['uid']), false);
            if( $this->tp3businessview->getFirst() instanceof Tp3BusinessView){
                $this->tp3businessview->getFirst()->addPanoramas($panoramas);
                $this->tp3BusinessViewRepository->update($this->tp3businessview->getFirst());
            }
        }
        $this->addFlashMessage('The object was updated.', 'saved', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->persistenceManager->persistAll();

        if (TYPO3_MODE === 'BE') {
            $this->redirect('index', 'Module');
        } else {
            $this->redirect('list', 'Tp3BusinessView');
        }
    }
    /**
     * action create
     *
     * @param \Tp3\Tp3Businessview\Domain\Model\Panoramas $panoramas
     * @return void
     */
    public function createAction(\Tp3\Tp3Businessview\Domain\Model\Panoramas $panoramas)
    {
        /*    $tcemainData = [
                'tx_tp3businessview_domain_model_panoramas' => [
                    'NEW' => [
                        ArrayUtility::mergeRecursiveWithOverrule(
                            $panoramas->_getCleanProperties(),
                            ["uid" => "NEW"]
                        )
                    ]
                ]
            ];



        $dataHandler = GeneralUtility::makeInstance(DataHandlerCore::class);
        $dataHandler->start($tcemainData,[]);
        $dataHandler->process_datamap();
        $dataHandler->process_cmdmap();

        $this->addFlashMessage('The object was updated.', 'saved', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $pano = $dataHandler->substNEWwithIDs['NEW'];
//       return $pano;
        $this->redirect('index','Tp3BusinessView');
        */

        if ($this->panoramasRepository === null) {
            $this->panoramasRepository = $this->objectManager->get(PanoramasRepository::class);
        }
        if ($panoramas->getPid() == null) {
            $panoramas->setPid($this->conf['persistence']['storagePid']);
        }
        if ($panoramas->getUid() == '') {
            $panoramas->setUid(null);
        }

        $this->panoramasRepository->add($panoramas);

        $this->persistenceManager->persistAll();
        /* mm */
        if ($this->request->hasArgument('tp3businessview')) {
            $this->tp3businessview= $this->tp3BusinessViewRepository->findByUid($this->request->getArgument('tp3businessview')['uid'], false);
            if( $this->tp3businessview->getFirst() instanceof Tp3BusinessView){
                $this->tp3businessview->getFirst()->addPanoramas($panoramas);
                $this->tp3BusinessViewRepository->update($this->tp3businessview->getFirst());
                $this->persistenceManager->persistAll();
            }

        }

        $this->addFlashMessage('The object was created.', 'saved', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);

        if (TYPO3_MODE === 'BE') {
            $this->redirect('index', 'Module');
        } else {
            $this->redirect('list', 'Tp3BusinessView');
        }
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
        $token = FormProtectionFactory::get()->generateToken('moduleCall', 'web_tp3businessviewmodule');
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
