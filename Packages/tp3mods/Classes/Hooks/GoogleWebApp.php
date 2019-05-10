<?php

/*
 * This file is part of the web-tp3/tp3mods.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Tp3\Tp3mods\Hooks;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\SingletonInterface;

/***************************************************************

/**
 * Hook for integrating Google Web App into the website
 *
 */
class GoogleWebApp implements SingletonInterface
{

    /**
     * Initialize the typoscript frontend controller
     *
     * @param int $pid
     *
     * @return void
     */
    private function getTypoScriptFrontendController($pid = 1)
    {
        /** @var \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController $frontend */
        $frontend = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
            \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController::class,
            null,
            $pid,
            0
        );
        $GLOBALS['TSFE'] = $frontend;
        $frontend->connectToDB();
        \TYPO3\CMS\Frontend\Utility\EidUtility::initLanguage();
        \TYPO3\CMS\Frontend\Utility\EidUtility::initTCA();
        $frontend->checkAlternativeIdMethods();
        $frontend->initFEuser();
        $frontend->determineId();
        $frontend->initTemplate();
        $frontend->getConfigArray();
        return $frontend;
    }
    /**
     * Ajax handler to cookie consent.
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function getManifest(ServerRequestInterface $request, ResponseInterface $response)
    {
        $config = isset($GLOBALS['TSFE']->tmpl->setup) ? $GLOBALS['TSFE']->tmpl->setup : [];
        if (is_array($config)
        ) {
            /*
             * manifest.json
             */
            $manifest = $request->getQueryParams();
            if (!$GLOBALS['TSFE'] instanceof \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController) {
                $GLOBALS['TSFE'] = $this->getTypoScriptFrontendController();
                $config = isset($GLOBALS['TSFE']->tmpl->setup) ? $GLOBALS['TSFE']->tmpl->setup : [];
            }
            /*
             * {
    "name": "The Air Horner",
    "short_name": "Airhorner",
    "icons": [
        {
          "src": "/images/touch/android-launchericon-48-48.png",
          "type": "image/png",
          "sizes": "48x48"
        },

        {
          "src": "/images/touch/android-launchericon-72-72.png",
          "type": "image/png",
          "sizes": "72x72"
        },
        {
          "src": "/images/touch/android-launchericon-96-96.png",
          "type": "image/png",
          "sizes": "96x96"
        },
        {
          "src": "/images/touch/android-launchericon-144-144.png",
          "type": "image/png",
          "sizes": "144x144"
        },
        {
          "src": "/images/touch/android-launchericon-192-192.png",
          "type": "image/png",
          "sizes": "192x192"
        },
        {
          "src": "/images/touch/android-launchericon-512-512.png",
          "type": "image/png",
          "sizes": "512x512"
        }
        ],
    "start_url": "/?homescreen=1",
    "scope": "/",
    "display": "standalone",
    "background_color": "#2196F3",
    "theme_color": "#2196F3"
  }
*/
            $logo = $config['page.']['10.']['settings.']['logo.']['file'];

            //#todo image sizes
            $json = '{
                  "name": "'.$GLOBALS["TSFE"]->rootLine[0]["title"].'",
                  "short_name": "'.$GLOBALS["TSFE"]->rootLine[0]["abstract"].'",
                  "icons": [
                      {
                        "src": "'.$logo.'",
                        "type": "image/'.substr($logo , strrpos($logo,'.')+1).'",
                        "sizes": "48x48"
                      },

                      {
                        "src": "'.$logo.'",
                        "type": "image/'.substr($logo , strrpos($logo,'.')+1).'",
                        "sizes": "72x72"
                      },
                      {
                        "src": "'.$logo.'",
                        "type": "image/'.substr($logo , strrpos($logo,'.')+1).'",
                        "sizes": "96x96"
                      },
                      {
                        "src": "'.$logo.'",
                        "type": "image/'.substr($logo , strrpos($logo,'.')+1).'",
                        "sizes": "144x144"
                      },
                      {
                        "src": "'.$logo.'",
                        "type": "image/'.substr($logo , strrpos($logo,'.')+1).'",
                        "sizes": "192x192"
                      },
                      {
                        "src": "'.$logo.'",
                        "type": "image/'.substr($logo , strrpos($logo,'.')+1).'",
                        "sizes": "512x512"
                      }
                      ],
                  "start_url": "/?id=0",
                  "scope": "/",
                  "display": "standalone",
                  "background_color": "'.$GLOBALS["TSFE"]->tmpl->setup_constants["plugin."]["bootstrap_package."]["settings."]["less."]["body-bg"].'",
                  "theme_color": "'.$GLOBALS["TSFE"]->tmpl->setup_constants["plugin."]["bootstrap_package."]["settings."]["less."]["brand-primary"].'"
                }';
            //  $user = \GuzzleHttp\json_encode($GLOBALS['TSFE']->fe_user->user);
            $response->getBody()->write($json);
            return $response;
        }
    }

}
