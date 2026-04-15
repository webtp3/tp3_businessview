<?php

/*
 * This file is part of the package web-tp3/tp3-businessview.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Tp3\Tp3Businessview\Controller;

use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Backend\View\BackendTemplateView;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\FormProtection\FormProtectionFactory;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Psr\Http\Message\ResponseInterface;

class BusinessAdressController extends ActionController
{

    /**
     * @var IconFactory
     */
    protected IconFactory $iconFactory;

    /**
     * @var PersistenceManager
     */
    protected ?PersistenceManager $persistenceManager = null;
    /**
     * Backend Template Container.
     * Takes care of outer "docheader" and other stuff this module is embedded in.
     *
     * @var class-string|null
     */
    protected ?string $defaultViewObjectName = BackendTemplateView::class;

    /**
     * @var  rootLine
     */
    public ?rootLine $rootLine= null;





    protected function initializeAction(): void
    {
        $this->pageUid = (int)GeneralUtility::_GP('id');
        $this->persistenceManager = GeneralUtility::makeInstance(PersistenceManager::class);
        $this->pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        $this->dataMapper = GeneralUtility::makeInstance(DataMapper::class);

        $sysPageObj = GeneralUtility::makeInstance(\TYPO3\CMS\Frontend\Page\PageRepository::class);
        $this->rootLine = $sysPageObj->getRootLine($this->pageUid);
    }

    public function listAction(): ResponseInterface
    {
        $businessAdresses = $this->businessAdressRepository->findAll();
        $this->view->assign('businessAdresses', $businessAdresses);
        return $this->htmlResponse($this->view->render());

    }

    public function indexAction(): ResponseInterface
    {
        $context = GeneralUtility::makeInstance(Context::class);
        $backendUser = $context->getPropertyFromAspect('backend.user', 'id');

        if ($backendUser) {
            $storage_id = $this->conf['persistence']['storagePid'] ?? $this->pageUid;
            $urlParameters = ['id' => $storage_id, 'table' => 'tt_address', 'search_levels' => 1];
            $uriBuilder = GeneralUtility::makeInstance(UriBuilder::class);

            $url = (string)$uriBuilder->buildUriFromRoute('web_list', $urlParameters);
            $this->redirectToURI($_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/' . $url);
        }

        $businessAdresses = $this->businessAdressRepository->findAll();
        $this->view->assign('businessAdresses', $businessAdresses);
        return $this->htmlResponse($this->view->render());
    }

    public function createAction(\Tp3\Tp3Businessview\Domain\Model\BusinessAdress $adress): void
    {
        $this->addFlashMessage('The object was created.', 'created', ContextualFeedbackSeverity::WARNING);
        $this->businessadressrepository->add($adress);
        $this->persistenceManager->persistAll();
    }

    public function updateAction(\Tp3\Tp3Businessview\Domain\Model\BusinessAdress $adress): void
    {
        $this->addFlashMessage('The object was updated.', 'saved', ContextualFeedbackSeverity::WARNING);
        $this->businessadressrepository->update($adress);
        $this->persistenceManager->persistAll();
    }

    protected function registerDocheaderButtons(): void
    {
        $buttonBar = $this->view->getModuleTemplate()->getDocHeaderComponent()->getButtonBar();
        $currentRequest = $this->request;
        $moduleName = $currentRequest->getPluginName();
        $shortcutButton = $buttonBar->makeShortcutButton()
            ->setModuleName($moduleName)
            ->setGetVariables(['id' => (int)GeneralUtility::_GP('id')]);
        $buttonBar->addButton($shortcutButton);
    }
    protected function htmlResponse(?string $html = null): ResponseInterface
    {
        return $this->responseFactory->createResponse()
            ->withHeader('Content-Type', 'text/html; charset=utf-8')
            ->withBody($this->streamFactory->createStream((string)($html ?? $this->view->render())));
    }

    protected function getToken(bool $tokenOnly = false): string
    {
        $token = FormProtectionFactory::get()->generateToken('web_Tp3BusinessviewBusinessAdress', 'index');
        return $tokenOnly ? $token : '&moduleToken=' . $token;
    }
}
