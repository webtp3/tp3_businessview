<?php
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
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/***************************************************************
*  Copyright notice
*
*  (c) 2003 Boris Nicolai (boris.nicolai@andavida.com)
*  (c) 2010-2014 Modification by Andreas Becker <extensions@websedit.de>
*  All rights reserved
*
*  This script is part of the Typo3 project. The Typo3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
//require_once (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('we_google_analytics') . 'class.tx_wegoogleanalytics.php');
/**
 * Hook for integrating Google Analytics into the website
 *
 * @author Andreas Becker - websedit AG <extensions@websedit.de>
 */
class GoogleAnalyticsFehook extends \Tp3\Tp3mods\Hooks\GoogleAnalytics implements SingletonInterface {
	/**
	 * Modification for pages that doesn't get cached (COA_/USER_INT)
     * @param array $params
     * @param PageRenderer $pageRenderer
     * @return string
	 */
	function intPages (array &$params, &$pageRenderer) {

        $config = isset($GLOBALS['TSFE']->tmpl->setup) ? $GLOBALS['TSFE']->tmpl->setup : [];
        if (is_array($config)
            //&& $GLOBALS['TSFE']->cObj instanceof ContentObjectRenderer
        ) {

            if (!$config["plugin."]["tx_tp3mods_tp3micro."]["settings."]['account']) {
                return;
            }
            /*
             * $_COOKIE["cookieconsent_dismissed"]
             */
            $this->conf = $config["plugin."]["tx_tp3mods_tp3micro."]["settings."];
            $params = $this->process($params);
           // $params =   $this->main($params, $config["lib."]["tp3mods."]);
        }
	}
    /**
     * Ajax handler to cookie consent.
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    function setTracking(ServerRequestInterface $request, ResponseInterface $response) {

        $config = isset($GLOBALS['TSFE']->tmpl->setup) ? $GLOBALS['TSFE']->tmpl->setup : [];
        if (is_array($config)
        ) {    // $tx_wegoogleanalytics = new tx_wegoogleanalytics();
            //$tx_wegoogleanalytics = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\Tp3\Tp3mods\Hooks\);
            $tracking = $request->getQueryParams();
           if(!$GLOBALS['TSFE'] instanceof \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController)$this->getTypoScriptFrontendController();
            $GLOBALS ['TSFE']->fe_user->setKey ('ses', 'tracking', intval($tracking["choise"]));
            $GLOBALS ['TSFE']->storeSessionData ();
            $user = \GuzzleHttp\json_encode($GLOBALS["TSFE"]->fe_user->user);
            $response->getBody()->write($user);
            return $response;
        }
    }
	/**
	 * Modification for pages on their way into the cache
	 * @param array &$params
	 * @param object &$that
	 * @return void
	 */
	function noIntPages (&$params, &$that) {
        $config = isset($GLOBALS['TSFE']->tmpl->setup) ? $GLOBALS['TSFE']->tmpl->setup : [];
        if (is_array($config)
         //   && $GLOBALS['TSFE']->cObj instanceof ContentObjectRenderer
        ) {
            if (!$config["lib."]["tx_tp3mods_tp3micro."]["settings."]['account']) {
                return;
            }
            $params = $this->process($params);

        }
	}

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
        $frontend->initFEuser();
       // $frontend->determineId();
      //  $frontend->initTemplate();
      //  $frontend->getConfigArray();
    }
}
/*
if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/we_google_analytics/class.tx_wegoogleanalytics_fehook.php']) {
	require_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/we_google_analytics/class.tx_wegoogleanalytics_fehook.php']);
}
*/
?>