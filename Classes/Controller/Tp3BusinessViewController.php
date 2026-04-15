<?php

/*
 * This file is part of the package web-tp3/tp3-businessview.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Tp3\Tp3Businessview\Controller;

use Tp3\Tp3Businessview\Domain\Repository\Tp3BusinessViewRepository;
use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\FormProtection\FormProtectionFactory;
use TYPO3\CMS\Core\Localization\Locales;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use Psr\Http\Message\ResponseInterface;

class Tp3BusinessViewController extends ActionController
{
    protected ?PersistenceManager $persistenceManager = null;
    protected ?Locales $localeService = null;
    protected PageRenderer $pageRenderer;

    public function __construct(
        protected readonly Tp3BusinessViewRepository $tp3BusinessViewRepository,
    ) {}

    protected function initializeAction(): void
    {
        $this->persistenceManager = GeneralUtility::makeInstance(PersistenceManager::class);
        $this->pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        $this->localeService = GeneralUtility::makeInstance(Locales::class);

        parent::initializeAction();
    }
    protected function htmlResponse(?string $html = null): ResponseInterface
    {
        return $this->responseFactory->createResponse()
            ->withHeader('Content-Type', 'text/html; charset=utf-8')
            ->withBody($this->streamFactory->createStream((string)($html ?? $this->view->render())));
    }

    public function indexAction(): ResponseInterface
    {
        $context = GeneralUtility::makeInstance(Context::class);
        $backendUser = $context->getPropertyFromAspect('backend.user', 'id');

        if ($backendUser) {
            $storage_id = $this->conf['persistence']['storagePid'] ?? $this->pageUid;
            $urlParameters = [
                'id' => $storage_id,
                'table' => 'tx_tp3businessview_domain_model_tp3businessview',
                'search_levels' => 1
            ];
            $uriBuilder = GeneralUtility::makeInstance(UriBuilder::class);

            $url = (string)$uriBuilder->buildUriFromRoute('web_list', $urlParameters);
            $this->redirectToURI($_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/' . $url);
            exit;
        }
        return $this->htmlResponse($this->view->render());
    }

    public function createAction(\Tp3\Tp3Businessview\Domain\Model\Tp3BusinessView $businessview): void
    {
        $this->tp3BusinessViewRepository->add($businessview);
        $this->persistenceManager->persistAll();
        $this->addFlashMessage('The object was created.', 'created', ContextualFeedbackSeverity::WARNING);
    }

    public function updateAction(\Tp3\Tp3Businessview\Domain\Model\Tp3BusinessView $businessview): void
    {
        $this->tp3BusinessViewRepository->update($businessview);
        $this->persistenceManager->persistAll();
        $this->addFlashMessage('The object was updated.', 'saved', ContextualFeedbackSeverity::WARNING);
    }

    protected function getToken(bool $tokenOnly = false): string
    {
        $token = FormProtectionFactory::get()->generateToken('moduleCall', 'web_Tp3BusinessviewModule');
        return $tokenOnly ? $token : '&moduleToken=' . $token;
    }

    public function getBackendUser(): \TYPO3\CMS\Core\Authentication\BackendUserAuthentication
    {
        return GeneralUtility::makeInstance(Context::class)->getPropertyFromAspect('backend.user', 'id');
    }
}
