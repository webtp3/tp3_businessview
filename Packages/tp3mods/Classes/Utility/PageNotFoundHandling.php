<?php

/*
 * This file is part of the web-tp3/tp3mods.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Tp3\Tp3mods\Utility;

use TYPO3\CMS\Core\Utility\GeneralUtility;

class PageNotFoundHandling
{

    /**
     * Detect language and redirect to 404 error page
     *
     * @param array $params "currentUrl", "reasonText" and "pageAccessFailureReasons"
     * @param \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController $tsfeObj
     */
    public function pageNotFound($params, $tsfeObj)
    {
        /*
         * If a non-existing page with a RealURL path was requested (www.mydomain.tld/foobar), a fe_group value for an empty
         * key is set:
         * $params['pageAccessFailureReasons']['fe_group'][null] = 0;
         * This is the reason why the second check was implemented.
         */
        if (!empty($params['pageAccessFailureReasons']['fe_group']) && !array_key_exists(null, $params['pageAccessFailureReasons']['fe_group'])) {
            // page access failed because of missing permissions
            header('HTTP/1.0 403 Forbidden');
            $this->initTSFE(1);
            /** @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer $cObj */
            $cObj = GeneralUtility::makeInstance('TYPO3\\CMS\\Frontend\\ContentObject\\ContentObjectRenderer');
            $tp3mods = GeneralUtility::makeInstance(\Tp3\Tp3mods\Domain\Repository\Tp3ModsRepository::class);
            $loginUrl = $cObj->typoLink_URL([
                'parameter' => $tp3mods->findByPidRaw($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['realurl']['rootpage_id']),
                'useCacheHash' => false,
                'forceAbsoluteUrl' => true,
                'additionalParams' => '&redirect_url=' . $params['currentUrl']
            ]);
            TYPO3\CMS\Core\Utility\HttpUtility::redirect($loginUrl);
        } else {
            // page not found
            // get first realurl configuration array (important for multidomain)
            $realurlConf = array_shift($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['realurl']);
            // look for language configuration
            foreach ($realurlConf['preVars'] as $conf) {
                if ($conf['GETvar'] == 'L') {
                    foreach ($conf['valueMap'] as $k => $v) {
                        // if the key is empty (e.g. default language without prefix), break
                        if (empty($k)) {
                            continue;
                        }
                        // we expect a part like "/de/" in requested url
                        //type=' . \Tp3\Tp3mods\Configuration\ExtensionConfiguration::get('doktypeNumError404page') . '&
                        if (GeneralUtility::isFirstPartOfStr($params['currentUrl'], '/' . $k . '/')) {
                            $tsfeObj->pageErrorHandler('/index.php?id=' . $GLOBALS['TYPO3_CONF_VARS']['FE']['pageNotFound_handling_redirectPageID'] . '&L=' . $v);
                        }
                    }
                }
            }
            // handle default language
            $tsfeObj->pageErrorHandler('/index.php?id=' . $GLOBALS['TYPO3_CONF_VARS']['FE']['pageNotFound_handling_redirectPageID']);
        }
    }
    /**
     * Initializes a TypoScript Frontend necessary for using TypoScript and TypoLink functions
     *
     * @param int $id
     * @param int $typeNum
     */
    protected function initTSFE($id = 1, $typeNum = 0)
    {
        \TYPO3\CMS\Frontend\Utility\EidUtility::initTCA();
        if (!is_object($GLOBALS['TT'])) {
            $GLOBALS['TT'] = new \TYPO3\CMS\Core\TimeTracker\NullTimeTracker;
            $GLOBALS['TT']->start();
        }
        $GLOBALS['TSFE'] = GeneralUtility::makeInstance('TYPO3\\CMS\\Frontend\\Controller\\TypoScriptFrontendController', $GLOBALS['TYPO3_CONF_VARS'], $id, $typeNum);
        $GLOBALS['TSFE']->sys_page = GeneralUtility::makeInstance('TYPO3\\CMS\\Frontend\\Page\\PageRepository');
        $GLOBALS['TSFE']->sys_page->init(true);
        $GLOBALS['TSFE']->connectToDB();
        $GLOBALS['TSFE']->initFEuser();
        $GLOBALS['TSFE']->determineId();
        $GLOBALS['TSFE']->initTemplate();
        $GLOBALS['TSFE']->rootLine = $GLOBALS['TSFE']->sys_page->getRootLine($id, '');
        $GLOBALS['TSFE']->getConfigArray();
        if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('realurl')) {
            $rootline = \TYPO3\CMS\Backend\Utility\BackendUtility::BEgetRootLine($id);
            $host = \TYPO3\CMS\Backend\Utility\BackendUtility::firstDomainRecord($rootline);
            $_SERVER['HTTP_HOST'] = $host;
        }
    }
}
