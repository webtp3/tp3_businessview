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
 * BusinessAdressController
 */
class BusinessAdressController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * action list
     * 
     * @return void
     */
    public function listAction()
    {
        $businessAdresses = $this->businessAdressRepository->findAll();
        $this->view->assign('businessAdresses', $businessAdresses);
    }

    /**
     * action show
     * 
     * @param \Tp3\Tp3Businessview\Domain\Model\BusinessAdress $businessAdress
     * @return void
     */
    public function showAction(\Tp3\Tp3Businessview\Domain\Model\BusinessAdress $businessAdress)
    {
        $this->view->assign('businessAdress', $businessAdress);
    }
}
