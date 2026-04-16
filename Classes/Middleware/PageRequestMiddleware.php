<?php

/*
 * This file is part of the package web-tp3/tp3-businessview.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Tp3\Tp3Businessview\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Tp3\Tp3Businessview\Backend\JsonResponseHandler;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class PageRequestMiddleware
 */
class PageRequestMiddleware implements MiddlewareInterface
{
    /**
     * Process page request
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Server\RequestHandlerInterface $handler
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $uri = $request->getServerParams()['REQUEST_URI'] ?? '';
        $routing = $request->getAttribute('routing');

        $BusinessviewRequested = strpos($uri, '/tp3Businessview/json')
            || ($routing && $routing->getRoute()
                === '4444');

        if (($BusinessviewRequested) && !$request->getAttribute('frontend.controller')) {
            // TSFE initialisieren
            //            $GLOBALS['TSFE'] = GeneralUtility::makeInstance(
            //                \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController::class,
            //                $GLOBALS['TYPO3_CONF_VARS'],
            //                0,
            //                0
            //            );
            //            $GLOBALS['TSFE']->connectToDB();
            //            $GLOBALS['TSFE']->initFEuser();
            //            $GLOBALS['TSFE']->determineId($request);
            //            $GLOBALS['TSFE']->initTemplate();
            //            $GLOBALS['TSFE']->getConfigArray();
            //            $request = $request->withAttribute('frontend.controller', $GLOBALS['TSFE']);
        }

        //        if ($BusinessviewRequested) {
        //            return GeneralUtility::makeInstance(JsonResponseHandler::class)->indexAction();
        //        }

        return $handler->handle($request);
    }

}
