<?php

/*
 * This file is part of the web-tp3/tp3mods.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Tp3\Tp3mods\Controller;

/***
 *
 * This file is part of the "tp3 Mods" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018 Thomas Ruta <email@thomasruta.de>, tp3
 *
 ***/

/**
 * Tp3AdressController
 */
class Tp3AdressController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * tp3AdressRepository
     *
     * @var \Tp3\Tp3mods\Domain\Repository\Tp3AdressRepository
     * @inject
     */
    protected $tp3AdressRepository = null;

    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $tp3Adresses = $this->tp3AdressRepository->findAll();
        $this->view->assign('tp3Adresses', $tp3Adresses);
    }

    /**
     * action show
     *
     * @param \Tp3\Tp3mods\Domain\Model\Tp3Adress $tp3Adress
     * @return void
     */
    public function showAction(\Tp3\Tp3mods\Domain\Model\Tp3Adress $tp3Adress)
    {
        $this->view->assign('tp3Adress', $tp3Adress);
    }
}
