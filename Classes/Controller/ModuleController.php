<?php

/*
 * This file is part of the package web-tp3/tp3-businessview.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Tp3\Tp3Businessview\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Tp3\Tp3Businessview\Database\QueryGenerator;
use Tp3\Tp3Businessview\Domain\Model\Dto\Settings;
use Tp3\Tp3Businessview\Domain\Repository\BusinessAdressRepository;
use Tp3\Tp3Businessview\Domain\Repository\PanoramasRepository;
use Tp3\Tp3Businessview\Domain\Repository\Tp3BusinessViewRepository;
use TYPO3\CMS\Backend\Module\ModuleData;
use TYPO3\CMS\Backend\Routing\UriBuilder as BackendUriBuilder;
use TYPO3\CMS\Backend\Template\ModuleTemplate;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class ModuleController extends ActionController
{
    /**
     * Contains the settings of the current extension
     */
    protected array $settings = [];
    protected ?ModuleData $moduleData = null;

    protected ModuleTemplate $moduleTemplate;

    protected ConfigurationManagerInterface $configurationManager;
    protected ModuleTemplateFactory $moduleTemplateFactory;
    protected IconFactory $iconFactory;
    protected PageRenderer $pageRenderer;

    protected queryGenerator $queryGenerator;
    protected Settings $extensionConfiguration;
    protected array $piVars;
    protected int $id;
    protected BackendUriBuilder $backendUriBuilder;

    public function injectModuleTemplateFactory(ModuleTemplateFactory $moduleTemplateFactory): void
    {
        $this->moduleTemplateFactory = $moduleTemplateFactory;
    }

    public function injectIconFactory(IconFactory $iconFactory): void
    {
        $this->iconFactory = $iconFactory;
    }

    public function injectPageRenderer(PageRenderer $pageRenderer): void
    {
        $this->pageRenderer = $pageRenderer;
    }

    public function __construct(
        protected readonly Tp3BusinessViewRepository $tp3BusinessViewRepository,
        protected readonly PanoramasRepository $panoramasRepository,
        protected readonly BusinessAdressRepository $businessAdressRepository,
    ) {
        $this->isPhpSpreadsheetInstalled = class_exists(\PhpOffice\PhpSpreadsheet\IOFactory::class);
    }

    /**
     * Injects the Configuration Manager and is initializing the framework settings
     *
     * @param ConfigurationManagerInterface $configurationManager Instance of the Configuration Manager
     */
    public function injectConfigurationManager(ConfigurationManagerInterface $configurationManager): void
    {
        parent::injectConfigurationManager($configurationManager);
        $this->configurationManager = $configurationManager;

        // get the whole typoscript (_FRAMEWORK does not work anymore, don't know why)
        $tsSettings = $this->configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT,
            '',
            ''
        );

        // correct the array to be in same shape like the _SETTINGS array
        $tsSettings = $this->removeDots((array) ($tsSettings['plugin.']['tx_tp3businessview_tp3businessview.'] ?? []));
        //@todo settings security
        $originalSettings = $tsSettings['settings'];
        // get original settings
        // original means: what extbase does by munching flexform and TypoScript together, but leaving empty flexform-settings empty ...
        //        $originalSettings = $this->configurationManager->getConfiguration(
        //            ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS
        //        );
        //        $propertiesNotAllowedViaFlexForms = ['orderByAllowed'];
        //        foreach ($propertiesNotAllowedViaFlexForms as $property) {
        //            if (isset($tsSettings['settings'][$property])) {
        //                $originalSettings[$property] = $tsSettings['settings'][$property];
        //            }
        //        }

        // start override
        if (isset($tsSettings['settings']['overrideFlexformSettingsIfEmpty'])) {
            $typoScriptUtility = GeneralUtility::makeInstance(TypoScript::class);
            $originalSettings = $typoScriptUtility->override($originalSettings, $tsSettings);
        }
        // Re-set global settings
        $this->settings = $originalSettings;
    }

    protected function initializeAction(): void
    {
        parent::initializeAction();

        $this->queryGenerator = GeneralUtility::makeInstance(QueryGenerator::class);
        $this->extensionConfiguration = GeneralUtility::makeInstance(Settings::class);
        $this->backendUriBuilder = GeneralUtility::makeInstance(BackendUriBuilder::class);
    }

    /**
     * @noinspection PhpUnused
     */
    public function dispatchAction(string $forwardToAction = 'index'): ResponseInterface
    {
        return (new ForwardResponse($forwardToAction))
            ->withControllerName('Module')
            ->withExtensionName('Tp3Businessview');
    }

    public function indexAction(ServerRequestInterface $request): ResponseInterface
    {
        $this->queryGenerator = GeneralUtility::makeInstance(QueryGenerator::class);
        $this->extensionConfiguration = GeneralUtility::makeInstance(Settings::class);
        $this->moduleTemplate = $this->moduleTemplateFactory->create($request);

        $this->backendUriBuilder = GeneralUtility::makeInstance(BackendUriBuilder::class);
        $jsonUrl = (string)$this->backendUriBuilder->buildUriFromRoute('ajax_tp3businessview_json');
        $dispatcher = (string)$this->backendUriBuilder->buildUriFromRoute('ajax_tp3businessview_dispatch');
        $this->moduleTemplate->assign('jsonUrl', $jsonUrl);
        $this->moduleTemplate->assign('settings', $this->getSettings());

        $this->moduleTemplate->assign('dispatcher', $dispatcher);
        $this->moduleTemplate->assign(
            'googleMapsJavaScriptApiKey',
            $this->extensionConfiguration->getGoogleMapsJavaScriptApiKey()
        );
        $this->pageRenderer->loadJavaScriptModule('@tp3/tp3-businessview/Tp3Bootstrap.js');
        $this->pageRenderer->loadJavaScriptModule('@tp3/tp3-businessview/Tp3Json.js');

        $this->pageRenderer->addCssFile('EXT:tp3_businessview/Resources/Public/Css/Backend/Tp3Backend.css');
        $this->pageRenderer->addInlineSetting(
            'tp3Businessview',
            'googleMapsJavaScriptApiKey',
            (string)($this->extensionConfiguration->getGoogleMapsJavaScriptApiKey() ?? '')
        );
        $pid = $this->settings['storagePid'];
        $businessviews = $pid > 0
            ? $this->tp3BusinessViewRepository->findByPid($pid)
            : $this->tp3BusinessViewRepository->findAll();

        $panoramas = $pid > 0
            ? $this->panoramasRepository->findByPid($pid)
            : $this->panoramasRepository->findAll();

        $addresses = $pid > 0
            ? $this->businessAdressRepository->findByPid($pid)
            : $this->businessAdressRepository->findAll();
        $this->moduleTemplate->assignMultiple(
            [
                'panoramas' => $panoramas,
                'addresses' => $addresses,
                'businessviews' => $businessviews

            ]
        );
        return $this->moduleTemplate->renderResponse('Module/Index');
    }
    /**
     * Removes dots at the end of a configuration array
     *
     * @param array $settings the array to transformed
     * @return array $settings the transformed array
     */
    protected function removeDots(array $settings): array
    {
        $conf = [];
        foreach ($settings as $key => $value) {
            $conf[$this->removeDotAtTheEnd($key)] = \is_array($value) ? $this->removeDots($value) : $value;
        }
        return $conf;
    }

    protected function getSettings(): array
    {
        return $this->settings;
    }
    /**
     * Removes a dot in the end of a String
     *
     * @param string $string
     */
    protected function removeDotAtTheEnd($string): string
    {
        return preg_replace('/\.$/', '', (string) $string);
    }

    /**
     * Retrieves subpages of given pageIds recursively until reached $this->settings['recursive']
     *
     * @return array an array with all pageIds
     */
    protected function getPidList(): array
    {
        $rootPIDs = explode(',', $this->settings['pages']);
        $pidList = $rootPIDs;

        // iterate through root-page ids and merge to array
        foreach ($rootPIDs as $pid) {
            // @extensionScannerIgnoreLine
            $result = $this->queryGenerator->getTreeList($pid, (int) ($this->settings['recursive'] ?? 0));
            if ($result) {
                $subtreePids = explode(',', $result);
                $pidList = array_merge($pidList, $subtreePids);
            }
        }
        return $pidList;
    }

    /**
     * @param QueryResultInterface|array $addresses
     * @return ArrayPaginator|QueryResultPaginator
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException
     */
    protected function getPaginator($addresses): PaginatorInterface
    {
        $currentPage = $this->request->hasArgument('currentPage') ? (int) $this->request->getArgument('currentPage') : 1;
        $itemsPerPage = (int) ($this->settings['paginate']['itemsPerPage'] ?? 10);
        if ($itemsPerPage === 0) {
            $itemsPerPage = 10;
        }

        if (is_array($addresses)) {
            $paginator = new ArrayPaginator($addresses, $currentPage, $itemsPerPage);
        } elseif ($addresses instanceof QueryResultInterface) {
            $paginator = new QueryResultPaginator($addresses, $currentPage, $itemsPerPage);
        } else {
            throw new \RuntimeException(sprintf('Only array and query result interface allowed for pagination, given "%s"', get_class($addresses)), 1611168593);
        }
        return $paginator;
    }
}
