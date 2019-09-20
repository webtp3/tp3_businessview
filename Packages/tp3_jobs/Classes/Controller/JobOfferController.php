<?php

/*
 * This file is part of the web-tp3/tp3_jobs.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Tp3\Tp3Jobs\Controller;

/***
 *
 * This file is part of the "tp3 Jobs" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018 Thomas Ruta <email@thomasruta.de>, tp3
 *
 ***/

/**
 * JobOfferController
 */
class JobOfferController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * Contains the settings of the current extension
     *
     * @var array
     * @api
     */
    protected $settings;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface
     */
    protected $persistenceManager;

    /**
     * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
     *
     */
    protected $configurationManager;

    /**
     *
     * @var \TYPO3\CMS\Core\Page\PageRenderer
     */
    protected $pageRenderer;

    /**
    /**
     *
     * @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer
     */
    protected $cObjRenderer;

    /**
     * @var string
     */
    protected $entityNotFoundMessage = 'The requested entity could not be found.';

    /**
     * @var string
     */
    protected $unknownErrorMessage = 'An unknown error occurred. The wild monkey horde in our basement will try to fix this as soon as possible.';

    /**
     * jobOfferRepository
     *
     * @var \Tp3\Tp3Jobs\Domain\Repository\JobOfferRepository
     * @inject
     */
    protected $jobOfferRepository = null;

    /**
     * @param \TYPO3\CMS\Extbase\Mvc\RequestInterface $request
     * @param \TYPO3\CMS\Extbase\Mvc\ResponseInterface $response
     *  @return void
     * @throws \Exception
     * @override \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
     */
    public function processRequest(\TYPO3\CMS\Extbase\Mvc\RequestInterface $request, \TYPO3\CMS\Extbase\Mvc\ResponseInterface $response)
    {
        if (count($request->getArguments())> 0 &&  $request->hasArgument('jobid') && $request->getArgument('jobid') > 0) {
            //&& $this->resolveActionMethodName() == "ratingAction"
            $jobid = $request->getArgument('jobid');
        }
        try {
            parent::processRequest($request, $response);
        } catch (\TYPO3\CMS\Extbase\Property\Exception $e) {
            if ($e->getPrevious() instanceof \TYPO3\CMS\Extbase\Property\Exception\InvalidPropertyException) {
                $GLOBALS['TSFE']->pageNotFoundAndExit('404');
            } else {
                throw $e;
            }
        }
    }
    /**
     * @return void
     * @override \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
     */
    protected function callActionMethod()
    {
        try {
            parent::callActionMethod();
        } catch (\Exception $exception) {
            // This enables you to trigger the call of TYPO3s page-not-found handler by throwing \TYPO3\CMS\Core\Error\Http\PageNotFoundException
            if ($exception instanceof \TYPO3\CMS\Core\Error\Http\PageNotFoundException) {
                $GLOBALS['TSFE']->pageNotFoundAndExit($this->entityNotFoundMessage);
            }

            // $GLOBALS['TSFE']->pageNotFoundAndExit has not been called, so the exception is of unknown type.
            //  \Tp3\Tp3ratings\Logger\ExceptionLogger::log($exception, $this->request->getControllerExtensionKey(), \VendorName\ExtensionName\Logger\ExceptionLogger::SEVERITY_FATAL_ERROR);
            // If the plugin is configured to do so, we call the page-unavailable handler.
            if (isset($this->settings['usePageUnavailableHandler']) && $this->settings['usePageUnavailableHandler']) {
                $GLOBALS['TSFE']->pageUnavailableAndExit($this->unknownErrorMessage, 'HTTP/1.1 500 Internal Server Error');
            }
            // Else we append the error message to the response. This causes the error message to be displayed inside the normal page layout. WARNING: the plugins output may gets cached.
            if ($this->response instanceof \TYPO3\CMS\Extbase\Mvc\Web\Response) {
                $this->response->setStatus(500);
            }
            $this->response->appendContent($this->unknownErrorMessage);
        }
    }
    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $jobOffers = $this->jobOfferRepository->findOffers($this->settings['storagePid'] > 0  ? $this->settings['storagePid'] :  $GLOBALS['TSFE']->page['uid']);
        //  var_dump($jobOffers->first());
        $this->view->assign('jobOffers', $jobOffers);
    }

    /**
     * action show
     *
     * @param  \Tp3\Tp3Jobs\Domain\Model\JobOffer $jobOffer
     * @return void
     */
    public function showAction(\Tp3\Tp3Jobs\Domain\Model\JobOffer $jobOffer)
  //  public function showAction( $jobOffer)
    {
        if (!$jobOffer instanceof \Tp3\Tp3Jobs\Domain\Model\JobOffer) {
            $jobOffer = $this->jobOfferRepository->findJob($jobOffer);
        }

        $this->view->assign('jobOffer', $jobOffer);
    }

    /**
     * action new
     *
     * @return void
     */
    public function newAction()
    {
    }

    /**
     * action create
     *
     * @param \Tp3\Tp3Jobs\Domain\Model\JobOffer $newJobOffer
     * @return void
     */
    public function createAction(\Tp3\Tp3Jobs\Domain\Model\JobOffer $newJobOffer)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->jobOfferRepository->add($newJobOffer);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \Tp3\Tp3Jobs\Domain\Model\JobOffer $jobOffer
     * @ignorevalidation $jobOffer
     * @return void
     */
    public function editAction(\Tp3\Tp3Jobs\Domain\Model\JobOffer $jobOffer)
    {
        $this->view->assign('jobOffer', $jobOffer);
    }

    /**
     * action update
     *
     * @param \Tp3\Tp3Jobs\Domain\Model\JobOffer $jobOffer
     * @return void
     */
    public function updateAction(\Tp3\Tp3Jobs\Domain\Model\JobOffer $jobOffer)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->jobOfferRepository->update($jobOffer);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \Tp3\Tp3Jobs\Domain\Model\JobOffer $jobOffer
     * @return void
     */
    public function deleteAction(\Tp3\Tp3Jobs\Domain\Model\JobOffer $jobOffer)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->jobOfferRepository->remove($jobOffer);
        $this->redirect('list');
    }
}
