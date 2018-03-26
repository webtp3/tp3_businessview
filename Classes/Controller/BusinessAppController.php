<?php
namespace Tp3\Tp3Businessview\Controller;

/***
 *
 * This file is part of the "BusinsessView" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018 Thomas Ruta &lt;support@r-p-it.de>, tp3
 *
 ***/

/**
 * BusinessAppController
 */
class BusinessAppController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * action list
     * 
     * @return void
     */
    public function listAction()
    {
        $businessApps = $this->businessAppRepository->findAll();
        $this->view->assign('businessApps', $businessApps);
    }

    /**
     * action show
     * 
     * @param \Tp3\Tp3Businessview\Domain\Model\BusinessApp $businessApp
     * @return void
     */
    public function showAction(\Tp3\Tp3Businessview\Domain\Model\BusinessApp $businessApp)
    {
        $this->view->assign('businessApp', $businessApp);
    }
}
