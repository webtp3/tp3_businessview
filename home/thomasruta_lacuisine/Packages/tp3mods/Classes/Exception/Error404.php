<?php
namespace Tp3\Tp3mods\Exception;

/***
 *
 * This file is part of the "tp3 Mods" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2017 Thomas Ruta <email@thomasruta.de>, R&amp;P IT Consulting GmbH
 *
 ***/
use TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Core\Log\Exception;
use \TYPO3\CMS\Extbase\Mvc\Request;
use \TYPO3\CMS\Extbase\Mvc\RequestInterface;
use \TYPO3\CMS\Extbase\Mvc\Response;
/**
 * Handler
 */
class Error404 {

    /**
     *
     * @var \TYPO3\CMS\Core\Page\PageRenderer
     */

    protected $pageRenderer;

    /**
     *
     * @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer
     */
    protected  $cObjRenderer;

    /**
     * @var string
     */
    protected $entityNotFoundMessage = 'The requested entity could not be found.';


    /**
     * @var string
     */
    protected $unknownErrorMessage = 'An unknown error occurred. The wild monkey horde in our basement will try to fix this as soon as possible.';

    /**
     * Registers this class as default error handler
     *
     * @param int $errorHandlerErrors The integer representing the E_* error level which should be
     */
    public function __construct()
    {


    }

     /**
     * @param \TYPO3\CMS\Extbase\Mvc\RequestInterface $request
     * @param \TYPO3\CMS\Extbase\Mvc\ResponseInterface $response
     *  @return void
     * @throws \Exception
     * @override \TYPO3\CMS\Extbase\Mvc\Controller\ErrorController
     */
        public function processError(\TYPO3\CMS\Extbase\Mvc\RequestInterface $request, \TYPO3\CMS\Extbase\Mvc\ResponseInterface $response) {

            try {
                parent::processRequest($request, $response);
            }
            catch(\TYPO3\CMS\Extbase\Property\Exception $e) {
                if ($e->getPrevious() instanceof \TYPO3\CMS\Extbase\Property\Exception\InvalidPropertyException) {
                    $this->pageNotFound($e);
                } else {
                    throw $e;
                }
            }
        }

    /**
     * @param \TYPO3\CMS\Extbase\Mvc\RequestInterface $request
     * @param \TYPO3\CMS\Extbase\Mvc\ResponseInterface $response
     *  @return void
     * @throws \Exception
     * @override \TYPO3\CMS\Extbase\Mvc\Controller\ErrorController
     */
    public function pageNotFound($praram =[], $ref =[]) {

       //#todo call  R3H6\\Error404page\\Domain\\Hook\\ErrorHandlerHook->pageNotFound
            $error404 = GeneralUtility::makeInstance(\R3H6\Error404page\Domain\Hook\ErrorHandlerHook::class);
        $error404->pageNotFound($praram , $ref);

    }
    /**
     * @return void
     * @override \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
     */
    protected function callErrorMethod() {
        try {
        //    parent::callActionMethod();
        }
        catch(\Exception $exception) {
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
}
