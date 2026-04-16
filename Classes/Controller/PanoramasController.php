<?php

/*
 * This file is part of the package web-tp3/tp3-businessview.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Tp3\Tp3Businessview\Controller;

use Psr\Http\Message\ResponseInterface;
use Tp3\Tp3Businessview\Domain\Repository\PanoramasRepository;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\FormProtection\FormProtectionFactory;
use TYPO3\CMS\Core\Localization\Locales;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

class PanoramasController extends ActionController
{
    protected ?PersistenceManager $persistenceManager = null;
    protected PageRenderer $pageRenderer;
    protected ?Locales $localeService = null;

    public function __construct(
        protected readonly PanoramasRepository $panoramasRepository,
    ) {
    }

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
    public function listAction(): ResponseInterface
    {
        $panoramas = $this->panoramasRepository->findAll();
        $this->view->assign('panoramas', $panoramas);
        return $this->htmlResponse($this->view->render());

    }

    public function updateAction(\Tp3\Tp3Businessview\Domain\Model\Panoramas $panoramas): void
    {
        $this->panoramasRepository->update($panoramas);
        $this->addFlashMessage('The object was updated.', 'saved', ContextualFeedbackSeverity::WARNING);
        $this->persistenceManager->persistAll();

        $this->redirect('list', 'Tp3BusinessView');
    }

    public function createAction(\Tp3\Tp3Businessview\Domain\Model\Panoramas $panoramas): void
    {
        $this->panoramasRepository->add($panoramas);
        $this->persistenceManager->persistAll();

        $this->addFlashMessage('The object was created.', 'created', ContextualFeedbackSeverity::WARNING);
        $this->redirect('list', 'Tp3BusinessView');
    }

    protected function getToken(bool $tokenOnly = false): string
    {
        $token = FormProtectionFactory::get()->generateToken('moduleCall', 'web_tp3businessviewmodule');
        return $tokenOnly ? $token : '&moduleToken=' . $token;
    }

    public function getBackendUser(): \TYPO3\CMS\Core\Authentication\BackendUserAuthentication
    {
        return GeneralUtility::makeInstance(Context::class)->getPropertyFromAspect('backend.user', 'id');
    }
}
