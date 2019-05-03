<?php

namespace Tp3\Tp3mods\Hooks;

/*                                                                        *
 * This script is part of the TYPO3 project - inspiring people to share!  *
 *                                                                        *
 * TYPO3 is free software; you can redistribute it and/or modify it under *
 * the terms of the GNU General Public License version 3 as published by  *
 * the Free Software Foundation.                                          *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General      *
 * Public License for more details.                                       *
 *                                                                        */

use Tp3\Tp3mods\Domain\Model\Error;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

/**
 * Error handler.
 *
 * This is a bridge class for using extbase dependency injection.
 */
class ErrorHandlerHook implements \TYPO3\CMS\Core\SingletonInterface
{
    /**
     * Hook.
     *
     * @param array                                                       $params
     * @param \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController $tsfe
     *
     * @return string
     *
     * @see \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController::pageErrorHandler
     */
    public function pageNotFound(array $params, \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController $tsfe)
    {
        /** @var \Tp3\Tp3Mods\Domain\Model\Error $error */
        $error = GeneralUtility::makeInstance('Tp3\\Tp3mods\\Domain\\Model\\Error');
        $error->setReasonText($params['reasonText']);
        $error->setCurrentUrl($params['currentUrl']);
        $error->setLanguage($this->getSystemLanguage());
        $error->setUrl(GeneralUtility::getIndpEnv('TYPO3_REQUEST_URL'));
        $error->setReferer(GeneralUtility::getIndpEnv('HTTP_REFERER'));
        $error->setUserAgent(GeneralUtility::getIndpEnv('HTTP_USER_AGENT'));
        $error->setIp(GeneralUtility::getIndpEnv('REMOTE_ADDR'));
        $error->setHost(GeneralUtility::getIndpEnv('HTTP_HOST'));

        if (false === empty($tsfe->page)) {
            $error->setPid((int) $tsfe->page['uid']);
            // Access error can only happen if the page is known.
            if (isset($params['pageAccessFailureReasons']['fe_group'])) {
                $error->setStatusCode(Error::STATUS_CODE_FORBIDDEN);
            }
        }

        $this->getLogger()->debug('Call error handler', array(
            'params' => $params,
            'error' => array(
                'pid' => $error->getPid(),
                'statusCode' => $error->getStatusCode(),
            ), ));

        return $this->getErrorHandler()->handleError($error);
    }

    /**
     * Returns the error handler.
     *
     * @return \Tp3\Tp3Mods\Domain\Handler\ErrorHandler
     */
    protected function getErrorHandler()
    {
        return GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Object\ObjectManager::class)->get(Tp3\Tp3mods\ErrorHandling\Error\ErrorHandler::class);
    }

    /**
     * Get system language uid.
     *
     * @return int
     */
    protected function getSystemLanguage()
    {
        $language = GeneralUtility::_GP('L');
        if ($language === null && ExtensionManagementUtility::isLoaded('realurl')) {
            $realurlVersion = ExtensionManagementUtility::getExtensionVersion('realurl');
            if (version_compare($realurlVersion, '2.0.0', '<')) {
                $params = [];
                $ref = $this;
                $language = GeneralUtility::callUserFunction('EXT:realurl/class.tx_realurl.php:&tx_realurl->getDetectedLanguage', $params, $ref);
            }
        }

        return (int) $language;
    }

    /**
     * Get class logger.
     *
     * @return \TYPO3\CMS\Core\Log\Logger
     */
    protected function getLogger()
    {
        return \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Log\\LogManager')->getLogger(__CLASS__);
    }
}
