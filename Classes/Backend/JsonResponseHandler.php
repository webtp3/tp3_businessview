<?php

/*
 * This file is part of the package web-tp3/tp3-businessview.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Tp3\Tp3Businessview\Backend;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Tp3\Tp3Businessview\Domain\Repository\BusinessAdressRepository;
use Tp3\Tp3Businessview\Domain\Repository\PanoramasRepository;
use Tp3\Tp3Businessview\Domain\Repository\Tp3BusinessViewRepository;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

class JsonResponseHandler extends ActionController
{
    protected ?PersistenceManager $persistenceManager = null;

    public function __construct(
        protected readonly Tp3BusinessViewRepository $tp3BusinessViewRepository,
        protected readonly PanoramasRepository $panoramasRepository,
        protected readonly BusinessAdressRepository $businessAdressRepository,
    ) {
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

        $this->persistenceManager = GeneralUtility::makeInstance(PersistenceManager::class);
    }
    /**
     * Returns the complete data set as JSON for FE and backend module.
     */
    public function indexAction(ServerRequestInterface $request): ResponseInterface
    {
        $backendUser = $this->getBackendUser();
        $languageService = $this->getLanguageService();

        $queryParams = $request->getQueryParams();

        $currentModule = $request->getAttribute('module');
        //        $currentModuleIdentifier = $currentModule->getIdentifier();
        $pageUid = (int)($queryParams['id'] ?? 0);
        $pageRecord = BackendUtility::readPageAccess($pageUid, '1=1') ?: [];

        $pid = (int)($request->getParsedBody()['pid'] ?? $request->getQueryParams()['pid'] ?? 0);

        $businessviews = $pid > 0
            ? $this->tp3BusinessViewRepository->findByPid($pid)
            : $this->tp3BusinessViewRepository->findAll();

        $panoramas = $pid > 0
            ? $this->panoramasRepository->findByPid($pid)
            : $this->panoramasRepository->findAll();

        $addresses = $pid > 0
            ? $this->businessAdressRepository->findByPid($pid)
            : $this->businessAdressRepository->findAll();
        $response = new JsonResponse([
            'success' => true,
            'pid' => $pid,
            'businessviews' => $this->normalizeResult($businessviews),
            'panoramas' => $this->normalizeResult($panoramas),
            'addresses' => $this->normalizeResult($addresses),
        ]);
        return $response;
    }
    public function sortAction(ServerRequestInterface $request): ResponseInterface
    {
        $body = $request->getParsedBody();
        $queryParams = $request->getQueryParams();

        $uid = (int)($body['uid'] ?? $queryParams['uid'] ?? 0);
        $pid = (int)($body['pid'] ?? $queryParams['pid'] ?? 0);
        $direction = (string)($body['direction'] ?? $queryParams['direction'] ?? '');

        if ($uid <= 0 || ($direction !== 'up' && $direction !== 'down')) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Invalid sort request',
            ], 400);
        }

        $current = $this->panoramasRepository->findByUid($uid);
        if (!$current) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Panorama not found',
            ], 404);
        }

        $panoramas = $pid > 0
            ? $this->panoramasRepository->findByPid($pid)
            : $this->panoramasRepository->findAll();

        $items = $this->normalizeResult($panoramas);

        usort($items, static function (array $a, array $b): int {
            return (int)($a['position'] ?? 0) <=> (int)($b['position'] ?? 0);
        });

        $currentIndex = null;
        foreach ($items as $index => $item) {
            if ((int)($item['uid'] ?? 0) === $uid) {
                $currentIndex = $index;
                break;
            }
        }

        if ($currentIndex === null) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Panorama not found in list',
            ], 404);
        }

        $swapIndex = $direction === 'up'
            ? $currentIndex - 1
            : $currentIndex + 1;

        if (!isset($items[$swapIndex])) {
            return new JsonResponse([
                'success' => false,
                'message' => 'No swap target available',
            ], 200);
        }

        $currentItem = $items[$currentIndex];
        $swapItem = $items[$swapIndex];

        $currentEntity = $this->panoramasRepository->findByUid((int)$currentItem['uid']);
        $swapEntity = $this->panoramasRepository->findByUid((int)$swapItem['uid']);

        if ($currentEntity && $swapEntity) {
            $currentPosition = (string)$currentEntity->getPosition();
            $swapPosition = (string)$swapEntity->getPosition();

            $currentEntity->setPosition($swapPosition);
            $swapEntity->setPosition($currentPosition);

            $this->panoramasRepository->update($currentEntity);
            $this->panoramasRepository->update($swapEntity);

            $this->persistenceManager->persistAll();
        }

        return new JsonResponse([
            'success' => true,
            'uid' => $uid,
            'direction' => $direction,
        ]);
    }
    public function readAction(ServerRequestInterface $request): ResponseInterface
    {
        $backendUser = $this->getBackendUser();
        $languageService = $this->getLanguageService();

        $queryParams = $request->getQueryParams();
        $uid = (int)($queryParams['uid'] ?? 0);
        $pid = (int)($request->getParsedBody()['pid'] ?? $request->getQueryParams()['pid'] ?? 0);

        if ($uid) {
            $type = (string)($queryParams['type'] ?? '');

            if ($type === 'pano') {
                $record = $this->panoramasRepository->findByUid($uid);
            } else {
                $record = $this->tp3BusinessViewRepository->findByUid($uid);
            }

            return new JsonResponse([
                'success' => true,
                'pid' => $pid,
                'type' => $type,
                'businessview' => $record ? $this->normalizeResult($record) : null,
            ]);
        }

        $businessviews = $pid > 0
        ? $this->tp3BusinessViewRepository->findByPid($pid)
        : $this->tp3BusinessViewRepository->findAll();

        $panoramas = $pid > 0
        ? $this->panoramasRepository->findByPid($pid)
        : $this->panoramasRepository->findAll();

        $addresses = $pid > 0
        ? $this->businessAdressRepository->findByPid($pid)
        : $this->businessAdressRepository->findAll();
        $response = new JsonResponse([
            'success' => true,
            'pid' => $pid,
            'businessviews' => $this->normalizeResult($businessviews),
            'panoramas' => $this->normalizeResult($panoramas),
            'addresses' => $this->normalizeResult($addresses),
        ]);

        return $response;
    }
    public function dispatchAction(ServerRequestInterface $request): ResponseInterface
    {
        $action = (string)($request->getParsedBody()['submitType'] ?? $request->getQueryParams()['submitType'] ?? 'read');

        return match ($action) {
            'create' => $this->createAction($request),
            'read' => $this->readAction($request),
            'update' => $this->updateAction($request),
            'delete' => $this->deleteAction($request),
            default => $this->readAction($request),
        };
    }

    protected function buildPanoramaFromRequest(ServerRequestInterface $request): array
    {
        $body = $request->getParsedBody();

        return [
            'panoramaData' => $body['tx_tp3businessview_module']['panorama'] ?? [],
            'panoramaInput' => $body['panoramas'] ?? [],
            'businessViewUid' => (int)($body['tp3businessview']['uid'] ?? 0),
            'settings' => is_array($body['settings'] ?? null) ? $body['settings'] : [],
        ];
    }

    protected function mergeBusinessViewSettingsIntoDescription(\Tp3\Tp3Businessview\Domain\Model\Tp3BusinessView $businessView, array $settings): void
    {
        if ($settings === []) {
            return;
        }

        $allowedKeys = [
            'color',
            'backgroundColor',
            'textColor',
            'align',
            'panoJumpTimer',
            'panoJumpsRandom',
            'panoRotationTimer',
            'panoRotationFactor',
        ];

        $normalized = [];
        foreach ($allowedKeys as $key) {
            if (array_key_exists($key, $settings)) {
                $normalized[$key] = (string)$settings[$key];
            }
        }

        if ($normalized === []) {
            return;
        }

        $currentDescription = (string)($businessView->getDescription() ?? '');
        $baseDescription = preg_replace('/\s*<!--tp3bv-settings:[A-Za-z0-9+\/=]+-->\s*/', '', $currentDescription) ?? '';
        $settingsPayload = base64_encode((string)json_encode($normalized));
        $businessView->setDescription(trim($baseDescription) . PHP_EOL . '<!--tp3bv-settings:' . $settingsPayload . '-->');
    }

    public function createAction(ServerRequestInterface $request): ResponseInterface
    {
        $data = $this->buildPanoramaFromRequest($request);
        $panoramaData = $data['panoramaData'];
        $panoramaInput = $data['panoramaInput'];
        $businessViewUid = $data['businessViewUid'];
        $settings = $data['settings'];

        $panorama = new \Tp3\Tp3Businessview\Domain\Model\Panoramas();
        $panorama->setHeading((string)($panoramaData['heading'] ?? ''));
        $panorama->setPosition((string)($panoramaData['position'] ?? ''));
        $panorama->setPitch((string)($panoramaData['pitch'] ?? ''));
        $panorama->setZoom((string)($panoramaData['zoom'] ?? ''));
        $panorama->setPanoId((string)($panoramaData['panoId'] ?? ''));

        $pid = (int)($panoramaInput['pid'] ?? 0);
        if ($pid > 0) {
            $panorama->_setProperty('pid', $pid);
        }

        $businessView = null;
        if ($businessViewUid > 0) {
            $businessView = $this->tp3BusinessViewRepository->findByUid($businessViewUid)->getFirst();
            if ($businessView && $pid <= 0) {
                $panorama->_setProperty('pid', (int)$businessView->_getProperty('pid'));
            }
        }
        $this->persistenceManager = GeneralUtility::makeInstance(PersistenceManager::class);

        $this->panoramasRepository->add($panorama);
        $this->persistenceManager->persistAll();

        if ($businessView) {
            // Persist relation from BusinessView side (MM owner side)
            $businessView->addPanoramas($panorama);
            $this->mergeBusinessViewSettingsIntoDescription($businessView, $settings);
            $this->tp3BusinessViewRepository->update($businessView);
            $this->persistenceManager->persistAll();
        }

        return new JsonResponse([
            'success' => true,
            'action' => 'create',
            'uid' => $panorama->getUid(),
        ]);
    }

    public function updateAction(ServerRequestInterface $request): ResponseInterface
    {
        $data = $this->buildPanoramaFromRequest($request);
        $panoramaData = $data['panoramaData'];
        $panoramaInput = $data['panoramaInput'];
        $businessViewUid = $data['businessViewUid'];
        $settings = $data['settings'];

        $uid = (int)($panoramaInput['uid'] ?? 0);
        if ($uid <= 0) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Panorama UID fehlt',
            ], 400);
        }

        $existing = $this->panoramasRepository->findByUid($uid)->getFirst();
        if (!$existing) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Panorama nicht gefunden',
            ], 404);
        }

        $existing->setHeading((string)($panoramaData['heading'] ?? ''));
        $existing->setPosition((string)($panoramaData['position'] ?? ''));
        $existing->setPitch((string)($panoramaData['pitch'] ?? ''));
        $existing->setZoom((string)($panoramaData['zoom'] ?? ''));
        $existing->setPanoId((string)($panoramaData['panoId'] ?? ''));

        $businessView = null;
        if ($businessViewUid > 0) {
            $businessView = $this->tp3BusinessViewRepository->findByUid($businessViewUid)->getFirst();
        }
        $this->persistenceManager = GeneralUtility::makeInstance(PersistenceManager::class);

        $this->panoramasRepository->update($existing);
        $this->persistenceManager->persistAll();

        if ($businessView) {
            $businessView->addPanoramas($existing);
            $this->mergeBusinessViewSettingsIntoDescription($businessView, $settings);
            $this->tp3BusinessViewRepository->update($businessView);
            $this->persistenceManager->persistAll();
        }

        return new JsonResponse([
            'success' => true,
            'action' => 'update',
            'uid' => $existing->getUid(),
        ]);
    }

    /**
     * Normalize Extbase query results or arrays to plain arrays.
     */
    protected function normalizeResult(mixed $result): array
    {
        if ($result instanceof QueryResultInterface) {
            $result = $result->toArray();
        }

        if (!is_array($result)) {
            return [];
        }

        $normalized = [];

        foreach ($result as $item) {
            if (is_object($item) && method_exists($item, 'getUid')) {
                $normalized[] = $this->normalizeObject($item);
            } elseif (is_array($item)) {
                $normalized[] = $item;
            }
        }

        return $normalized;
    }

    /**
     * Convert a domain object into a plain array.
     */
    protected function normalizeObject(object $object): array
    {
        $data = [
            'uid' => method_exists($object, 'getUid') ? $object->getUid() : null,
        ];

        foreach (get_class_methods($object) as $method) {
            if (str_starts_with($method, 'get') && $method !== 'getUid') {
                $propertyName = lcfirst(substr($method, 3));
                try {
                    $value = $object->$method();
                    if (is_object($value)) {
                        if (method_exists($value, 'getUid')) {
                            $data[$propertyName] = [
                                'uid' => $value->getUid(),
                            ];
                        } else {
                            $data[$propertyName] = (string)$value;
                        }
                    } elseif (is_array($value)) {
                        $data[$propertyName] = $value;
                    } else {
                        $data[$propertyName] = $value;
                    }
                } catch (\Throwable) {
                    // ignore getter failures and continue
                }
            }
        }

        return $data;
    }

    private function addShortcutButtonToDocHeader(ModuleTemplate $view, string $moduleIdentifier, array $pageInfo, int $pageUid): void
    {
        $languageService = $this->getLanguageService();
        $buttonBar = $view->getDocHeaderComponent()->getButtonBar();
        $shortcutTitle = sprintf(
            '%s: %s [%d]',
            $languageService->sL('LLL:EXT:backend/Resources/Private/Language/locallang_pagetsconfig.xlf:module.pagetsconfig_includes'),
            BackendUtility::getRecordTitle('pages', $pageInfo),
            $pageUid
        );
        $shortcutButton = $buttonBar->makeShortcutButton()
            ->setRouteIdentifier($moduleIdentifier)
            ->setDisplayName($shortcutTitle)
            ->setArguments(['id' => $pageUid]);
        $buttonBar->addButton($shortcutButton);
    }

    private function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }

    private function getBackendUser(): BackendUserAuthentication
    {
        return $GLOBALS['BE_USER'];
    }
    protected function htmlResponse(?string $html = null): ResponseInterface
    {
        return $this->responseFactory->createResponse()
            ->withHeader('Content-Type', 'text/html; charset=utf-8')
            ->withBody($this->streamFactory->createStream((string)($html ?? $this->view->render())));
    }

    protected function JsonXResponse(?array $data = [], int $status = 200): ResponseInterface
    {

        return $this->responseFactory->createResponse()
            ->withHeader('Content-Type', 'text/json; charset=utf-8')
            ->withBody($this->streamFactory->createStream(json_encode($data) ?? $this->view->render()));
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
