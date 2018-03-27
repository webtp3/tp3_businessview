<?php
namespace Tp3\Tp3Businessview\Controller;

/***
 *
 * This file is part of the "BusinsessView" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018 Thomas Ruta <support@r-p-it.de>, tp3
 *
 ***/

/**
 * PanoramasController
 */
class PanoramasController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * action list
     * 
     * @return void
     */
    public function listAction()
    {
        $panoramas = $this->panoramasRepository->findAll();
        $this->view->assign('panoramas', $panoramas);
    }

    /**
     * action show
     * 
     * @param \Tp3\Tp3Businessview\Domain\Model\Panoramas $panoramas
     * @return void
     */
    public function showAction(\Tp3\Tp3Businessview\Domain\Model\Panoramas $panoramas)
    {
        $this->view->assign('panoramas', $panoramas);
    }
}
